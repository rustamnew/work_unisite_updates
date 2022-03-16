<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arServices = Array(
	"main" => Array(
		"NAME" => GetMessage("SERVICE_MAIN_SETTINGS"),
		"STAGES" => Array(
			"files.php", // Copy bitrix files
			"template.php", // Install template
			//"theme.php", // Install theme
			"group.php", // Install group
			"settings.php",
		),
	),

	"iblock" => Array(
		"NAME" => GetMessage("SERVICE_IBLOCK"),
		"STAGES" => Array(
			"types.php",
			"about.php",
			"banner_main.php",
			"banner_call-to-action.php",
			"career.php",
			"discounts.php",
			"faq.php",
			"features1.php",
			"features-block.php",
			"feedback.php",
			"gallery.php",
			"goods.php",
			"licence.php",
			"messengers.php",
			"news.php",
			"plan.php",
			"projects.php",
			"reviews.php",
			"settings_main.php",
			"sidebar-contacts.php",
			"social.php",
			"team.php",
			"services.php",
		),
	),
);
?>

