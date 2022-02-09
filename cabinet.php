<?php
	$files = ['city_cabinet.css'];
	$jsFiles = ['cabinet.js'];

	include 'layout/head.php';

	if (isset($_GET['logout'])) {
		session_destroy();
		exit('<script type="text/javascript">location.href="/";</script>');
	}

	if (!isAuth()) {
		exit('<script type="text/javascript">location.href="/";</script>');
	}
?>
	<body>
		<section class="cabinet">
			<div class="container">
				<div class="card-info">
					<p class="name-fio"> <?php echo $_SESSION['user']['name']; ?> </p>
					<p class="email-link"> Привязанная почта: <?php echo $_SESSION['user']['email']; ?></p>

					<a class="logout" href="?logout"> Выйти </a>
				</div>

				<div class="card-problems">
					<div class="problem-title">Список заявок</div>

					<div class="control">
						<a class="create-thread" href="#new_thread"> Создать заявку </a>
					</div>

					<div class="response"> </div>
					<div class="response-server"> </div>

					<div class="problems"> 
						<table style="display: none;">
							<thead>
								<tr>
									<th>Дата</th>
									<th>Название заявки</th>
									<th>Описание заявки</th>
									<th>Категория заявки</th>
									<th>Статус заявки</th>
									<th>Действие</th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</section>
	</body>

	<div class="modal-container" id="new_thread">
		<div class="modal">
			<div class="modal__details">
				<h1 class="modal__title">Создание заявки</h1>
			</div>

			<div class="result"> </div>

			<form class="modal-content">
				<div class="form-item">
					<input type="text" name="local-title" placeholder="Название" required="">
				</div>

				<div class="form-item">
					<textarea name="local-description" placeholder="Описание" required="" maxlength="120"></textarea>
				</div>

				<div class="form-item">
					<select name="local-category">
						<option selected="" disabled="">Выберите категорию</option>
						<?php
							$category = selectAll($database, 'SELECT * FROM category');

							foreach ($category as $value) {
								echo '<option value="'.$value['name'].'">'.$value['name'].'</option>';
							}
						?>
					</select>
				</div>

				<div class="form-item">
					<input class="input-file" type="file" name="PhotoFile" id="PhotoFile" placeholder="Название" required="">
					<label for="PhotoFile" class="input-trigger">Выбрать файл</label>
				</div>
			</form>

			<button class="modal__btn" data-type="register_thread">Отправить</button>
			<a href="#modal-closed" class="link-2"></a>
		</div>
	</div>

<?php 
	include 'layout/footer.php';
?>