<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("������ ������");?>

<section class="page-404-area">
	<div class="container">
		<div class="row">
			<div class="col-md-8 offset-md-2 text-center">
				<h2>������ ������</h2>
				<p>�������� �������� ��� �������� �������� �� �������</p>
				<a href="<?=SITE_DIR?>" class="btn-1">��������� �� �������</a>
			</div>
		</div>
	</div>
</section>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>