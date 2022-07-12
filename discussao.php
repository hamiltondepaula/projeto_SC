<?php
	session_start();

	require_once 'Classes/comentarios.php';
	$c = new Comentario("projeto_sc","localhost","root","");
	$coments = $c->buscarComentarios();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel = "stylesheet" href="CSS/discussao.css"/>
	<title>Coments Free</title>
</head>
<body>
	<nav>
		<ul>
			<li>Postagem: Hamilton de Paula</li>
			<li> <a href="index.php">Início</a></li>
			<?php
				if (isset($_SESSION['id_master'])) { ?>
					<li> <a href="dados.php">Dados</a></li>
<?php				}
				if(isset($_SESSION['id_usuario']) || isset($_SESSION['id_master'])){ ?>
					<li> <a href="sair.php">Sair</a></li>
<?php				}else{ ?>
					<li> <a href="entrar.php">Entrar</a></li>
<?php				}
			?>
		</ul>
	</nav>
	<div id="largura-pagina">
		<section id="conteudo1">
			<h1>
				O que é preciso para aprender programação nos dias de hoje?
			</h1>
			<img src="imagens/Capturar.PNG">
			<p class="text">
				Para aprender a programar precisamos ter em mente o seguinte: <br></br>
			</p>

			<p class="text">1. Organização.</p>
			<p class="text">2. Grandes problemas são pequenos problemas juntos.</p>
			<p class="text">3. Foco em tarefas, uma solução pequena por vez.</p>
			<p class="text">4. Os resultados vêm a médio-longo prazo.</p>
			<p class="text">5. O sucesso é a consequência.</p>
			<p class="text">6. Qual o meu objetivo com tudo isso?</p>
			<p class="text">7. Aprender com objetivo e clareza faz bem a alma.</p>

			
			<?php
					if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['id_usuario'])) {
			?>			<h2>Comentários </h2>
			<?php	} else{
			?>			<h2>Deixe seu Comentário </h2>
			<?php	}
			?>

			<?php
				if(isset($_SESSION['id_usuario']) || isset($_SESSION['id_usuario'])){ ?>
					<form method="POST">
					<img src="IMAGENS/foto_perfil2.jpeg">
					<textarea name="texto" placeholder="Participe da discussão." maxlength="400"></textarea>
					<input type="submit" name="" value="PUBLICAR COMENTÁRIO">
					</form>
		<?php	}
			?>
			
			<?php
				if(count($coments)>0) { //se houver comentários, haverá foreach
					//guarda todas as informações de cada posição na variável $value
					//executa o que está nas chaves e recomeça. 
					//a cada looping criamos uma div. 

					foreach ($coments as $value) { ?>
						<div class ="area-comentario">
							<img src="IMAGENS/foto_perfil2.jpeg">
							<h3><?php echo $value['nome_pessoa'];//nome_pessoa é a coluna criada na query?></h3>
								<h4>
									<?php
										$data_Brasil = new DateTime($value['dia']);
										echo $data_Brasil->format('d/m/Y');
										echo "-";
										echo $value['horario'];
								 	?>

								 	<?php
								 		if (isset($_SESSION['id_usuario'])) {
								 			//verificando de quem é o comentário.
								 			if ($_SESSION['id_usuario'] == $value['fk_id_usuario']) {
								 	?>			<a href="discussao.php?id_excluir= <?php echo $value['id']; ?> ">Excluir</a>
								 	<?php	}
								 		}else if (isset($_SESSION['id_master'])) {
								 	?>		<a href="discussao.php?id_excluir= <?php echo $value['id']; ?> ">Excluir</a>
							<?php		}	?>			 	
								 </h4>
							<p><?php echo $value['comentarios']; ?></p>
						</div>
		<?php	}
				}else {
					echo "Seja o primeiro a comentar!";
				}
			?>
		</section>

		<!-- Essas sections não funcionam
		<section>
			<div id="conteudo2">
				<img src="IMAGENS/lateral1.jpg">
				<p>Como eram as geladeiras no antigo egito?</p>
			</div>			
		</section>

		<section>
			<div id="conteudo3">
				<h5>Saiba como fazer sua própria geladeira a sopro</h5>
				<p>Há várias discussões de como fazzer ssua rópria geladeira.</p>
			</div>
		</section>
		-->

	</div>
</body>
</html>

<?php
//pegar id de exclusão

if (isset($_GET['id_excluir'])) {
	$id_e = addslashes($_GET['id_excluir']);

	if (isset($_SESSION['id_master'])) {
		$c->excluirComentario($id_e, isset($_SESSION['id_master']));

	}else if(isset($_SESSION['id_usuario'])){
		$c->excluirComentario($id_e, isset($_SESSION['id_usuario']));
	}

	header("location: discussao.php");
}

?>

<?php
	//pegar a submissão do formulário de comentário

	if (isset($_POST['texto'])) {
		if (isset($_SESSION['id_master'])) {
			$texto = addslashes($_POST['texto']);
			$c->inserirComentario($_SESSION['id_master'], $texto);

		}elseif (isset($_SESSION['id_usuario'])){
			$texto = addslashes($_POST['texto']);
			$c->inserirComentario($_SESSION['id_usuario'], $texto);
		}

		header('location: discussao.php');
	}
?>