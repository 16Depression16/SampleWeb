<?php

	// database connection handler for requests to database
	function connect () {
		$host = '127.0.0.1';
		$user = 'root';
		$password = ''; 
		$dbname = 'procity'; // database name where storage tables

		@$mysqli = new mysqli($host, $user, $password, $dbname);

		if ($mysqli->connect_errno) {
			echo "
				<style> 
					body { 
						background: linear-gradient(#53697680, #292E4980), url(/assets/images/city.jpg) no-repeat; 
						background-size: cover; 
					} 
					.error {
						text-align:center; padding: 20px; 
						background: #DC143C; 
						color: white; 
						font-family: calibri; 
						width: 300px; 
						margin: auto; font-size: 18px; 
						border-radius: 10px; 
						box-shadow: 0 12.5px 20px 1px rgb(0 0 0 / 30%); 
						margin-top: 20%;
					}
				</style>

				<p class=\"error\">
					Ошибка при подключении к базе данных: <b>".$mysqli->connect_error.'</b>
				</p>
			';
			exit();
		}

		return $mysqli; // get database out function for requests.
	}

	// Select in table all rows
	function selectAll ($mysqli, $sql = '') {
		$query = $mysqli->query($sql);
		return ($query) ? $query->fetch_all(MYSQLI_ASSOC) : null;
	}

	// Select in table all rows
	function selectOne ($mysqli, $sql = '') {
		$query = $mysqli->query($sql);
		return ($query) ? $query->fetch_assoc() : null;
	}

	// Update or delete or insert sql request
	function sql_request ($mysqli = '', $sql = '') {
		return $mysqli->query($sql);
	}

?>