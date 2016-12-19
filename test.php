<?php

/**
* @author Felipe Daniel
* @date 19/12/2016
*/

require_once "Db/agileQuery/SqlCmd.php";
require_once "Db/agileQuery/Conn.php";
require_once "Db/agileQuery/agileQuery.php";
require_once "Classes/Aluno.php";
//Ao invés dos requires, pode ser splAutoLoad seguindo o psr4, ok ?

$aluno = new \Classes\Aluno();

var_dump($aluno->lista());

var_dump($aluno->listaObjetos());

?>
