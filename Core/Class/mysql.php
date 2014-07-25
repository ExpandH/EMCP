<?php
	/**
	 * All the functions releated to databases is here.
	 * 
	 * This file will include stuff like, connect, write, read, remove etc.
	 * 
	 * @category Database
	 * @package ControlPanel
	 * @author Dennis &lt;dennistryy3@gmail.com>
	 * @copyright 2014 Dennis Planting
	 */

	class Database
	{
		$hostname; //Holds the hostname.
		$username; //Holds the username.
		$password; //Holds the password.
		$database; //Holds the database name.

		$db_link; //Holds the database link.

		function __construct($database, $username, $password, $hostname = "localhost", $port = "3306")
		{
			$this->database = $database;
			$this->username = $username;
			$this->password = $password;
			$this->hostname = $hostname . ":" . $port;

			$this->Connect();
		}

		/**
		 * Connects to a db.
		 * 
		 * @param boolean persistent If the connection should be connected persistent or not! (default false)
		 * 
		 * @return boolean If the connection was succesfully or not.
		 */

		private function Connect($persistent  = false)
		{
			$this->Disconnect(); //Disconnects incase there is a running connection!

			if ($persistent)
			{
				$this->db_link = mysql_pconnect($this->hostname, $this->username, $this->password);
			}
			else
			{
				$this->db_link = mysql_connect($this->hostname, $this->username, $this->password);
			}

			if (!$this->db_link)
			{
				throw new Exception("Can't connect to MySQL: " . mysql_error($this->db_link));
				return false;
			}

			if (!this->SelectDB())
			{
				throw new Exception("Can't connect to MySQL: " . mysql_error($this->db_link));
				return false;
			}
			return true;
		}


		/**
		 * Selects the DB!
		 * Used to complete the connection!
		 * 
		 * @return boolean If selecting the DB was successfully or not.
		 */

		private function SelectDB()
		{
			if (!mysql_select_db($this->database, $this->db_link))
			{
				throw new Exception("Can't select the database: " . mysql_error($this->db_link));
				return false;
			}
			else
			{
				return true;
			}
		}


		/**
		 * Disconnect a db.
		 * 
		 * @param string $db What database to disconnect.
		 * 
		 * @return boolean if the disconnection went successfully or not.
		 */

		function Disconnect($db)
		{

		}


		/**
		 * Write to a table.
		 * 
		 * @param string $db What database to write to.
		 * @param string $table What table to write to.
		 * @param string $column What column to write to.
		 * @param string $value What the value to write.
		 * @param string $row Incase you want to write to specific row.
		 * 
		 * @return boolean If the function was successfully or not.
		 */

		function Write($db, $table, $column, $value, $row="")
		{

		}


		/**
		 * Read from a table.
		 * 
		 * @param string $db What database to read from.
		 * @param string $table What table to read from.
		 * @param string $column If you want to read from specific column.
		 * 
		 * @return array The results from the table.
		 */

		function Read($db, $table, $column="")
		{

		}


		/**
		 * Create a new database.
		 * 
		 * @param string $db The name of the database to create.
		 * 
		 * @return boolean If creating a new database went successfully or not.
		 */

		function AddDB($db)
		{

		}


		/**
		 * Create a new table.
		 * 
		 * @param string $table The name of the table to create.
		 * 
		 * @return boolean If creating a new table went successfully or not.
		 */
		
		function AddTable($table)
		{

		}


		/**
		 * Delete a new database.
		 * 
		 * @param string $db The name of the database to delete.
		 * 
		 * @return boolean If deleting the database went successfully or not.
		 */
		
		function DeleteDB($db)
		{

		}


		/**
		 * Delete a new table.
		 * 
		 * @param string $table The name of the table to delete.
		 * 
		 * @return boolean If deleting the table went successfully or not.
		 */
		
		function DeleteTable($table)
		{

		}
	}
?>