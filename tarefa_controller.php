<?php
	require "../../app_lista_tarefas/tarefa_service.php";
	require "../../app_lista_tarefas/tarefa_model.php";
	require "../../app_lista_tarefas/conexao.php";
 	
	$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;
	$pag = isset($_GET['pag']) ? $_GET['pag'] : 0;


	// $acao recebe um if simples... se existir um get pegar o valor de get, se não , deve pegar o valor da variavel $acao  que foi criada em ../../todas_tarefas.php
	//echo $acao;

 	if($acao == 'inserir'){

		//print_r($_POST['tarefa']);
		//echo "<hr>";	
		$tarefa = new Tarefa(); //pegando a classe tarefa_model/Tarefa
		//print_r($tarefa);
		//echo "<hr>";	

		$tarefa->__set('tarefa', $_POST['tarefa']); //pegando e inserindo na classe
 		//echo "<hr>";	
		//print_r($tarefa);


		$conexao =  new Conexao(); //chamando a conexao com o banco

		$tarefaservice = new TarefaService($conexao, $tarefa); //  a class TarefaService recebe a classe conexao e a classe tarefa, e libera que chame uma das funcçoes CRUD

		$tarefaservice->inserir(); // inseri na tabela
		//echo '<pre>';
		//print_r($tarefaservice);
		//echo '</pre>';

		header('location:nova_tarefa.php?inclusao=1');
	} else if($acao == 'recuperar'){

		$tarefa = new Tarefa();
		$conexao = new Conexao();

		$tarefaservice = new TarefaService($conexao, $tarefa);
		$tarefas = $tarefaservice->recuperar();


	}else if($acao == 'atualizar'){

		//print_r($_POST);
		$tarefa = new Tarefa();
		$tarefa->__set('id', $_POST['id'])->__set('tarefa', $_POST['tarefa']);

		$conexao = new Conexao();

		$tarefaservice = new TarefaService($conexao, $tarefa);
		if ($tarefaservice->atualizar()){ //retorna 1 se retonra 1 é true, entao entra no if

			if(isset($_GET['pag']) && $_GET['pag'] == 'index'){
				header('location: index.php');
			}else{
				header('location: todas_tarefas.php');
			}
		}

	} else if($acao == 'remover'){
		
		$tarefa = new Tarefa();

		$tarefa->__set('id', $_GET['id']);

		$conexao =  new Conexao();

		$tarefaservice = new TarefaService($conexao, $tarefa);
		$tarefaservice->remover();
		
		if(isset($_GET['pag']) && $_GET['pag'] == 'index'){
				header('location: index.php');
			}else{
				header('location: todas_tarefas.php');
			}

	}else if ($acao == 'marcarRealizada'){

		$tarefa = new Tarefa();

		$tarefa->__set('id', $_GET['id'])->__set('id_status', 2);

		$conexao =  new Conexao();

		$tarefaservice = new TarefaService($conexao,$tarefa);
		$tarefaservice->marcarRealizada();
		
		if(isset($_GET['pag']) && $_GET['pag'] == 'index'){
				header('location: index.php');
			}else{
				header('location: todas_tarefas.php');
			}
		
	} else if($acao == 'recuperarTarefasPendentes'){

		$tarefa = new Tarefa();
		$tarefa->__set('id_status', 1);
		$conexao = new Conexao();

		$tarefaservice = new TarefaService($conexao, $tarefa);
		$tarefas = $tarefaservice->recuperarTarefasPendentes();


	}

		





 ?>