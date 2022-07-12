<?php
	Class Usuario {
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

		//cadastrar
		public function cadastrar($nome, $email, $senha){

			//antes de cadastrar precisa verificar no BD se já existe. 
			$cmd = $this->pdo->prepare("SELECT id FROM tb_usuarios WHERE email =:e");
			$cmd->bindValue(":e", $email);
			$cmd->execute();

			//se vem registro com mais de uma linha, já está cadastrado. 
			if($cmd->rowCount()>0){
				return false; //já cadastrado
			} else{
				$cmd = $this->pdo->prepare("INSERT INTO tb_usuarios (nome, email, senha) VALUES (:n, :e, :s)");
				$cmd->bindValue(':n', $nome);
				$cmd->bindValue(':e', $email);
				$cmd->bindValue(':s', md5($senha));
				$cmd->execute();

				return true;	
			}
		}

		//logar
		public function entrar ($email, $senha){
			$cmd = $this->pdo->prepare("SELECT * FROM tb_usuarios WHERE email =:e AND senha = :s");
			$cmd->bindValue(":e", $email);
			$cmd->bindValue(":s", md5($senha));
			$cmd->execute();

			if($cmd->rowCount()>0){
				//se encontrada, será criada uma seção.
				$dados = $cmd->fetch();
				
				session_start();
				//faremos com que  adm seja sempre id =1.
				if($dados['id'] == 1){
					//usuarios administrador
					$_SESSION['id_master'] = 1;
				}else{
					//usuario normal
					$_SESSION['id_usuario'] = $dados['id'];
				}

				return true; //encontrada

			}else{
				//pessoa não encotrada
				return false;
			}
		}

		public function buscarDadosUser($id){
			$cmd = $this->pdo->prepare("SELECT * FROM tb_usuarios WHERE id = :id");
			$cmd->bindValue(":id", $id);
			$cmd->execute();
			$dados = $cmd->fetch();

			return $dados;
		}

		public function buscarTodosUsuarios(){
			$cmd = $this->pdo->prepare("SELECT tb_usuarios.id, tb_usuarios.nome, tb_usuarios.email, COUNT(tb_comentarios.id) as quantidade 
				FROM 
					tb_usuarios 
				LEFT JOIN 
					tb_comentarios ON tb_usuarios.id = tb_comentarios.fk_id_usuario
				GROUP BY tb_usuarios.id");

			$cmd->execute();
			$dados = $cmd->fetchAll(PDO::FETCH_ASSOC);

			return $dados;
		}

	}
?>