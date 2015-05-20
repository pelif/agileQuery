<?php
//arquivo somente para teste - esta api será usada em models
print'<h3>Teste Api de persistência</h3>';

require_once 'agileQuery.php';

$obj = new agileQuery();

$post = array(
	'nome'     => 'VIVIANE AUGUSTA DANIEL',
	'endereco' => 'RUA MACHADO COELHO VEIGAS, 1333',
	'telefone' => '(11) 97789-6437',
	'cidade'   => 'SÃO CARLOS',
	'email'    => 'mark.markoli@gmail.com',
);

//$obj->insert($post);
//$obj->update($post, array('id' => 66));

//$obj->delete(array('id' => 63));

echo "<br><br>";

var_dump($obj->select("select * from aluno order by id desc", array('id', 'nome', 'email', 'telefone')));

?>
