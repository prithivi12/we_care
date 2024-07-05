<?php
class DbConfig
{
	public $host="localhost";
	public $uname="root";
	public $pass="";
	public $dbname="wecare";
	public $connection;
	function __construct()
	{
		if (!isset($this->connection))
		{
			$this->connection=new mysqli($this->host,$this->uname,$this->pass,$this->dbname);
			if (!$this->connection) 
			{
				# code...
				echo "error db connection";
			}
			else
			{
				//echo "db connected";
			}

		}
		return $this->connection;
	}
}

?>