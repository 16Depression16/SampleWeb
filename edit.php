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
					<div class="cards">

						<div class="card">
							<p class="title">Решительные проблемы</p>
							<p>Дата: <span class="badge badge-info">02.02.2022</span></p>

							<div class="description">
								<p>Описание заявки:</p>
								<p class="description-size">Этот город был слишком грязный для его существования</p>
							</div>

							<p>Категория заявки: <span class="badge badge-info">Дороги</span></p>
							<p>Статус заявки: <span class="badge badge-info">Новая</span></p>
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
									<a class="create-thread create-task"> Сохранить </a>
								</div>
							</form>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<?php
	include 'layout/footer.php';
?>