<?php
	//se não existir a função de usuário adm, então redireciona a pessoa para outra página. 
	session_start();
	if (!isset($_SESSION['id_master'])) {
		header("location:index.php");
	}

	require_once 'Classes/usuarios.php';
	$us= new Usuario("projeto_sc", "localhost", "root", "");
	$dados = $us->buscarTodosUsuarios();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="CSS/dados.css">
	<title>Guia de Compras</title>
</head>
<body>
	<nav>
		<ul>
			<li> <a href="index.php">Início</a></li>
			<li><a href="discussao.php">Discussão</a></li>
			<li> <a href="sair.php">Sair</a></li>
		</ul>
	</nav>

	<table>
		<tr id="titulo">
			<td>ID</td>
			<td>NOME</td>
			<td>E-MAIL</td>
			<td>COMENTÁRIOS</td>
		</tr>
	<?php
		if (count($dados)>0) {
			foreach ($dados as $value) { ?>
				<tr>
					<td><?php echo $value['id']; ?></td>
					<td><?php echo $value['nome']; ?></td>
					<td><?php echo $value['email']; ?></td>
					<td><?php echo $value['quantidade']; ?></td>
				</tr>
	<?php	}
		}else {
			echo "Ainda não há usuários cadastrados. ";
		}
	?>
	</table>

</body>
</html>