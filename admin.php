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

	if (isset($_GET['delete'])) {
		if ($_SESSION['lastDeletedID'] != $_GET['delete']) {
			$_SESSION['lastDeletedID'] = $_GET['delete'];

			$getLine = selectOne($database, 'SELECT * FROM category WHERE id = "'.$_GET['delete'].'"');

			if ($getLine == null) {
				$msg = '<div class="ot-alert ot-alert--danger">
				<h3 class="ot-alert__title">Ошибка</h3>
				<p>Категория не найдена или удалена ранее</p>
				</div>';
			} else {
				$msg = '<div class="ot-alert ot-alert--success">
				<h3 class="ot-alert__title">Успех</h3>
				<p>Категория удалена, а так-же связанные заявки с этой категорией.</p>
				</div>';

				sql_request($database, 'DELETE FROM category WHERE id = "'.$_GET['delete'].'"');
				sql_request($database, 'DELETE FROM problems WHERE category_id = "'.$_GET['delete'].'"');
			}
		}
	}

	$data = selectAll($database, 'SELECT * FROM category ORDER BY id DESC');
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
							<a class="create_category" href="create.php">Создать</a>
						</div>

						<div class="bootstrap">
							<div class="result category-response">
								<?php if ($msg != null) echo $msg; ?>
							</div>
							<?php if ($data != null) { ?>
								<table>
									<thead>
										<tr>
											<th>Номер</th>
											<th>Категория</th>
											<th>Управление</th>
										</tr>
									</thead>
									<tbody>
										<?php
											foreach ($data as $key => $value) {
												echo '<tr>
														<td>'.$value['id'].'</td>
														<td>'.$value['name'].'</td>
														<td><a class="delete" onclick="confirm(\"Вы действительно хотите удалить данную категорию?\")" data-link="?delete='.$value['id'].'#category" data-number="'.$value['id'].'">Удалить</a></td>
													</tr>';
											}
										?>
									</tbody>
								</table>
							<?php } else { ?>
								<style type="text/css">
									h3 {border: none !important; padding-bottom: 0px !important;}
									p { margin-block-end: 0px }
								</style>
								<div class="ot-alert ot-alert--danger">
							      <h3 class="ot-alert__title">Пусто</h3>
							      <p>Категорий не найдено. Создайте категорию</p>
							    </div>
							<?php } ?>
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
									<a href="edit.php#applications">Редактировать</a>
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
									<a href="edit.php#applications">Редактировать</a>
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
									<a href="edit.php#applications">Редактировать</a>
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