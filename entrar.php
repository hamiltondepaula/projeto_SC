<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="CSS/entrar.css">
	<title>Guia de Compras</title>
</head>
<body>
	<span>Guia de Compras</span>
	<form method="POST">
		<h1>Acesse sua conta</h1>
		<img src="imagens/email_sem_fundo.png">
		<input type="email" name="email" maxlength="40">
		<img src="imagens/senha_sem_fundo.png">
		<input type="password" name="senha">
		<input type="submit" value = "Entrar" name="">
		<a href="cadastrar.php">Registre-se agora!</a>
	</form>

</body>
</html>

<!--------------------PHP---------------->

<?php

if(isset($_POST['email'])){
	$email = htmlentities(addslashes($_POST['email']));
	$senha = htmlentities(addslashes($_POST['senha']));

	if (!empty($email) && !empty($senha)) {
		require_once 'Classes/usuarios.php';
		$us = new Usuario("projeto_sc", "localhost", "root", "");

		if($us->entrar($email, $senha)){
			header("location: index.php");
		}else{ ?>
			<p class="mensagem">E-mail ou Senha incorretos. Você ainda não está cadastrado</p>
<?php		}
	}
}
?>