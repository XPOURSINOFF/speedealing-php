<?php
/* Copyright (C) 2011 Regis Houssin  <regis@dolibarr.fr>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 */

/**
 *	    \file       htdocs/paypal/admin/import.php
 *      \ingroup    paypal
 *      \brief      Setup page for paypal module
 *		\version    $Id$
 */

require("../../main.inc.php");
require_once(DOL_DOCUMENT_ROOT."/paypal/lib/paypal.lib.php");
require_once(DOL_DOCUMENT_ROOT."/lib/admin.lib.php");

if (!$user->admin)
    accessforbidden();

$langs->load("paypal");
$langs->load("admin");


/*
 * Actions
 */
if (preg_match('/set_(.*)/',$action,$reg))
{
    $code=$reg[1];
    if (dolibarr_set_const($db, $code, 1, 'chaine', 0, '', $conf->entity) > 0)
    {
        Header("Location: ".$_SERVER["PHP_SELF"]);
        exit;
    }
    else
    {
        dol_print_error($db);
    }
}

if (preg_match('/del_(.*)/',$action,$reg))
{
    $code=$reg[1];
    if (dolibarr_del_const($db, $code, $conf->entity) > 0)
    {
        Header("Location: ".$_SERVER["PHP_SELF"]);
        exit;
    }
    else
    {
        dol_print_error($db);
    }
}


/*
 * View
 */


$form=new Form($db);

llxHeader('',$langs->trans("PaypalSetup"));


$linkback='<a href="'.DOL_URL_ROOT.'/admin/modules.php">'.$langs->trans("BackToModuleList").'</a>';
print_fiche_titre(' - '.$langs->trans("ModuleSetup"),$linkback,'paypal_logo@paypal');
print '<br />';

$head=paypaladmin_prepare_head();

dol_fiche_head($head, 'import', $langs->trans("ModuleSetup"));


print '<table class="nobordernopadding" width="100%"><tr>';

print '<td>'.$langs->trans("PaypalTransactionDesc").'</td>';

print '<td align="right">'."\n";
if ($conf->use_javascript_ajax)
{
	print ajax_constantonoff('PAYPAL_ENABLE_TRANSACTION_MANAGEMENT');
}
else
{
	if($conf->global->PAYPAL_ENABLE_TRANSACTION_MANAGEMENT == 0)
	{
		print '<a href="'.$_SERVER['PHP_SELF'].'?action=set_PAYPAL_ENABLE_TRANSACTION_MANAGEMENT">'.img_picto($langs->trans("Disabled"),'off').'</a>';
	}
	else if($conf->global->PAYPAL_ENABLE_TRANSACTION_MANAGEMENT == 1)
	{
		print '<a href="'.$_SERVER['PHP_SELF'].'?action=del_PAYPAL_ENABLE_TRANSACTION_MANAGEMENT">'.img_picto($langs->trans("Enabled"),'on').'</a>';
	}
}
print '</td></tr>';
print '</table>';

print '<br />';

print '<table class="nobordernopadding" width="100%">';

$var=true;
print '<table class="noborder" width="100%">';
print '<tr class="liste_titre">';
print '<td>'.$langs->trans("Parameters").'</td>'."\n";
print '<td align="center" width="20">&nbsp;</td>';
print '<td align="center" width="100">'.$langs->trans("Value").'</td>'."\n";
print '</tr>';

print '</table>';

$db->close();

llxFooter('$Date$ - $Revision$');
?>