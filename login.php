<?php

	session_start();
	require 'config.php';

	if(isset($_POST['agencia']) && !empty($_POST['agencia'])) {

		$agencia = addslashes($_POST['agencia']);
		$conta = addslashes($_POST['conta']);
		$senha = md5(addslashes($_POST['senha']));

		$sql = $pdo->prepare("SELECT * FROM contas WHERE agencia = :agencia AND conta = :conta AND senha = :senha");
		$sql->bindValue(":agencia", $agencia);
		$sql->bindValue(":conta", $conta);
		$sql->bindValue(":senha", $senha);
		$sql->execute();

		if($sql->rowCount() > 0){

			$sql = $sql->fetch();
			$_SESSION['banco'] = $sql['id'];
			header("Location: index.php");
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Login</title>
</head>
<body>

	<h1 align="center"> Login </h1><br/>

	<hr/><br/>

	<form method="POST" align="center" >
		
		Agência:<br/>
		<input type="text" name="agencia" placeholder="0000" ><br/><br/>

		Conta:<br/>
		<input type="text" name="conta" placeholder="0000" ><br/><br/>

		Senha:<br/>
		<input type="password" name="senha" placeholder="Password"><br/><br/>

		<input type="submit" value="Logar"><br/>
	</form>
</body>
</html>