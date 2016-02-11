<?php

/**
 * Esta é uma implementação simplória, os dados estão no próprio model
 * Ao implementar isso em um projeto os dados viriam de Request e response
 */

require_once 'aluno.php';

use Model\aluno as Aluno_Model;

$Aluno = new Aluno_Model;

$Aluno->InsertAluno(); // Insere aluno

$Aluno->deleteAluno(80); //Deleta Aluno

var_dump($Aluno->Alunos()); //Lista Alunos inseridos
