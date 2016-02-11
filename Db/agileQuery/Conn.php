<?php

/**
 * Classe para conexão e configurações de db
 */
namespace Db\agileQuery;

use \PDO as PDO;

class Conn {
	protected $host;
	protected $port;
	protected $user;
	protected $passwd;
	protected $default_db;
	protected $type;

	protected $conn = null;

	/**
	 * @param string $name
	 * @return void
	 */
	public function open($name) {

		$path_file = ROOT . "Db/";

		if (!file_exists($path_file . $name.".ini")):
			die('Arquivo $name não encontrado!');
		endif;

		$db = parse_ini_file($path_file . $name.".ini");

		$this->host       = $db['host'];
		$this->port       = $db['port'];
		$this->user       = $db['user'];
		$this->passwd     = $db['passwd'];
		$this->type       = $db['type'];
	}


	/**
	 * @return Object PDO Connection
	 */
	public function connect() {

		$this->open('mysql');

		try
		{
			switch ($this->type):

				case 'mysql':
					$this->conn = new PDO("mysql:host={$this->host};port={$this->port};dbname={$this->default_db}", $this->user, $this->passwd);
				break;

				case 'mssql':
					$this->conn = new PDO('mssql:host='.$this->host.';dbname='.$this->default_db, $this->user, $this->passwd);
				break;

			endswitch;
		} catch (Excepcion $e) {
			printf("%s", "<b>Err:</b>".$e->getCode().'--->'.$e->getMessage().'--->'.$e->getFile().'--->'.$e->getLine());
		}
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		return $this->conn;

	}

}

?>
