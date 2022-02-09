<?php 
	@session_start();
	include $_SERVER['DOCUMENT_ROOT'].'/app/functions/user.php'; 
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>ProCity</title>

		<link rel="stylesheet" type="text/css" href="/assets/css/city.css">
		<?php
			// Опция для загрузки дополнительных css файлов
			if (@count($files) > 0) {
				foreach ($files as $css) {
					echo '<link rel="stylesheet" type="text/css" href="/assets/css/'.$css.'">';
				}
			}
		?>
		<script type="text/javascript" src="/assets/js/jquery.js"></script>
		<script type="text/javascript" src="/assets/js/sample.js"></script>
		<?php
			// Опция для загрузки дополнительных css файлов
			if (@count($jsFiles) > 0) {
				foreach ($jsFiles as $js) {
					echo '<script type="text/javascript" src="/assets/js/'.$js.'"></script>';
				}
			}
		?>
	</head>

	<header>
		<div class="container">
			<div class="header-box">
				<div class="logo">LOGO</div>
				<div class="navigation">
					<a href="/">Главная</a>

					<?php if (!isAuth()) { ?>
						<a href="#goto">Вход</a>
					<?php } else { ?>
						<a href="/cabinet.php">Личный кабинет</a>
					<?php } ?>

					<?php if (isAdmin()) { ?>
						<a href="/admin.php">Админ-панель</a>
					<?php } ?>
				</div>
			</div>
		</div>
	</header>