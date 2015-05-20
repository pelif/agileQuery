<?php
include "src/agileQuery.php";

use agileQuery as agileQuery;

class aluno  {
		
	public function Alunos() {
		//$result = $this->simple_select(array('id', 'nome', 'telefone', 'email'));
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

/*
$obj->insert($post);
$obj->update(array('nome' => 'Miesiks Tokoyama', 'email' => 'tokoyama'), array('id' => 68));
*/

var_dump($obj->Alunos());

?>