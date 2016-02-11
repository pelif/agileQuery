<?php

/**
 * Classe para conexão e configurações de db
 */
namespace core\Db\agileQuery;

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
	 * Pega as configurações de conexão cmo banco de dados
	 */
	public function open($name) {

		$path_file = ROOT . "/core/Db/";

		if (!file_exists($path_file . $name.".ini")):
			//throw new Excepcion("Arquivo $name não encontrado!");
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
	 * Faz a conexão utilizando PDO
	 * Factory em conexões
	 */
	public function connect() {

		$this->open('mysql');
		//var_dump($this);
		//exit;
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
