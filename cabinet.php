<?php
	$files = ['city_cabinet.css'];
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
					<p class="name-fio"> Иванов Иван Александрович </p>
					<p class="email-link"> Привязанная почта: test@mail.ru</p>

					<a class="logout" href="?logout"> Выйти </a>
				</div>

				<div class="card-problems">
					<div class="problem-title">Список заявок</div>

					<div class="control">
						<a class="create-thread" href="#new_thread"> Создать заявку </a>
					</div>

					<div class="problems"> 
						<table>
							<thead>
								<tr>
									<th>Дата</th>
									<th>Название заявки</th>
									<th>Описание заявки</th>
									<th>Категория заявки</th>
									<th>Статус заявки</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>04.02.2022</td>
									<td>Решите проблему с дорогами!</td>
									<td>На участке N находятся такие-то проблемы</td>
									<td>Дороги</td>
									<td>Решена</td>
								</tr>
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
					<input type="text" name="register_fio" placeholder="Название" required="">
				</div>

				<div class="form-item">
					<textarea name="tallback-reason" placeholder="Описание" required="" maxlength="120"></textarea>
				</div>

				<div class="form-item">
					<select>
						<option selected="" disabled="">Выберите категорию</option>
						<option>Дороги</option>
						<option>Мосты</option>
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