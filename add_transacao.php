<?php

	session_start();
	require 'config.php';

	if(isset($_POST['tipo'])) {
		$tipo = $_POST['tipo'];
		$valor = str_replace(",", ".", $_POST['valor']);
		$valor = floatval($valor);

		$sql = $pdo->prepare("INSERT INTO historico (id_conta, tipo, valor, data_operacao) VALUES (:id_conta, :tipo, :valor, NOW())");
		$sql->bindValue(":id_conta", $_SESSION['banco']);
		$sql->bindValue(":tipo", $tipo);
		$sql->bindValue(":valor", $valor);
		$sql->execute();

		if($tipo == '0') {

			//Deposito
			$sql = $pdo->prepare("UPDATE contas SET saldo = saldo + :valor WHERE id = :id");
			$sql->bindValue(":valor", $valor);
			$sql->bindValue(":id", $_SESSION['banco']);		
			$sql->execute();

		}
		else{

			//Saque
			$sql = $pdo->prepare("UPDATE contas SET saldo = saldo - :valor WHERE id = :id");
			$sql->bindValue(":valor", $valor);
			$sql->bindValue(":id", $_SESSION['banco']);		
			$sql->execute();

		}

		header("Location: index.php");
		exit;
	}



?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Transação</title>
</head>
<body>

	<h2 align="center"> Tipo de Transação </h2><br/>

	<hr/><br/>

	<form method="POST" align="center" >
		<select name="tipo" >
			<option value="0"> Deposito </option>
			<option value="1"> Saque</option>
		</select><br/><br/>

		Valor:<br/><br/>
		<input type="text" name="valor" pattern="[0-9.,]{1,}" placeholder="Valor"  ><br/><br/>

		<input type="submit" value="Ok">
	</form>
</body>
</html>