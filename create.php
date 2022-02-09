<?php
	$files = ['admin.css', 'admin-create.css'];
	$jsFiles = ['admin.js', 'admin-control.js'];

	include 'layout/head.php';

	if (isset($_GET['logout'])) {
		session_destroy();
		exit('<script type="text/javascript">location.href="/";</script>');
	}

	if (!isAuth() || !isAdmin()) {
		exit('<script type="text/javascript">location.href="/";</script>');
	}

	$data = selectAll($database, 'SELECT * FROM category ORDER BY id DESC');

?>
<body>
	<div class="container">
		<div class="admin-content">
			<div class="admin-nav">
				<span>Навигация</span>
				<a class="active-cat" href="admin.php#category">Категории</a>
				<a href="admin.php#applications">Заявки</a>
			</div>

			<div class="content">
				<div class="make-1" id = "category">
					<h3> Создание категории </h3>

					<div class="result category-response"></div>

					<form class="category-content" method="POST">
						<div class="form-item">
							<input type="text" name="category_title" placeholder="Название" required="">
						</div>

						<div class="control">
							<a class="create-thread create-task"> Создать </a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
<?php
	include 'layout/footer.php';
?>