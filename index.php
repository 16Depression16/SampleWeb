<?php 
	include 'layout/head.php';
?>
	<body>
		<section class="main">
			<div class="container">
				<h1> Сделаем лучше вместе! </h1>
				<h3> Вместе мы уже решили: <span class="counter-solved">0</span> проблем</h3>
				<a class="go-to" href="<?php if (isAuth()) { echo '/cabinet.php'; } else { echo '#goto'; } ?>"> Перейти к решению проблем </a>
			</div>
		</section>

		<section class="solved-problems">
			<div class="container">
				<h3> Примеры наших работ </h3>
				<?php 
					$select = selectAll($database, 'SELECT * FROM problems WHERE state = "Решена"');
					shuffle($select);
					if (@count($select) > 0) {
				?>
					<div class="box">
						<?php 
							$i = 0;
							foreach ($select as $key => $value) {
								$value['category'] = selectOne($database, 'SELECT * FROM category WHERE id = "'.$value['category_id'].'"')['name'];
						?>
							<div class="box-item">
								<span class="title"><?php echo $value['title']; ?></span>

								<div class="more-info">
									<span class="category"><?php echo $value['category']; ?></span>
									<span class="time"><?php echo $value['date']; ?></span>
								</div>

								<div class="image-source">
									<img class="problem-image" src="/assets/images/uploads/<?php echo $value['image_from']; ?>" data-from="/assets/images/uploads/<?php echo $value['image_from']; ?>" data-to="/assets/images/uploads/<?php echo $value['image_to']; ?>">
									<div class="problem-description">
										<?php echo $value['description']; ?>
									</div>
								</div>
							</div>
						<?php if ($i >= 4) break; ?>
						<?php $i++; } ?>
					</div>
				<?php } else { ?>
					<style type="text/css">
						section.solved-problems > div > div {
							display: block;
							text-align: left;
						}

						section.solved-problems > div > div p {
							margin-bottom: 0px;
						}
					</style>
					<div class="ot-alert ot-alert--danger">
						<h3 class="ot-alert__title">Проблем не найдено</h3>
						<p>Не найдено решенных проблем</p>
					</div>
				<?php } ?>
			</div>
		</section>

		<section class="tallback">
			<div class="container">
				<form>
					<h3> Обратная связь </h3>

					<div class="form-item">
						<input type="text" name="tallback-name" placeholder="Иванов Иван Иванович" required="">
					</div>

					<div class="form-item">
						<input type="text" name="tallback-email" placeholder="test@mail.ru" required="">
					</div>

					<div class="form-item">
						<textarea name="tallback-reason" placeholder="Ваше сообщение" required=""></textarea>
					</div>

					<button class="tallback-send">Отправить</button>
				</form>
			</div>
		</section>
	</body>

	<?php 
		if (!isAuth()) {
	?>
		<div class="modal-container" id="goto">
			<div class="modal">
				<div class="modal__details">
					<h1 class="modal__title">Окно входа</h1>
				</div>

				<div class="result-login"> </div>

				<form class="modal-content">
					<div class="form-item">
						<input type="text" name="login" placeholder="Логин" required="">
					</div>

					<div class="form-item">
						<input type="password" name="password" placeholder="Пароль" required="">
					</div>
				</form>

				<button class="modal__btn" data-type="login">Войти &rarr;</button>
				<a href="#modal-closed" class="link-2"></a>

				<p> Еще не зарегистрировались? <a href="#register"> Перейти к регистрации </a></p>
			</div>
		</div>

		<div class="modal-container" id="register">
			<div class="modal">
				<div class="modal__details">
					<h1 class="modal__title">Окно регистрации</h1>
				</div>

				<div class="result-register"> </div>

				<form class="modal-content">
					<div class="form-item">
						<input type="text" name="register_fio" placeholder="Фио" required="">
					</div>

					<div class="form-item">
						<input type="text" name="register_login" placeholder="Логин" required="">
					</div>

					<div class="form-item">
						<input type="text" name="register_email" placeholder="Email" required="">
					</div>

					<div class="form-item">
						<input type="password" name="register_password" placeholder="Пароль" required="">
					</div>

					<div class="form-item">
						<input type="password" name="register_password_repeat" placeholder="Повторите пароль" required="">
					</div>

					<div id="checklist">
						<input id="03" type="checkbox" name="register_policy" value="3">
						<label for="03">Согласие на обработку данных и политику конфиденциальности</label>
					</div>
				</form>

				<button class="modal__btn" data-type="register">Зарегистрироваться &rarr;</button>
				<a href="#modal-closed" class="link-2"></a>

				<p> Уже зарегистрировались? <a href="#goto"> Перейти к входу </a></p>
			</div>
		</div>
	<?php
		}
	?>

<?php 
	include 'layout/footer.php';
?>