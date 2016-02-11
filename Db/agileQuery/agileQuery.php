<?php


/**
 * @ author - Felipe Daniel
 *
 * AgileQuery é um api de persistência para agilização de processos de persistẽnica.
 * Como o próprio nome diz - ágil - visa agilizar processos simples de persistência
 * e eliminar redundàncias como setar entidade
 * , conexão e drivers
 * Esta Api abstrai a classe PDO
 */

namespace Db\agileQuery;

use \PDO as PDO;

use Db\agileQuery\Conn;

class agileQuery extends Conn
{

	protected $entity;

	public function setentity($namespace)
	{
		$arr = explode("\\", $namespace);
		$this->entity = $arr[sizeof($arr) - 1];
	}

	public function getentity()
	{
		return $this->entity;
	}

	public function __construct()
	{
		$this->connect();
	}

	/**
	 * @param array $arr
	 * @return bool
	 */
	public function insert($arr) {
		$this->setentity($this->default_db . '.' . get_class($this));
		$dbh = $this->conn;
		$sth = $dbh->prepare(\Db\agileQuery\SqlCmd::InsertMount($this->getentity(), $arr));

		if (is_array($arr)) {
			foreach ($arr as $key => $value) {
				$sth->bindValue(":".$key."", $value);
			}
		}

		return $sth->execute();

	}

	/**
	* @param string $entity
	* @param array $arr
	* @return boolean
	*/
	public function insertFree($entity, array $arr)
	{
		$this->setentity($this->default_db . '.' . $entity);
		$dbh = $this->conn;
		$sth = $dbh->prepare(\Db\agileQuery\SqlCmd::InsertMount($entity, $arr));

		if (is_array($arr))
		{
			foreach ($arr as $key => $value)
			{
				$sth->bindValue(":".$key."", $value);
			}
		}

		return $sth->execute();
	}




	/**
	 * @param array $fields
	 * @param array $validKeys
	 * @return boolean
	 */
	public function update($fields, $validKeys) {
		$this->setentity($this->default_db . '.' . get_class($this));
		$dbh = $this->conn;
		$sth = $dbh->prepare(\Db\agileQuery\SqlCmd::UpdateMount($this->getentity(), $fields, $validKeys));
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
	 * @param array $fields
	 * @param array $validKey
	 * @param array $order
	 * @return array
	 */
	public function simple_select(array $fields = null, array $validKey = null, array $order = null) {
		$this->setentity($this->default_db . '.' . get_class($this));
		$dbh = $this->conn;
		$sth = $dbh->prepare(\Db\agileQuery\SqlCmd::SelectMount($this->getentity(), $fields, $validKey, $order));
		$sth->execute();

		$rows = $sth->fetchAll(PDO::FETCH_ASSOC);

		return $rows;
	}


	/**
	 * @param array $fields
	 * @param array $validKey
	 * @param array $order
	 * @return array
	 */
	public function simple_selectObj(array $fields = null, array $validKey = null, array $order = null) {
		$this->setentity($this->default_db . '.' . get_class($this));
		$dbh = $this->conn;
		$sth = $dbh->prepare(\Db\agileQuery\SqlCmd::SelectMount($this->getentity(), $fields, $validKey, $order));
		$sth->execute();

		$rows = $sth->fetchAll(PDO::FETCH_OBJ);

		return $rows;
	}


	/**
	* @param string $sql
	* @return stdClass
	*/
	public function select($sql) {
		$dbh = $this->conn;
		$sth = $dbh->prepare($sql);
		$sth->execute();
		$rows = $sth->fetchAll(PDO::FETCH_OBJ);
		return $rows;
	}


	/**
	* @method query
	* @param string $sql
	* @return boolean
	*/
	public function query($sql)
	{
		$dbh = $this->conn;
		$sth = $dbh->prepare($sql);
		$out = $sth->execute();
		return $out;
	}


	/**
	* @param array $validKey
	*/
	public function delete($validKey) {
		$this->setentity($this->default_db . '.' . get_class($this));
		$dbh = $this->conn;
		$sth = $dbh->prepare(\Db\agileQuery\SqlCmd::DeleteMount($this->getentity(), $validKey));
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


}
