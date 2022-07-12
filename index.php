<!--------------------PHP---------------->
<?php
	require_once 'Classes/usuarios.php';
	session_start();
	if(isset($_SESSION['id_usuario'])){
		
		$us = new Usuario("projeto_sc", "localhost", "root", "");
		//sempre que logamos no sistema, o id é guardado na session
		$informacoes = $us->buscarDadosUser($_SESSION['id_usuario']);	

	}elseif (isset($_SESSION['id_master'])) {
		$us = new Usuario("projeto_sc", "localhost", "root", "");
		$informacoes = $us->buscarDadosUser($_SESSION['id_master']);	
	}

?>
<!------------------------------------>

<!DOCTYPE html>
<html lang = "pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel = "stylesheet" href="CSS/estilo.css"/>
	<title>Hamilton_de_Paula</title>
</head>
<body>
	<nav>
		<ul>
			<?php
				if(isset($_SESSION['id_master'])){ ?>
					<li> <a href="dados.php">Dados</a></li>
		<?php	}
			?>
			<li> <a href="discussao.php">Discussões</a></li>
			<?php
				//a variável informações só é criada quando existe uma sessão.
				if(isset($informacoes)){ ?> 
					<li> <a href="sair.php">Sair</a></li>
			<?php	}else{ ?>
					<li> <a href="entrar.php">Entrar</a></li>
			<?php	}
			?>
		</ul>
	</nav>

	<?php
		if(isset($_SESSION['id_master']) || isset($_SESSION['id_usuario'])){
	?>	<h2>
			<?php echo "Olá, " . $informacoes['nome'] . ". Tudo certo?";?>
		</h2>	
	<?php } ?>

	<h3>Esta é uma Página de Testes</h3>
	<p>Se você é um administrador, você pode: </p>
	<p> 1 - excluir qualquer comentário.</p>
	<p> 2 - exibir as informações dos usuários numa aba secreta chamada DADOS.</p>

	<h3>Logo teremos novas abas em cascata e categorias.</h3>


</body>
</html>
