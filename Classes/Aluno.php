<?php

namespace Classes;

class Aluno extends \Db\agileQuery\agileQuery
{

    public function __construct()
    {
        parent::__construct();
    }


    public function lista()
    {
        $sql = "select id, nome, telefone, endereco from teste.Aluno
                order by id asc";

        $rs = $this->select($sql);

        return $rs;
    }


    public function listaObjetos()
    {
        $rs = $this->simple_selectObj(array('id','nome'));

        return $rs;
    }

}
