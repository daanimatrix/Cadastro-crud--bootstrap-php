<?php

	// Cria uma variável de sessão "con", pois terá acesso global. 
	// Abre a conexão e armazena o objeto que representa esta conexão na variável global
	// Esta variável será referenciada em cada acesso ao banco de dados
	$_SESSION['con'] = mysqli_connect("localhost", "aluno", "aluno","DB_DELIVERY");

	if (mysqli_connect_errno() != 0) 
	{
			$msg_erro = mysqli_connect_error();
			echo ("<p>Erro para conectar no Banco de Dados!</p>
				   <p>Mensagem de erro: $msg_erro</p>");
			return;
			
	}

	mysqli_query($_SESSION['con'],"SET NAMES 'utf8'");
	mysqli_query($_SESSION['con'],"SET character_set_connection=utf8");
	mysqli_query($_SESSION['con'],"SET character_set_client=utf8");
	mysqli_query($_SESSION['con'],"SET character_set_results=utf8");


	function funInsert($tabela, $campos, $valores)	{
		$sql = "INSERT into $tabela ($campos) values ($valores)";

		if(mysqli_query($_SESSION['con'],$sql)) {
			return true;
		}
	}

	function funSelect($tabela, $campos, $argumentos) {
		
		$sql = "SELECT $campos from $tabela $argumentos";		
		$retorno = mysqli_query($_SESSION['con'], $sql); # retorna registros (SELECT)
		$lista = array();
		while($reg = mysqli_fetch_assoc($retorno))	{
			array_push($lista, $reg);
		}
		return $lista;
	}

	function funUpdate($tabela, $alteracoes, $argumentos) {
		
		$sql = "UPDATE $tabela SET $alteracoes $argumentos";			
		if(mysqli_query($_SESSION['con'],$sql)) {
			return true;
		}
	}

	function funDelete($tabela, $argumentos) {
		$sql = "DELETE from $tabela $argumentos";

		if(mysqli_query($_SESSION['con'], $sql)) {
			return true;
		}
	}

?>
