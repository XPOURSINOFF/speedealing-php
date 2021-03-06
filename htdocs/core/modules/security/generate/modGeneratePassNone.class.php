<?php
/* Copyright (C) 2006-2011 Laurent Destailleur <eldy@users.sourceforge.net>
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
 * or see http://www.gnu.org/
 */

/**
 *      \file       htdocs/core/modules/security/generate/modGeneratePassNone.class.php
 *      \ingroup    core
 *      \brief      File to manage no password generation.
 */

require_once DOL_DOCUMENT_ROOT .'/core/modules/security/generate/modules_genpassword.php';


/**
 *	    \class      modGeneratePassNone
 *		\brief      Class to generate a password according to rule 'no password'
 */
class modGeneratePassNone extends ModeleGenPassword
{
	var $id;
	var $length;

	var $db;
	var $conf;
	var $lang;
	var $user;


	/**
	 *	Constructor
	 *
	 *  @param		DoliDB		$db			Database handler
	 *	@param		Conf		$conf		Handler de conf
	 *	@param		Translate	$langs		Handler de langue
	 *	@param		User		$user		Handler du user connecte
	 */
	function __construct($db, $conf, $langs, $user)
	{
		$this->id = "none";
		$this->length = 0;

		$this->db=$db;
		$this->conf=$conf;
		$this->langs=$langs;
		$this->user=$user;
	}

	/**
	 *		Return description of module
	 *
 	 *      @return     string      Description of text
	 */
	function getDescription()
	{
		global $langs;
		return $langs->trans("PasswordGenerationNone");
	}

	/**
	 * 		Return an example of password generated by this module
	 *
 	 *      @return     string      Example of password
	 */
	function getExample()
	{
		return $this->langs->trans("None");
	}

	/**
	 * 		Build new password
	 *
 	 *      @return     string      Return a new generated password
	 */
	function getNewGeneratedPassword()
	{
		return "";
	}

	/**
	 * 		Validate a password
	 *
	 *		@param		string	$password	Password to check
 	 *      @return     int					0 if KO, >0 if OK
	 */
	function validatePassword($password)
	{
		return 1;
	}

}

?>
