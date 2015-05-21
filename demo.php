<?php

/**
 * Este cara seria o seu MODEL
 * @author felipe
 *
 */

include "Api/agileQuery.php";

use Api\agileQuery as agileQuery;

class aluno  extends agileQuery {
			
	public function Alunos() {
		$result = $this->select("select * from aluno order by nome asc");
		return $result;
	}

}

$post = array(
	'nome'     => 'RAFAEL DANIEL DE OLIVEIRA',
	'endereco' => 'RUA MACACO LAS VEGAS, 1333',
	'telefone' => '(11) 3446-6464',
	'cidade'   => 'SÃO CARLOS',
	'email'    => 'mark.markoli@gmail.com',
);

$obj = new aluno;

var_dump($obj->Alunos());

?>