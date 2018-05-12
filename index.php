<?php

	session_start();
	require 'config.php';

	if(isset($_SESSION['banco']) && !empty($_SESSION['banco'])) {
		$id = $_SESSION['banco'];

		$sql = $pdo->prepare("SELECT * FROM contas WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		if($sql->rowCount() > 0) {

			$dados = $sql->fetch();

		}
		else{
			header("Location: login.php");
			exit;
		}

	}else{
		header("Location: login.php");
		exit;
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Index</title>
</head>
<body>
	<h1 align="center"> Banco de Itapipoca </h1><br/>
	<hr/><br/>

	Titular: <?php echo $dados['titular'];?><br/>
	Agência: <?php echo $dados['agencia']; ?><br/>
	Conta: <?php echo $dados['conta']; ?><br/>
	Saldo: R$ <?php echo $dados['saldo']; ?><br/><br/>

	 <a href="add_transacao.php"><button>Movimentação / Extrato</button></a><br/><br/>	
	 <a href="sair.php"><button>Sair</button></a><br/>
	<hr/>

	<h2 align="center">Movimentação / Extrato </h2><br/>

	<table align="center" border="1" width="400">
		<tr>
			<th>Data</th>
			<th>valor</th>
		</tr>

		<?php

			$sql = $pdo->prepare("SELECT * FROM historico WHERE id_conta = :id_conta");
			$sql->bindValue(":id_conta", $id);
			$sql->execute();

			if($sql->rowCount() > 0) {

				foreach ($sql->fetchAll() as $item) {
					?>
						<tr>
							<td><?php echo date('d/m/y H:i', strtotime($item['data_operacao']));?></td>
							<td>
								<?php if($item['tipo'] == '0'): ?>
									<font color="green"><?php echo $item['valor'] ?></font
								<?php else: ?>
									<font color="red"><?php echo $item['valor'] ?></font
								<?php endif;?>
							</td>
						</tr>
					<?php
				}

			}

		?>
	</table>

</body>
</html>