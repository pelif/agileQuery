<?php

/**
 * Este cara seria o seu MODEL
 * @author felipe
 *
 */

namespace Model;

include "Api/agileQuery.php";

use Api\agileQuery as agileQuery;

class aluno  extends agileQuery {
		
	/*
	 *Persiste os dados refentes ao array $post na base de dados
	*/
	public function InsertAluno() {
		$post = array(
				'nome'     => 'Nome Sobrenome',
				'endereco' => 'Rua teste, 02',
				'telefone' => '(11) 1111-1111',
				'cidade'   => 'SÃO PAULO',
				'email'    => 'nome_sobrenome@gmail.com'
		);
		
		$this->insert($post);		
	}
	
	/**
	 * Seleciona todos os registros da entidade
	 * @return mixed
	 */
	public function Alunos() {
		$result = $this->select("select * from aluno order by nome asc");
		return $result;
	}
	
	
	/*
	 * A execução do método abaixo update na entidade corrente alterando
	* o nome e o e-mail do mesmo, correspondentemente as chaves do array
	* do primeiro parâmetro
	* O segundo parâmetro seta a chave da cláusula, no caso abaixo, o nome
	* e o e-mail do registro cujo id é igual a 60 será alterado
	*/
	public function updateAluno() {
		$this->update(array('nome' 	=> 'Theodore Jackson Halls',
						   'email' => 'theodore.jackson@hotmail.com'
					), array(
						'id' => 60
					));
	}
		

	/**
	 * A execução do método abaixo deleta um registro na base de dados
	 * Neste caso, o registro cujo id = 53 será deletado
	 */
	public function deleteAluno($id) {
		$this->delete(array('id' => $id));
	}
	
	
	/**
	 * A execução do método abaixo faz um select simples na base
	 * o array referente ao primeiro parâmetro são os campos que serão selecionados
	 * O array referente ao segundo parâmetro é a chave do registro que será selecionado
	 */
	public function findAluno($id) {
		$result = $this->simple_select(array('nome','email','telefone'), array('id'=>60));
		return $result;
	}
	

}


?>