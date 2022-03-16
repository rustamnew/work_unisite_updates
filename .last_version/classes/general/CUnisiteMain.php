<?
\Bitrix\Main\Loader::includeModule('iblock');
use Bitrix\Main\Loader;
use Bitrix\Main\SystemException;

Class CUnisiteMain{
	function MainProperty($main_settings_id, $main_settings_element_id){

		$db_props = CIBlockElement::GetProperty($main_settings_id, $main_settings_element_id, "sort", "asc", array());

		$GLOBAL = [];
		$prev_code = false;
		$i = 1;
		while($ar_props = $db_props->Fetch()){
			if ($ar_props["CODE"] == $prev_code) {

				if(gettype($GLOBAL["global_info"][$ar_props["CODE"]]) == 'string') {
					$savedProp = $GLOBAL["global_info"][$ar_props["CODE"]];
					$GLOBAL["global_info"][$ar_props["CODE"]] = [];
					$GLOBAL["global_info"][$ar_props["CODE"]][0] = $savedProp;
				}
				
				$GLOBAL["global_info"][$ar_props["CODE"]][$i] = $ar_props["VALUE"];
				
				$i = $i + 1;
			} else {
				$GLOBAL["global_info"][$ar_props["CODE"]] = $ar_props["VALUE"];
				$i = 1;
			}
			$prev_code = $ar_props["CODE"];
		}

		return $GLOBAL;
	}
	function MainHeaderAssets(){

		Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/bootstrap.min.css');
		Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/fonts/fontawesome/css/all.min.css');
		Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/fonts/flaticon/css/flaticon.css');
		Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/owl.carousel.min.css');
		Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/owl.theme.default.min.css');
		Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/lity.min.css');
		Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/fancybox.css');
		Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/transitions.css');
		Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/animate.css');
		Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/style.css');
		Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/responsive.css');
		

		Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/jquery-3.5.1.min.js');
		Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/popper.min.js');
		Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/bootstrap.min.js');
		Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/owl.carousel.min.js');
		Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/lity.min.js');
		Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/jquery.waypoints.min.js');
		Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/jquery.counterup.min.js');
		Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/fancybox.umd.js');
		Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/gridify.js');
		Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/main.js');

		return true;
	}
}
?>