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

<div class="shop-page py-100">
	<div class="container">
		<div class="row">
			<?foreach($arResult["ITEMS"] as $arItem):?>
				<?
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				?>

				<div class="col-md-6 col-lg-4 col-6">
					<div class="shop-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
						<div class="item-img">
							<img class="img-fluid" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="01 Shop">
							<div class="box-more d-flex align-items-center">
								<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="btn-1"><?echo GetMessage("DETAIL")?></a>
							</div>
						</div>
						<div class="item-text text-center">
							<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="open-item-shop"><h4><?=$arItem["NAME"]?></h4></a>
							<span><?=$arItem["PROPERTIES"]["price"]["VALUE"];?></span>
						</div>
					</div>
				</div>
			<?endforeach;?>	
			
			<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
				<div class="col-md-12">
					<?=$arResult["NAV_STRING"]?>
				</div>
			<?endif;?>
		</div>
	</div>
</div>