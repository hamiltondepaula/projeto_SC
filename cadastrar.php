<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="CSS/cadastrar.css">
	<title>Guia de Compras</title>
</head>
<body>
	<form method="POST">
		<h1>Cadastre-se.</h1>

		<label for="nome">Nome</label>
		<input type="TEXT" name="nome" maxlength="40">
		
		<label for="email">E-mail</label>
		<input type="email" name="email" maxlength="40">
		
		<label for="senha">Senha</label>
		<input type="password" name="senha">
		
		<label for="confSenha">Confirme a Senha</label>
		<input type="password" name="confSenha">
		
		<input type="submit" value = "Cadastrar" name="">
	</form>

</body>
</html>

<!----------------------------------PHP------------------------------->

<?php
// 1 - Verificar se o botão cadastrar foi apertado. 
// 2 - Enviar as informações e guardá-las em variáveis.
// 3 - enviar esses dados colhidos para a classe e função escolhidos.
// 4 - Verificar se o retorno é falso ou verdadeiro. 

if(isset($_POST['nome'])){
	$nome = htmlentities(addslashes($_POST['nome']));
	$email = htmlentities(addslashes($_POST['email']));
	$senha = htmlentities(addslashes($_POST['senha']));
	$confSenha = htmlentities(addslashes($_POST['confSenha']));

	if (!empty($nome) && !empty($email) && !empty($senha) && !empty($confSenha)) {
		
		if($senha==$confSenha){
			//para implementar a função cadastrar, chamamos a classe usuários
			require_once 'Classes/usuarios.php';
			
			//instanciando o objeto
			$us = new Usuario("projeto_sc", "localhost", "root", "");
			
			//se retornar falso, já foi cadastrado.
			if($us->cadastrar($nome, $email, $senha)){
?>				<p class="mensagem">Cadastrado com sucesso!</p>
				<a href="entrar.php"> Acesse Já!</a>
<?php			}else{ ?>
				<p class="mensagem">E-mail já está cadastrado!</p>
<?php			} 
		}else{ ?>
			    <p class="mensagem">Senhas não correspondem!</p>
<?php		}
	}else{ ?>
			    <p class="mensagem">Preencha todos os campos!</p>
<?php	} 
} 

?>