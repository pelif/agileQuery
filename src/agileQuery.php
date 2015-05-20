<?php

/**
 * AgileQuery é um api de persistência para agilização de processos de persistẽnica
 * Como o próprio nome diz ágil - visa agilizar processos simples de persistência
 * Esta Api abstrai a classe PDO
 */

include "Conn.php";
include "SqlCmd.php";

namespace \API; 

class agileQuery {

	use Conn\Conn;
	use CommandSQL\SqlCmd;
	
	protected $entity;

	public function setentity($entity) {
		$this->entity = $entity;
	}

	public function getentity() {
		return $this->entity;
	}

	public function __construct() {
		$this->connect();
	}

	/**
	 * Executa query recebida : insert, update e delete
	 * Para a versão final a api, este método recebera outro nome (Persist)
	 * O mesmo servirá tanto para select , quanto para update
	 */
	public function insert($arr) {
		$this->setentity(get_class($this));
		$dbh = $this->conn;
		$sth = $dbh->prepare(SqlCmd::InsertMount($this->getentity(), $arr));
		if (is_array($arr)) {
			foreach ($arr as $key => $value) {
				$sth->bindValue(":".$key."", $value);
			}
		}

		return $sth->execute();

	}

	/**
	 * Método responsável pelo update na base
	 * @params $sql, $fields, $validKeys
	 */
	public function update($fields, $validKeys) {
		$this->setentity(get_class($this));
		$dbh = $this->conn;
		$sth = $dbh->prepare(SqlCmd::UpdateMount($this->getentity(), $fields, $validKeys));
		if (is_array($fields)) {
			foreach ($fields as $k => $v) {
				$sth->bindValue(":".$k."", $v);
			}
		}
		if (is_array($validKeys)) {
			foreach ($validKeys as $k => $v) {
				$sth->bindValue(":".$k."", $v);
			}
		}
		$sth->execute();
	}

	/**
	 * Efetua sentenças select simples
	 */
	public function simple_select(array $fields = null, array $validKey = null, array $order = null) {
		$this->setentity(get_class($this));
		$dbh = $this->conn;
		$sth = $dbh->prepare(SqlCmd::SelectMount($this->getentity(), $fields, $validKey, $order));
		$sth->execute();

		foreach ($sth->fetchAll(PDO::FETCH_ASSOC) as $rows) {
			if (is_array($fields)) {
				foreach ($fields as $index) {
					$out["".$index.""][] = $rows["".$index.""];
				}
			}
		}
		return $out;
	}

	/**
	 * Para selects mais elaborados
	 * O método recebe a sentença via parâmetro
	 */
	public function select($sql) {
		$dbh = $this->conn;
		$sth = $dbh->prepare($sql);
		$sth->execute();
		while ($list = $sth->fetch(PDO::FETCH_ASSOC)) {
			$out[] = $list;
		}
		return $out;
	}

	/**
	 * Faz os deletes do sistema
	 */
	public function delete($validKey) {
		$this->setentity(get_class($this));
		$dbh = $this->conn;
		$sth = $dbh->prepare(SqlCmd::DeleteMount($$this->getentity(), $validKey));
		if (is_array($validKey)) {
			foreach ($validKey as $k => $v) {
				if (is_string($v)) {
					$sth->bindValue(":".$k."", "".$v."");
				} else if (is_int($v)) {
					$sth->bindValue(":".$k."", $v);
				}
			}
		}
		$sth->execute();
	}

	/**
	 * PRIVATES METHODS
	 */

	//PARA VALIDAÇÃO DE INSERTS
	private function validRegister($objPDO, $prepare, $entity, $key) {
		$validar = $objPDO->prepare("select * from ".$entity." where ".array_keys($key)." = :".array_values($key));
		$validar->bindValue(":".array_keys($key)."", array_values($key));

		if ($validar->rowCount() == 0) {
			$prepare->execute();
		} else {
			echo "Registro já existe!!!";
		}

	}

}