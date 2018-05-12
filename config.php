<?php

	try {

		$pdo = new PDO("mysql:dbname=projeto_caixaeletronico;host=localhost", "root", "" );
	}
	catch(PDOException $e) {

		echo "Falha de conexão com o banco de dados!".$e->getMessage();

	}

?>