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
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		
		<li class="services-section-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<?if($arItem["PREVIEW_PICTURE"]["SRC"]):?><a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="item-image" style="background-image: url(<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>)"></a><?endif;?>
			
			<div class="item-content">
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><h5><?=$arItem["NAME"]?></h5></a>
				<a class="btn-service-price"><?=$arItem["PROPERTIES"]["price"]["VALUE"]?></a>
				<p><?=$arItem["PREVIEW_TEXT"]?></p>
			</div>
		</li>
	<?endforeach;?>	
</ul>

<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br />

	<div class="services-pagination">
		<?=$arResult["NAV_STRING"]?>
	</div>
<?endif;?>




