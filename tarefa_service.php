<?php 

	//CRUD
	class TarefaService{

		private $conexao;
		private $tarefa;
					//conexao é uma estancia de Conexao, e tarefa de Tarefa, pq são variaveis que contem objeto de uma classe, se vier um objeto que nao seja da classe dos mesmos, ele nao vai passar, só aceita se vier da mesma classe/ tipagem mo parametro que esta saendo recebifo
		public function __construct(Conexao $conexao, Tarefa $tarefa){
			$this->conexao = $conexao->conectar();
			$this->tarefa = $tarefa;
		}

		public function inserir(){ //create
			$query = 'insert into tb_tarefas(tarefa)values(:tarefa)';
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa')); // troca o nome do valor no sql, a fim de evitar sqlInjecte
			$stmt->execute(); // sem isso o banco nao é executado

		}

		public function recuperar(){ //read
			$query = 'select 
						t.id, s.status, t.tarefa 
					  from 
					  	tb_tarefas as t
					  	 left join tb_status as s on (t.id_status = s.id)
					  	 ORDER BY t.id DESC ';
			$stmt = $this->conexao->prepare($query);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);// padrao array de array,

		}

		public function atualizar(){ //update
			$query = "update tb_tarefas set tarefa = ? where id = ?";
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(1, $this->tarefa->__get('tarefa'));
			$stmt->bindValue(2, $this->tarefa->__get('id'));// substitui o segundo (?) do sql
			return $stmt->execute();

		}

		public function remover(){ // delete
			$query = 'delete from tb_tarefas where id = :id';
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':id', $this->tarefa->__get('id')); 
			$stmt->execute();

		}

		public function marcarRealizada(){
			$query = 'update tb_tarefas set id_status = ? where id = ?';
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(1, $this->tarefa->__get('id_status'));
			$stmt->bindValue(2, $this->tarefa->__get('id'));
			return $stmt->execute();
		}

		public function recuperarTarefasPendentes(){
			$query = 'select 
						t.id, s.status, t.tarefa 
					  from 
					  	tb_tarefas as t
					  	 left join tb_status as s on (t.id_status = s.id)
					  	 where
					  	 t.id_status = :id_status';
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':id_status', $this->tarefa->__get('id_status'));
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);// padrao array de objetos,


		}

	}











?>