<?php
/* Copyright (C) 2003-2007 Rodolphe Quiedeville <rodolphe@quiedeville.org>
 * Copyright (C) 2004-2010 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2005-2009 Regis Houssin        <regis@dolibarr.fr>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 *	\file       htdocs/core/boxes/box_contacts.php
 *	\ingroup    societes
 *	\brief      Module to show box of contacts
 */

include_once DOL_DOCUMENT_ROOT.'/core/boxes/modules_boxes.php';
include_once DOL_DOCUMENT_ROOT.'/contact/class/contact.class.php';


/**
 * Class to manage the box to show last contacts
 */
class box_contacts extends ModeleBoxes
{
	var $boxcode="lastcontacts";
	var $boximg="object_contact";
	var $boxlabel;
	var $depends = array("societe");

	var $db;
	var $param;

	var $info_box_head = array();
	var $info_box_contents = array();

	/**
     *  Constructor
	 */
	function __construct()
	{
		global $langs;
		$langs->load("boxes");

		$this->boxlabel=$langs->transnoentitiesnoconv("BoxLastContacts");
	}

	/**
	 *  Load data into info_box_contents array to show array later.
	 *
	 *  @param	int		$max        Maximum number of records to load
     *  @return	void
	 */
	function loadBox($max=5)
	{
		global $user, $langs, $db, $conf;
		$langs->load("boxes");

		$this->max=$max;

		$this->info_box_head = array('text' => $langs->trans("BoxTitleLastModifiedContacts",$max));

		if ($user->rights->societe->lire)
		{
			$sql = "SELECT sp.rowid, sp.name, sp.firstname, sp.civilite, sp.datec, sp.tms, sp.fk_soc,";
			$sql.= " s.nom as socname";
			$sql.= " FROM ".MAIN_DB_PREFIX."socpeople as sp";
			$sql.= " LEFT JOIN ".MAIN_DB_PREFIX."societe as s ON sp.fk_soc = s.rowid";
			if (! $user->rights->societe->client->voir && ! $user->societe_id) $sql.= ", ".MAIN_DB_PREFIX."societe_commerciaux as sc";
			$sql.= " WHERE sp.entity IN (".getEntity('societe', 1).")";
			if (! $user->rights->societe->client->voir && ! $user->societe_id) $sql.= " AND sp.rowid = sc.fk_soc AND sc.fk_user = " .$user->id;
			if ($user->societe_id) $sql.= " AND sp.rowid = $user->societe_id";
			$sql.= " ORDER BY sp.tms DESC";
			$sql.= $db->plimit($max, 0);

			$result = $db->query($sql);

			if ($result)
			{
				$num = $db->num_rows($result);

				$contactstatic=new Contact($db);
				$societestatic=new Societe($db);

				$i = 0;
				while ($i < $num)
				{
					$objp = $db->fetch_object($result);
					$datec=$db->jdate($objp->datec);
					$datem=$db->jdate($objp->tms);

					$contactstatic->name=$objp->name;
                    $contactstatic->firstname=$objp->firstname;
                    $contactstatic->civilite_id=$objp->civilite;

                    $societestatic->id=$objp->fk_soc;
                    $societestatic->name=$objp->socname;

					$this->info_box_contents[$i][0] = array('td' => 'align="left" width="16"',
                    'logo' => $this->boximg,
                    'url' => DOL_URL_ROOT."/contact/fiche.php?id=".$objp->rowid);

					$this->info_box_contents[$i][1] = array('td' => 'align="left"',
                    'text' => $contactstatic->getFullName($langs,1),
                    'url' => DOL_URL_ROOT."/contact/fiche.php?id=".$objp->rowid);

                    $this->info_box_contents[$i][2] = array('td' => 'align="left" width="16"',
    				'logo' => ($objp->fk_soc > 0?'company':''),
    				'url' => ($objp->fk_soc > 0?DOL_URL_ROOT."/societe/soc.php?socid=".$objp->fk_soc:''));

                    $this->info_box_contents[$i][3] = array('td' => 'align="left"',
                    'text' => $societestatic->name,
                    'url' => DOL_URL_ROOT."/societe/soc.php?socid=".$objp->fk_soc);

					$this->info_box_contents[$i][4] = array('td' => 'align="right"',
					'text' => dol_print_date($datem, "day"));

					$i++;
				}

				if ($num==0) $this->info_box_contents[$i][0] = array('td' => 'align="center"','text'=>$langs->trans("NoRecordedContacts"));
			}
			else {
				$this->info_box_contents[0][0] = array(	'td' => 'align="left"',
    	        										'maxlength'=>500,
	            										'text' => ($db->error().' sql='.$sql));
			}
		}
		else {
			$this->info_box_contents[0][0] = array('align' => 'left',
            'text' => $langs->trans("ReadPermissionNotAllowed"));
		}

	}

	/**
	 *	Method to show box
	 *
	 *	@param	array	$head       Array with properties of box title
	 *	@param  array	$contents   Array with properties of box lines
	 *	@return	void
	 */
	function showBox($head = null, $contents = null)
	{
		parent::showBox($this->info_box_head, $this->info_box_contents);
	}

}

?>
