<?php
	/**
	 * All functions related to databases are here.
	 * 
	 * This file will include stuff such as, connect, write, read, remove etc.
	 * 
	 * @category Database
	 * @package ControlPanel
	 * @author Dennis &lt;dennistryy3@gmail.com>
	 * @copyright 2014 Dennis Planting
	 */

	class Database
	{
		$result; // Holds the query result.
		$records; // Holds the total number of records returned.
		$affected; // Hols the total number of records affected.
		$arrayedResult;

		$hostname; // Holds the hostname.
		$username; // Holds the username.
		$password; // Holds the password.
		$database; // Holds the database name.

		$db_link; // Holds the database link.

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
		 * @param boolean persistent If the connection should be connected persistently or not! (default false)
		 * 
		 * @return boolean If the connection was successful or not.
		 */

		private function Connect($persistent  = false)
		{
			$this->Disconnect(); //Disconnects in case there is a running connection!

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
		 * @return boolean If selecting the DB was successful or not.
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
		 * Runs a mysql_real_escape_string
		 * 
		 * @param string data The data to escape.
		 * @param string type The type of the data (str, int...).
		 * 
		 * @return array/string The data after escaping it.
		 */

		private function escapeData($data, $type)
		{
			$newData = array();
			if(is_array($data))
			{

				foreach($data as $key => $value)
				{
					if (!is_array($value))
					{
						$value = setData($value, $type[$i]);
						$newData[$key] = mysql_real_escape_string($value, $this->db_link);
					}
				}
				return $newData;
			}
			else
			{
				$data = $this->setData($data, $type);
				$data = mysql_real_escape_string($data, $this->db_link);
				return $data;
			}
		}


		/**
		 * Sets the data to a type, to make sure that the data is the specific type.
		 * 
		 * @param string data The data to do stuff with.
		 * @param string type The type to set the data to.
		 * 
		 * @return string the fixed data.
		 */

		private function setData($data, $type)
		{
			switch ($data) {
				case 'none':
					$data = $data;
					break;

				case 'str':
					$data = settype($data, 'string');
					break;
					
				case 'int':
					$data = settype($data, 'integer');
					break;
					
				case 'float':
					$data = settype($data, 'float');
					break;
					
				case 'bool':
					$data = settype($data, 'boolean');
					break;
					
				case 'datatime':
					$data = trim($data);
					$data = preg_replace('/[\d\-: ]/i', '', $data);
					preg_match('/^([\d]{4}-[\d]{2}-[\d]{2} [\d]{2}:[\d]{2}:[\d]{2})$/', $data, $matches);
					$data = $matches[1];
					break;
					
				case 'ts2dt':
					$data = settype($data, 'integer');
					$data = date('Y-m-d H:i:s', $data);
					break;
					
				case 'hexcolor':
					preg_match('/(#[0-9abcdef]{6})/i', $data, $matches);
					$data = $matches[1];
					break;
					
				case 'email':
					$data = filter_var($data, FILTER_VALIDATE_EMAIL);
					break;
				
				default:
					$data = ''
					break;
			}
			return $data;
		}


		/**
		 * Disconnect from a db.
		 * 
		 * @param string $db Which database to disconnect from.
		 * 
		 * @return boolean if the disconnection was successful or not.
		 */

		public function Disconnect($db)
		{
			if($this->db_link)
			{
				mysql_close($this->db_link);
			}
		}


		/**
		 * Executes a SQL Query
		 * 
		 * @param string $query The query to execute.
		 * 
		 * @return boolean if the execution was successful or not.
		 */

		public function execSQL($query)
		{
			if ($this->result = mysql_query($query, $this->db_link))
			{
				if (gettype($this->result) === 'resource')
				{
					$this->records  = @mysql_num_rows($this->result);
					$this->affected = @mysql_affected_rows($this->db_link);
				}
				else
				{
					$this->records  = 0;
					$this->affected = 0;
				}

				if ($this->records > 0)
				{
					$this->arrayResults();
					return $this->arrayedResult;
				}
				else
				{
					return true;
				}
			}
			else
			{
				throw new Exception("Query failed: " . mysql_error($this->db_link));
				return false;
			}
		}


		/**
		 * Puts the Results into an Array.
		 * 
		 * @return array The results
		 */

		public function arrayResults()
		{
			if($this->records == 1)
			{
				$this->arrayedResult = mysql_fetch_assoc($this->result) or die (throw new Exception("Fetching the array failed: " . mysql_error($this->db_link)));
				return $this->arrayedResult;
			}

			$this->arrayedResult = array();
			while ($data = mysql_fetch_assoc($this->result))
			{
				$this->arrayedResult[] = $data;
			}
			return $this->arrayedResult;
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

		function Write($table, $column, $value, $row="")
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
