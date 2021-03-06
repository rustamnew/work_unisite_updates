<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if(!CModule::IncludeModule("iblock"))
	return;
	
use \Bitrix\Main\Config\Option;

$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/team.xml"; 
$iblockCode = "team_".WIZARD_SITE_ID;
$iblockType = "content"; 

CWizardUtil::ReplaceMacros($iblockXMLFile, array("SITE_ID" => WIZARD_SITE_ID));

$new_items_id = WIZARD_SITE_ID;
$new_items_id = preg_replace("/[a-z]/i", "", $new_items_id);

CWizardUtil::ReplaceMacros($iblockXMLFile, array("ITEM_ID" => $new_items_id));

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
$iblockID = false; 
$iblockSectionID = false; 
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
		"team",
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
		"FIELDS" => array ( 
			'IBLOCK_SECTION' => array ( 
				'IS_REQUIRED' => 'N', 
				'DEFAULT_VALUE' => '', 
			), 
			'ACTIVE' => array ( 
				'IS_REQUIRED' => 'Y', 
				'DEFAULT_VALUE' => 'Y', 
			), 
			'ACTIVE_FROM' => array ( 
				'IS_REQUIRED' => 'N', 
				'DEFAULT_VALUE' => '=today', 
			), 
			'ACTIVE_TO' => array ( 
				'IS_REQUIRED' => 'N', 
				'DEFAULT_VALUE' => '', 
			), 
			'SORT' => array ( 
				'IS_REQUIRED' => 'N', 
				'DEFAULT_VALUE' => '', 
			), 
			'NAME' => array ( 
				'IS_REQUIRED' => 'Y', 
				'DEFAULT_VALUE' => '', 
			), 
			'PREVIEW_PICTURE' => array ( 
				'IS_REQUIRED' => 'N', 
				'DEFAULT_VALUE' => array ( 
					'FROM_DETAIL' => 'Y', 
					'SCALE' => 'Y', 
					'WIDTH' => '600', 
					'HEIGHT' => '600', 
					'IGNORE_ERRORS' => 'N', 
				), 
			), 
			'PREVIEW_TEXT_TYPE' => array ( 
				'IS_REQUIRED' => 'Y', 
				'DEFAULT_VALUE' => 'text', 
			), 
			'PREVIEW_TEXT' => array ( 
				'IS_REQUIRED' => 'N', 
				'DEFAULT_VALUE' => '', 
			), 
			'DETAIL_PICTURE' => array ( 
				'IS_REQUIRED' => 'N', 
				'DEFAULT_VALUE' => array ( 
					'SCALE' => 'N', 
					'WIDTH' => '', 
					'HEIGHT' => '', 
					'IGNORE_ERRORS' => 'N', 
				), 
			), 
			'DETAIL_TEXT_TYPE' => array ( 
				'IS_REQUIRED' => 'Y', 
				'DEFAULT_VALUE' => 'text', 
			), 
			'DETAIL_TEXT' => array ( 
				'IS_REQUIRED' => 'N', 
				'DEFAULT_VALUE' => '', 
			), 
			'XML_ID' => array ( 
				'IS_REQUIRED' => 'N', 
				'DEFAULT_VALUE' => '', 
			), 
			'CODE' => array ( 
				'IS_REQUIRED' => 'Y', 
				'DEFAULT_VALUE' => array(
					"UNIQUE" => "Y", 
					"TRANSLITERATION" => "Y",
					"TRANS_LEN" => "300",
					"TRANS_CASE" => "L",
					"TRANS_SPACE" => "-",
					"TRANS_OTHER" => "-",
				), 
			),  
			'SECTION_CODE' => array(
				'IS_REQUIRED' => 'N',
				'DEFAULT_VALUE' => array(
					'UNIQUE' => 'Y',
					'TRANSLITERATION' => 'Y',
					'TRANS_LEN' => 100,
					'TRANS_CASE' => 'L',
					'TRANS_SPACE' => '-',
					'TRANS_OTHER' => '-',
					'TRANS_EAT' => 'Y',
					'USE_GOOGLE' => 'N',
				),
			),
			'TAGS' => array ( 
				'IS_REQUIRED' => 'N', 
				'DEFAULT_VALUE' => '', 
			), 
		), 
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

$arProperty = array();
$dbProperty = CIBlockProperty::GetList(array(), array("IBLOCK_ID" => $iblockID));
	while($arProp = $dbProperty->Fetch())
	$arProperty[$arProp["CODE"]] = $arProp["ID"];

	CUserOptions::SetOption("form", "form_element_".$iblockID, array("tabs" => 'edit1--#--'.GetMessage("WZD_OPTION_0").'--,--NAME--#--'.GetMessage("WZD_OPTION_1").'--,--DETAIL_PICTURE--#--'.GetMessage("WZD_OPTION_2").'--,--SECTIONS--#--'.GetMessage("WZD_OPTION_3").'--;--cedit3--#--'.GetMessage("WZD_OPTION_4").'--,--PROPERTY_'.$arProperty["social_show"].'--#--'.GetMessage("WZD_OPTION_5").'--,--cedit3_csection1--#----'.GetMessage("WZD_OPTION_6").'--,--PROPERTY_'.$arProperty["social1_icon"].'--#--'.GetMessage("WZD_OPTION_7").'--,--PROPERTY_'.$arProperty["social1_url"].'--#--'.GetMessage("WZD_OPTION_8").'--,--cedit3_csection2--#----'.GetMessage("WZD_OPTION_9").'--,--PROPERTY_'.$arProperty["social2_icon"].'--#--'.GetMessage("WZD_OPTION_10").'--,--PROPERTY_'.$arProperty["social2_url"].'--#--'.GetMessage("WZD_OPTION_11").'--,--cedit3_csection3--#----'.GetMessage("WZD_OPTION_12").'--,--PROPERTY_'.$arProperty["social3_icon"].'--#--'.GetMessage("WZD_OPTION_13").'--,--PROPERTY_'.$arProperty["social3_url"].'--#--'.GetMessage("WZD_OPTION_14").'--,--cedit3_csection4--#----'.GetMessage("WZD_OPTION_15").'--,--PROPERTY_'.$arProperty["social4_icon"].'--#--'.GetMessage("WZD_OPTION_16").'--,--PROPERTY_'.$arProperty["social4_url"].'--#--'.GetMessage("WZD_OPTION_17").'--,--cedit3_csection5--#----'.GetMessage("WZD_OPTION_18").'--,--PROPERTY_'.$arProperty["social5_icon"].'--#--'.GetMessage("WZD_OPTION_19").'--,--PROPERTY_'.$arProperty["social5_url"].'--#--'.GetMessage("WZD_OPTION_20").'--;--cedit4--#--'.GetMessage("WZD_OPTION_21").'--,--PREVIEW_TEXT--#--'.GetMessage("WZD_OPTION_22").'--,--DETAIL_TEXT--#--'.GetMessage("WZD_OPTION_23").'--;--cedit2--#--'.GetMessage("WZD_OPTION_24").'--,--PROPERTY_'.$arProperty["skill_show"].'--#--'.GetMessage("WZD_OPTION_25").'--,--PROPERTY_'.$arProperty["skill_title"].'--#--'.GetMessage("WZD_OPTION_26").'--,--cedit2_csection1--#----'.GetMessage("WZD_OPTION_27").'--,--PROPERTY_'.$arProperty["skill1name"].'--#--'.GetMessage("WZD_OPTION_28").'--,--PROPERTY_'.$arProperty["skill1value"].'--#--'.GetMessage("WZD_OPTION_29").'--,--cedit2_csection2--#----'.GetMessage("WZD_OPTION_30").'--,--PROPERTY_'.$arProperty["skill2name"].'--#--'.GetMessage("WZD_OPTION_31").'--,--PROPERTY_'.$arProperty["skill2value"].'--#--'.GetMessage("WZD_OPTION_32").'--,--cedit2_csection3--#----'.GetMessage("WZD_OPTION_33").'--,--PROPERTY_'.$arProperty["skill3name"].'--#--'.GetMessage("WZD_OPTION_34").'--,--PROPERTY_'.$arProperty["skill3value"].'--#--'.GetMessage("WZD_OPTION_35").'--,--cedit2_csection4--#----'.GetMessage("WZD_OPTION_36").'--,--PROPERTY_'.$arProperty["skill4name"].'--#--'.GetMessage("WZD_OPTION_37").'--,--PROPERTY_'.$arProperty["skill4value"].'--#--'.GetMessage("WZD_OPTION_38").'--,--cedit2_csection5--#----'.GetMessage("WZD_OPTION_39").'--,--PROPERTY_'.$arProperty["skill5name"].'--#--'.GetMessage("WZD_OPTION_40").'--,--PROPERTY_'.$arProperty["skill5value"].'--#--'.GetMessage("WZD_OPTION_41").'--;--cedit1--#--'.GetMessage("WZD_OPTION_42").'--,--ID--#--'.GetMessage("WZD_OPTION_43").'--,--ACTIVE--#--'.GetMessage("WZD_OPTION_44").'--,--SORT--#--'.GetMessage("WZD_OPTION_45").'--,--CODE--#--'.GetMessage("WZD_OPTION_46").'--;--";}'));


CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/include/iblock_id_link.php", array("team_IBLOCK_ID" => $iblockID));

?>