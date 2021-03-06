<?php
/***************************************************************
*  Copyright notice
*  
*  (c) 2004 Morten Hansen (mth@daimi.au.dk)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is 
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
* 
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
* 
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/** 
 * Class that adds the wizard icon.
 *
 * @author	Morten Hansen <mth@daimi.au.dk>
 */



class tx_metafeedit_pi1_wizicon {
	function proc($wizardItems)	{
		global $LANG;

		$LL = $this->includeLocalLang();

		$wizardItems["plugins_tx_metafeedit_pi1"] = array(
			"icon"=>t3lib_extMgm::extRelPath("meta_feedit")."pi1/ce_wiz.gif",
			"title"=>$LANG->getLLL("pi1_title",$LL),
			"description"=>$LANG->getLLL("pi1_plus_wiz_description",$LL),
			"params"=>"&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=meta_feedit_pi1"
		);

		return $wizardItems;
	}
	function includeLocalLang()	{
	    $typoVersion = t3lib_div::int_from_ver($GLOBALS['TYPO_VERSION']);
        if ($typoVersion >= 3008000) {
            $LOCAL_LANG = $GLOBALS['LANG']->includeLLFile(t3lib_extMgm::extPath('meta_feedit').'locallang.xml',FALSE);
        } else {
            include(t3lib_extMgm::extPath('meta_feedit').'locallang.php');
        }
		return $LOCAL_LANG;
	}
}



if (defined("TYPO3_MODE") && $TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/meta_feedit/pi1/class.tx_metafeedit_pi1_wizicon.php"])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/meta_feedit/pi1/class.tx_metafeedit_pi1_wizicon.php"]);
}

?>
