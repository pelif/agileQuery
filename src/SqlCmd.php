<?php
namespace CommandSQL;

class SqlCmd {

	protected static $sql;

	public static function getSQL() {
		return self::$sql;
	}   

	/**
	 * Monta a sentença Select do SQL
	 */
	public static function SelectMount($entity, array $arr, $valids = null, array $order = null) {
		self::$sql = "SELECT ";
		$i         = 0;
		foreach ($arr as $key => $value) {
			self::$sql .= ($i < sizeof($arr)-1)?"{$value},":"{$value}";
			$i++;
		}
		self::$sql .= " from {$entity} ";
		//self::$sql .= " from ".get_class($this);
		if (is_array($valids)) {
			self::$sql .= " WHERE ";
			$i = 0;
			foreach ($valids as $key => $value) {
				self::$sql .= ($i < sizeof($valids)-1)?"{$key} = {$value} AND ":"{$key} = {$value} ";
				$i++;
			}
		}
		if (is_array($order)) {
			self::$sql .= " ORDER BY ".array_keys($order)." ".array_values($order);
		}
		return self::$sql;
	}

	/**
	 * GERA Instrução Insert
	 */
	public static function InsertMount($entity, $arr) {
		//$this->sql = "INSERT INTO ".get_class($this)." ( ";
		self::$sql = "INSERT INTO {$entity} ( ";
		$i         = 0;
		foreach ($arr as $key => $value) {
			self::$sql .= ($i < sizeof($arr)-1)?$key.", ":$key;
			$i++;
		}
		$i = 0;
		self::$sql .= " ) VALUES ( ";
		foreach ($arr as $key => $value) {
			self::$sql .= ($i < sizeof($arr)-1)?":{$key}, ":":{$key}";
			$i++;
		}
		self::$sql .= ") ";
		return self::$sql;
	}

	/**
	 * Gera Instrução Update
	 */
	public static function UpdateMount($entity, $arr, $valids) {
		self::$sql = "UPDATE {$entity} SET ";
		$i         = 0;
		foreach ($arr as $key => $value) {
			self::$sql .= ($i < sizeof($arr)-1)?$key.' = :'.$key.', ':$key.' = :'.$key;
			$i++;
		}
		self::$sql .= ' WHERE ';
		$i = 0;
		foreach ($valids as $key => $value) {
			self::$sql .= ($i < sizeof($valids)-1)?$key." = :".$key." AND ":$key." = :".$key;
			$i++;
		}
		return self::$sql;

	}

	/**
	 * Gera a instrução de DELETE no SQL
	 */
	public function DeleteMount($entity, $keys) {
		self::$sql = "DELETE FROM {$entity} ";
		$i         = 0;
		self::$sql .= "WHERE ";
		foreach ($keys as $c => $v) {
			self::$sql .= ($i < sizeof($keys)-1)?$c." = :".$c." AND ":$c." = :".$c;
			$i++;
		}

		return self::$sql;
	}

}

?>