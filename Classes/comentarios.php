<?php
date_default_timezone_set('America/Sao_Paulo');

	Class Comentario {
		private $pdo;

		//construtor
		public function __construct($dbname, $host, $usuario, $senha){
			try {
				$this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host, $usuario, $senha);
				
			} catch (PDOException $e) {
				echo "Erro de Bando de Dados: " .$e->getMessage();
			} catch (Exception){
				echo "Erro: " . $e->getMessage();
			}
		}

		public function buscarComentarios() {
		//todas as informações sobre o comentário, mais o nome da pessoa.
		//poderíamos usar o JOIN, porém vamos fazer apenas uma subconsulta. 
		$cmd = $this->pdo->prepare("SELECT *, (SELECT nome FROM tb_usuarios WHERE id = fk_id_usuario) as nome_pessoa FROM tb_comentarios ORDER BY dia, horario DESC");
		$cmd->execute();
		$dados = $cmd->fetchAll(PDO::FETCH_ASSOC);
		return $dados;
		//nesse return vem id, comentario, dia, horario e o nome_pessoa (subconsulta). 
		}

		public function excluirComentario($id_comentario, $id_user){
			if ($id_user == 1) {
				//nesse caso é o adm
				$cmd = $this->pdo->prepare("DELETE FROM tb_comentarios WHERE id = :id_c");
				$cmd->bindValue(":id_c", $id_comentario);
				$cmd->execute();
			}else{
				$cmd = $this->pdo->prepare("DELETE FROM tb_comentarios WHERE id = :id_c AND fk_id_usuario = :id_user");
				$cmd->bindValue(":id_c", $id_comentario);
				$cmd->bindValue(":id_user", $id_user);
				$cmd->execute();
			}
		}

		public function inserirComentario($id_pessoa, $comentario){
			//a data e a hora o próprio sistema pegará;

			$cmd= $this->pdo->prepare("INSERT INTO tb_comentarios (comentarios, dia, horario, fk_id_usuario) VALUES(:c, :d, :h, :fk)");
			
			$cmd->bindValue(":c", $comentario);
			$cmd->bindValue(":d", date('Y-m-d'));
			$cmd->bindValue(":h", date('H:i'));
			$cmd->bindValue(":fk", $id_pessoa);

			$cmd->execute();

		}
	}
?>