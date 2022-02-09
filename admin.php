<?php
	$files = ['admin.css'];
	$jsFiles = ['admin.js'];

	include 'layout/head.php';

	if (isset($_GET['logout'])) {
		session_destroy();
		exit('<script type="text/javascript">location.href="/";</script>');
	}

	if (!isAuth() || !isAdmin()) {
		exit('<script type="text/javascript">location.href="/";</script>');
	}
?>
	<body>
		<div class="container">
			<div class="admin-content">
				<div class="admin-nav">
					<span>Навигация</span>
					<a class="active-cat" data-button="choose" href="#category">Категории</a>
					<a data-button="choose" href="#applications">Заявки</a>
				</div>

				<div class="content">
					<div class="make-1" id = "category">
						<h3> Категории </h3>

						<div class="controller">
							<a class="create_category" href="create.html">Создать</a>
						</div>

						<div class="bootstrap">
							<table>
								<thead>
									<tr>
										<th>Номер</th>
										<th>Категория</th>
										<th>Управление</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>1</td>
										<td>Дороги</td>
										<td><a class="delete" href="?delete#category">Удалить</a></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

					<div class="make-1" id = "applications">
						<h3> Заявки </h3>
						<div class="cards">

							<div class="card">
								<p class="title">Решительные проблемы</p>
								<p>Дата: <span class="badge badge-info">02.02.2022</span></p>
								
								<div class="description">
									<p>Описание заявки:</p>
									<p class="description-size">Этот город был слишком грязный для его существования</p>
								</div>

								<p>Категория заявки: <span class="badge badge-info">Дороги</span></p>
								<p>Статус заявки: <span class="badge badge-info">Решена</span></p>

								<div class="control">
									<a href="edit.html#applications">Редактировать</a>
								</div>
							</div>

							<div class="card">
								<p class="title">Решительные проблемы</p>
								<p>Дата: <span class="badge badge-info">02.02.2022</span></p>
								
								<div class="description">
									<p>Описание заявки:</p>
									<p class="description-size">Этот город был слишком грязный для его существования</p>
								</div>

								<p>Категория заявки: <span class="badge badge-info">Дороги</span></p>
								<p>Статус заявки: <span class="badge badge-info">Решена</span></p>

								<div class="control">
									<a href="edit.html#applications">Редактировать</a>
								</div>
							</div>

							<div class="card">
								<p class="title">Решительные проблемы</p>
								<p>Дата: <span class="badge badge-info">02.02.2022</span></p>
								
								<div class="description">
									<p>Описание заявки:</p>
									<p class="description-size">Этот город был слишком грязный для его существования</p>
								</div>

								<p>Категория заявки: <span class="badge badge-info">Дороги</span></p>
								<p>Статус заявки: <span class="badge badge-info">Решена</span></p>

								<div class="control">
									<a href="edit.html#applications">Редактировать</a>
								</div>
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