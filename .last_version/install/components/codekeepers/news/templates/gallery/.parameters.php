<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"NAME" => Array(
		"NAME" => GetMessage("NAME"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
	),
	"TITLE" => Array(
		"NAME" => GetMessage("TITLE"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
	),
	"SUBTITLE" => Array(
		"NAME" => GetMessage("SUBTITLE"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
	),
	"SHOW_MODE" => Array(
		"NAME" => GetMessage("SHOW_MODE"),
		"TYPE" => "LIST",
		"DEFAULT" => "one",
		"VALUES" => array(
			"one" => GetMessage("SHOW_MODE_ONE"),
			"slider" => GetMessage("SHOW_MODE_SLIDER"),
		),
		"REFRESH" => "Y"
	),
);

?>