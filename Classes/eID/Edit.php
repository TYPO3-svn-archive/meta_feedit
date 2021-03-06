<?php
/**
 * Ajax call to meta_feedit
 * @example http://desktop.ard.fr/?eID=tx_metafeedit&tx_metafeedit[exporttype]=PDF&cmd[usagers]=edit&rU[usagers]=2458
 * @example http://desktop.ard.fr/?eID=tx_metafeedit&tx_metafeedit[exporttype]=PDF
 */
require_once(t3lib_extMgm::extPath('meta_feedit').'pi1/class.tx_metafeedit_pi1.php');
require_once(t3lib_extMgm::extPath('meta_feedit').'Classes/eID/Tools.php');

ob_end_flush();
//error_log('Edit.php');
if (!$GLOBALS['g_TT']) $GLOBALS['g_TT']=microtime(true);
$TTA=array();
$TTA[]="<br/>eID Elapsed Time :".(microtime(true)-$GLOBALS['g_TT']).' s';
// We call script
// we initialize page id from calling page.
//$TTA=microtime(true);		
$GLOBALS['TSFE']->id=0;
// we create front end....
$TTA[]="<br/>eID before TSFE creation :".(microtime(true)-$GLOBALS['g_TT']).' s';
$GLOBALS["TSFE"]= Tx_MetaFeedit_EID_Tools::getTSFE();
/*t3lib_div::makeInstance('tslib_fe',
		$TYPO3_CONF_VARS,
		0,
		0,
		1);*/
$TTA[]="<br/>eID before FeUser creation Elapsed Time :".(microtime(true)-$GLOBALS['g_TT']).' s';
// we initialize frontend user
$feUserObj = Tx_MetaFeedit_EID_Tools::initFeUser();
$TTA[]="<br/>eID after FeUser creation Elapsed Time :".(microtime(true)-$GLOBALS['g_TT']).' s';
$GLOBALS['TSFE']->additionalJavaScript=array();
$GLOBALS["TSFE"]->fe_user=$feUserObj;
//$GLOBALS["TSFE"]->checkAlternativeIdMethods();
//$GLOBALS["TSFE"]->clear_preview();
$GLOBALS["TSFE"]->determineId();
//error_log(print_r($GLOBALS["TSFE"]->fe_user,true));
if (is_array($GLOBALS['TSFE']->fe_user->user)) {
	$GLOBALS['TSFE']->loginUser = 1;
}
$GLOBALS["TSFE"]->initTemplate();
$GLOBALS["TSFE"]->getConfigArray();	
$TTA[]="<br/>eID before cObj creation Elapsed Time :".(microtime(true)-$GLOBALS['g_TT']).' s';
$GLOBALS['TSFE']->cObj = t3lib_div::makeInstance('tslib_cObj');	// Local cObj.
$GLOBALS['TSFE']->cObj->start(array());

// Render charset must be UTF8 for json encode !
$GLOBALS['TSFE']->renderCharset='utf-8';
// Get TypoScript for  Controller
//$tsparserObj = t3lib_div::makeInstance('t3lib_TSparser');
//$ts = $GLOBALS['TYPO3_CONF_VARS']['FE']['defaultTypoScript_setup.'][43];
// Parsing  Typoscript
//$tsparserObj->parse($ts);
$module=t3lib_div::_GP('module');
// Report path is either in fileadmin/reports or in module Reports path
$configFile=t3lib_div::_GP('config')?($module?'typo3conf/ext/'.$module.'/Resources/Private/Reports/':'').t3lib_div::_GP('config').'.json':'';
//echo $configFile;
$TTA[]="<br/>eID before meta creation Elapsed Time :".(microtime(true)-$GLOBALS['g_TT']).' s';
$c=new tx_metafeedit_pi1();
$TTA[]="<br/>eID after meta creation Elapsed Time :".(microtime(true)-$GLOBALS['g_TT']).' s';
$c->cObj=$GLOBALS['TSFE']->cObj;
$content= $c->main('','',$configFile);
$TTA[]="<br/>eID after meta call Elapsed Time :".(microtime(true)-$GLOBALS['g_TT']).' s';
$scripts1=implode(chr(10),$GLOBALS['TSFE']->additionalHeaderData);
$scripts2="";
// We update  user int scripts here if necessary
if ($GLOBALS['TSFE']->isINTincScript())	
{
	$GLOBALS['TSFE']->content=$content;
	$GLOBALS['TSFE']->INTincScript();
	$content=$GLOBALS['TSFE']->content;
	$scripts2=implode(chr(10),$GLOBALS['TSFE']->additionalHeaderData);
}

echo '<html><head><link href="'.t3lib_extMgm::siteRelPath('meta_feedit').'res/css/meta_feedit.css" rel="stylesheet" type="text/css"/>'.$scripts1.$scripts2.'</head><body>'.$content.'</body></html>';
unset($c);
//We handle uniqueId cookie to inform client that load has succeeded
/*$uniqueId=t3lib_div::_GP('uniqueid');
if ($uniqueId) {
	$uniqueIdArray=explode('*',$uniqueId);
	//error_log('Edit :'.print_r($uniqueIdArray,true));
	setcookie($uniqueIdArray[0], $uniqueIdArray[1], time()+3600);
}*/
?>