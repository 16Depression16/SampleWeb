<?php
	$files = ['admin.css', 'admin_edit.css'];
	$jsFiles = ['admin-control.js'];

	include 'layout/head.php';

	if (isset($_GET['logout'])) {
		session_destroy();
		exit('<script type="text/javascript">location.href="/";</script>');
	}

	echo '<script type="text/javascript">
			location.hash = "#applications";
		</script>';

	if (!isAuth() || !isAdmin()) {
		exit('<script type="text/javascript">location.href="/";</script>');
	}

	$invoice = selectOne($database, 'SELECT * FROM problems WHERE id = "'.$_GET['id'].'"');
	$category = null;
	if ($invoice != null) {
		$category = selectOne($database, 'SELECT * FROM category WHERE id = "'.$invoice['category_id'].'"');
	}
?>
<body>
	<div class="container">
		<div class="admin-content">
			<div class="admin-nav">
				<span>Навигация</span>
				<a href="admin.php#category">Категории</a>
				<a class="active-cat" href="admin.php#applications">Заявки</a>
			</div>

			<div class="content">
				<div class="make-1" id = "applications">
					<h3> Редактирование заявки </h3>

					<?php if ($invoice != null && $category != null) { ?>
						<?php if ($invoice['state'] == 'Новая') { ?>
							<div class="result category-response"></div>

							<div class="cards">

								<div class="card">
									<p class="title">Решительные проблемы</p>
									<p>Дата: <span class="badge badge-info"><?php echo $invoice['date']; ?></span></p>

									<div class="description">
										<p>Описание заявки:</p>
										<p class="description-size"><?php echo $invoice['description']; ?></p>
									</div>

									<p>Категория заявки: <span class="badge badge-info"><?php echo $category['name']; ?></span></p>
									<p>Статус заявки: <span class="badge badge-info"><?php echo $invoice['state']; ?></span></p>
								</div>

								<div class="card">
									<form class="category-content">
										<div class="form-item">
											<label class="state">Выберите статус заявки</label>

											<select name="state">
												<option selected="" disabled="">Выберите статус</option>
												<option value="solved">Решена</option>
												<option value="declined">Отклонена</option>
											</select>
										</div>

										<div class="form-item reason">
											<textarea name="reason" placeholder="Описание отказа" required="" maxlength="120"></textarea>
										</div>

										<div class="form-item file">
											<input class="input-file" type="file" name="PhotoFile" id="PhotoFile" placeholder="Название" required="">
											<label for="PhotoFile" class="input-trigger">Выбрать файл</label>
										</div>

										<div class="control">
											<a class="create-thread save-problem"> Сохранить </a>
										</div>
									</form>
								</div>

							</div>
						<?php  } else { ?>
							<style type="text/css">
								h3 {border: none !important; padding-bottom: 0px !important;}
								p { margin-block-end: 0px }
							</style>
							<div class="ot-alert ot-alert--danger">
								<h3 class="ot-alert__title">Пусто</h3>
								<p>Рассмотрение данной проблемы было заверешно имеется статус: <b><?php echo $invoice['state']; ?></b></p>
							</div>
						<?php } ?>
					<?php } else { ?>
						<style type="text/css">
							h3 {border: none !important; padding-bottom: 0px !important;}
							p { margin-block-end: 0px }
						</style>
						<div class="ot-alert ot-alert--danger">
							<h3 class="ot-alert__title">Пусто</h3>
							<p>Данной проблемы не найдено</p>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</body>
<?php
	include 'layout/footer.php';
?>