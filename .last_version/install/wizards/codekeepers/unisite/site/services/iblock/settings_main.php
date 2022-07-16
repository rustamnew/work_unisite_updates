<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if(!CModule::IncludeModule("iblock"))
	return;
use \Bitrix\Main\Config\Option;
if(!defined("WIZARD_SITE_ID")) return;
if(!defined("WIZARD_SITE_DIR")) return;
if(!defined("WIZARD_SITE_PATH")) return;
if(!defined("WIZARD_TEMPLATE_ID")) return;
if(!defined("WIZARD_TEMPLATE_ABSOLUTE_PATH")) return;
if(!defined("WIZARD_THEME_ID")) return;


$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/settings_main.xml"; 
$iblockCode = "settings_main_".WIZARD_SITE_ID;
$iblockType = "settings"; 


CWizardUtil::ReplaceMacros($iblockXMLFile, array("SITE_ID" => WIZARD_SITE_ID));

$new_items_id = WIZARD_SITE_ID;
$new_items_id = preg_replace("/[a-z]/i", "", $new_items_id);

CWizardUtil::ReplaceMacros($iblockXMLFile, array("ITEM_ID" => $new_items_id));

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
$iblockID = false; 
if ($arIBlock = $rsIBlock->Fetch())
{
	$iblockID = $arIBlock["ID"]; 
	if (WIZARD_REINSTALL_DATA)
	{
		CIBlock::Delete($arIBlock["ID"]); 
		$iblockID = false; 
	}
}

if($iblockID == false)
{
	$permissions = Array(
			"1" => "X",
			"2" => "R"
		);
	$dbGroup = CGroup::GetList($by = "", $order = "", Array("STRING_ID" => "content_editor"));
	if($arGroup = $dbGroup -> Fetch())
	{
		$permissions[$arGroup["ID"]] = 'W';
	};
	$iblockID = WizardServices::ImportIBlockFromXML(
		$iblockXMLFile,
		$iblockCode,
		$iblockType,
		WIZARD_SITE_ID,
		$permissions
	);

	if ($iblockID < 1)
		return;
	
	//WizardServices::SetIBlockFormSettings($iblockID, Array ( 'tabs' => GetMessage("W_IB_GROUP_PHOTOG_TAB1").$REAL_PICTURE_PROPERTY_ID.GetMessage("W_IB_GROUP_PHOTOG_TAB2").$rating_PROPERTY_ID.GetMessage("W_IB_GROUP_PHOTOG_TAB3").$vote_count_PROPERTY_ID.GetMessage("W_IB_GROUP_PHOTOG_TAB4").$vote_sum_PROPERTY_ID.GetMessage("W_IB_GROUP_PHOTOG_TAB5").$APPROVE_ELEMENT_PROPERTY_ID.GetMessage("W_IB_GROUP_PHOTOG_TAB6").$PUBLIC_ELEMENT_PROPERTY_ID.GetMessage("W_IB_GROUP_PHOTOG_TAB7"), ));
	
	//IBlock fields
	$iblock = new CIBlock;
	$arFields = Array(
		"ACTIVE" => "Y",
		"FIELDS" => array ( 'IBLOCK_SECTION' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ), 'ACTIVE' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => 'Y', ), 'ACTIVE_FROM' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '=today', ), 'ACTIVE_TO' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ), 'SORT' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ), 'NAME' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => '', ), 'PREVIEW_PICTURE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => array ( 'FROM_DETAIL' => 'N', 'SCALE' => 'N', 'WIDTH' => '', 'HEIGHT' => '', 'IGNORE_ERRORS' => 'N', ), ), 'PREVIEW_TEXT_TYPE' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => 'text', ), 'PREVIEW_TEXT' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ), 'DETAIL_PICTURE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => array ( 'SCALE' => 'N', 'WIDTH' => '', 'HEIGHT' => '', 'IGNORE_ERRORS' => 'N', ), ), 'DETAIL_TEXT_TYPE' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => 'text', ), 'DETAIL_TEXT' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ), 'XML_ID' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ), 'CODE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ), 'TAGS' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ), ), 
		"CODE" => $iblockCode, 
		"XML_ID" => $iblockCode,
		"NAME" => $iblock->GetArrayByID($iblockID, "NAME"),
		//"NAME" => "[".WIZARD_SITE_ID."] ".$iblock->GetArrayByID($iblockID, "NAME")
	);
	
	$iblock->Update($iblockID, $arFields);
}
else
{
	$arSites = array(); 
	$db_res = CIBlock::GetSite($iblockID);
	while ($res = $db_res->Fetch())
		$arSites[] = $res["LID"]; 
	if (!in_array(WIZARD_SITE_ID, $arSites))
	{
		$arSites[] = WIZARD_SITE_ID;
		$iblock = new CIBlock;
		$iblock->Update($iblockID, array("LID" => $arSites));
	}
}

// iblock user fields
	$dbSite = CSite::GetByID(WIZARD_SITE_ID);
	if($arSite = $dbSite -> Fetch()) $lang = $arSite["LANGUAGE_ID"];
	if(!strlen($lang)) $lang = "ru";
	WizardServices::IncludeServiceLang("settings_main.php", $lang);
	$arProperty = array();
	$dbProperty = CIBlockProperty::GetList(array(), array("IBLOCK_ID" => $iblockID));
	while($arProp = $dbProperty->Fetch())
		$arProperty[$arProp["CODE"]] = $arProp["ID"];


CUserOptions::SetOption("form", "form_element_".$iblockID, array("tabs" => 'edit1--#--'.GetMessage("WZD_OPTION_0").'--,--ID--#--'.GetMessage("WZD_OPTION_1").'--,--DATE_CREATE--#--'.GetMessage("WZD_OPTION_2").'--,--TIMESTAMP_X--#--'.GetMessage("WZD_OPTION_3").'--,--ACTIVE--#--'.GetMessage("WZD_OPTION_4").'--,--ACTIVE_FROM--#--'.GetMessage("WZD_OPTION_5").'--,--ACTIVE_TO--#--'.GetMessage("WZD_OPTION_6").'--,--NAME--#--'.GetMessage("WZD_OPTION_7").'--,--CODE--#--'.GetMessage("WZD_OPTION_8").'--,--SORT--#--'.GetMessage("WZD_OPTION_9").'--;--cedit2--#--'.GetMessage("WZD_OPTION_10").'--,--PROPERTY_'.$arProperty["header_type"].'--#--'.GetMessage("WZD_OPTION_90").'--,--PROPERTY_'.$arProperty["header_logo1"].'--#--'.GetMessage("WZD_OPTION_11").'--,--PROPERTY_'.$arProperty["header_logo2"].'--#--'.GetMessage("WZD_OPTION_12").'--,--PROPERTY_'.$arProperty["header_shop_show"].'--#--'.GetMessage("WZD_OPTION_91").'--,--PROPERTY_'.$arProperty["header_button_show"].'--#--'.GetMessage("WZD_OPTION_13").'--,--PROPERTY_'.$arProperty["header_button_text"].'--#--'.GetMessage("WZD_OPTION_14").'--,--cedit2_csection1--#----'.GetMessage("WZD_OPTION_20").'--,--PROPERTY_'.$arProperty["header_extra_logo"].'--#--'.GetMessage("WZD_OPTION_22").'--,--PROPERTY_'.$arProperty["header_extra_show"].'--#--'.GetMessage("WZD_OPTION_21").'--,--PROPERTY_'.$arProperty["header_extra_title_contacts"].'--#--'.GetMessage("WZD_OPTION_23").'--,--PROPERTY_'.$arProperty["header_extra_description"].'--#--'.GetMessage("WZD_OPTION_25").'--,--cedit2_csection2--#----'.GetMessage("WZD_OPTION_15").'--,--PROPERTY_'.$arProperty["header_calltoaction_show"].'--#--'.GetMessage("WZD_OPTION_16").'--,--PROPERTY_'.$arProperty["header_calltoaction_icon"].'--#--'.GetMessage("WZD_OPTION_19").'--,--PROPERTY_'.$arProperty["header_calltoaction_phone"].'--#--'.GetMessage("WZD_OPTION_17").'--,--PROPERTY_'.$arProperty["header_calltoaction_description"].'--#--'.GetMessage("WZD_OPTION_18").'--;--cedit3--#--'.GetMessage("WZD_OPTION_26").'--,--PROPERTY_'.$arProperty["footer_logo"].'--#--'.GetMessage("WZD_OPTION_27").'--,--PROPERTY_'.$arProperty["footer_description"].'--#--'.GetMessage("WZD_OPTION_28").'--,--PROPERTY_'.$arProperty["footer_show_menu1"].'--#--'.GetMessage("WZD_OPTION_29").'--,--PROPERTY_'.$arProperty["footer_title_menu1"].'--#--'.GetMessage("WZD_OPTION_31").'--,--PROPERTY_'.$arProperty["footer_show_menu2"].'--#--'.GetMessage("WZD_OPTION_30").'--,--PROPERTY_'.$arProperty["footer_title_menu2"].'--#--'.GetMessage("WZD_OPTION_32").'--,--PROPERTY_'.$arProperty["footer_show_contacts"].'--#--'.GetMessage("WZD_OPTION_92").'--,--PROPERTY_'.$arProperty["footer_title_contacts"].'--#--'.GetMessage("WZD_OPTION_33").'--,--PROPERTY_'.$arProperty["footer_title_email"].'--#--'.GetMessage("WZD_OPTION_36").'--,--PROPERTY_'.$arProperty["footer_title_address"].'--#--'.GetMessage("WZD_OPTION_34").'--,--PROPERTY_'.$arProperty["footer_title_phone"].'--#--'.GetMessage("WZD_OPTION_35").'--;--cedit5--#--'.GetMessage("WZD_OPTION_80").'--,--PROPERTY_'.$arProperty["color1"].'--#--'.GetMessage("WZD_OPTION_81").'--,--PROPERTY_'.$arProperty["color2"].'--#--'.GetMessage("WZD_OPTION_82").'--,--PROPERTY_'.$arProperty["color3"].'--#--'.GetMessage("WZD_OPTION_83").'--,--PROPERTY_'.$arProperty["color_overlay"].'--#--'.GetMessage("WZD_OPTION_93").'--;--cedit1--#--'.GetMessage("WZD_OPTION_38").'--,--cedit1_csection2--#----'.GetMessage("WZD_OPTION_43").'--,--PROPERTY_'.$arProperty["contacts_title_phone"].'--#--'.GetMessage("WZD_OPTION_69").'--,--PROPERTY_'.$arProperty["contacts_phone_show"].'--#--'.GetMessage("WZD_OPTION_42").'--,--PROPERTY_'.$arProperty["icon_phone"].'--#--'.GetMessage("WZD_OPTION_70").'--,--PROPERTY_'.$arProperty["contacts_phone"].'--#--'.GetMessage("WZD_OPTION_43").'--,--cedit1_csection3--#----'.GetMessage("WZD_OPTION_40").'--,--PROPERTY_'.$arProperty["contacts_email_show"].'--#--'.GetMessage("WZD_OPTION_39").'--,--PROPERTY_'.$arProperty["contacts_title_email"].'--#--'.GetMessage("WZD_OPTION_71").'--,--PROPERTY_'.$arProperty["icon_email"].'--#--'.GetMessage("WZD_OPTION_72").'--,--PROPERTY_'.$arProperty["contacts_email"].'--#--'.GetMessage("WZD_OPTION_40").'--,--cedit1_csection4--#----'.GetMessage("WZD_OPTION_46").'--,--PROPERTY_'.$arProperty["contacts_title_address"].'--#--'.GetMessage("WZD_OPTION_73").'--,--PROPERTY_'.$arProperty["contacts_address_show"].'--#--'.GetMessage("WZD_OPTION_45").'--,--PROPERTY_'.$arProperty["icon_address"].'--#--'.GetMessage("WZD_OPTION_74").'--,--PROPERTY_'.$arProperty["contacts_address"].'--#--'.GetMessage("WZD_OPTION_46").'--,--cedit1_csection1--#----'.GetMessage("WZD_OPTION_85").'--,--PROPERTY_'.$arProperty["contacts_block_background"].'--#--'.GetMessage("WZD_OPTION_86").'--,--PROPERTY_'.$arProperty["contacts_block_name"].'--#--'.GetMessage("WZD_OPTION_87").'--,--PROPERTY_'.$arProperty["contacts_block_title"].'--#--'.GetMessage("WZD_OPTION_88").'--,--PROPERTY_'.$arProperty["contacts_block_subtitle"].'--#--'.GetMessage("WZD_OPTION_89").'--;--cedit4--#--'.GetMessage("WZD_OPTION_77").'--,--PROPERTY_'.$arProperty["captcha_show"].'--#--'.GetMessage("WZD_OPTION_79").'--,--PROPERTY_'.$arProperty["google_cap_code"].'--#--'.GetMessage("WZD_OPTION_78").'--;--";}'));



$arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM","PROPERTY_*");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
$arFilter = Array("IBLOCK_ID"=>$iblockID, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
while($ob = $res->GetNextElement()){ 
 $arFields = $ob->GetFields();  
}
$element_id = $arFields["ID"];

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/include/iblock_id_link.php", array("settings_main_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/include/iblock_id_link.php", array("settings_main_ELEMENT_ID" => $element_id));
?>