<?php

	// database connection handler for requests to database
	function connect () {
		$host = '127.0.0.1';
		$user = 'root';
		$password = ''; 
		$dbname = 'procity'; // database name where storage tables

		$mysqli = new mysqli($host, $user, $password, $dbname);
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