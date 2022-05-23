<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<ul class="services-section-list">
	<?foreach($arResult["SECTIONS"] as $arSection):?>
		<?
		$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
		$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));
		?>

		<li class="services-section-item" id="<? echo $this->GetEditAreaId($arSection['ID']); ?>">
			<a href="<?=$arSection["SECTION_PAGE_URL"]?>" class="item-image" style="background-image: url(<?=$arSection["PICTURE"]["SRC"]?>)"></a>

			<div class="item-content">
				<a href="<?=$arSection["SECTION_PAGE_URL"]?>"><h5><?=$arSection["NAME"]?></h5></a>
				<p><?=$arSection["DESCRIPTION"]?></p>
			</div>
		</li>
	<?endforeach;?>	
</ul>




