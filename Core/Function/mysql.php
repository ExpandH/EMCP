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

		/**
		 * Connects to a db.
		 * 
		 * @param string $db What database to connect to.
		 * @param string $table If you want to select a table directly.
		 * 
		 * @return boolean if the connection was succesfully or not.
		 */

		function connect($db, $table="")
		{

		}


		/**
		 * Disconnect a db.
		 * 
		 * @param string $db What database to disconnect.
		 * 
		 * @return boolean if the disconnection went successfully or not.
		 */

		function disconnect($db)
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

		function write($db, $table, $column, $value, $row="")
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

		function read($db, $table, $column="")
		{

		}


		/**
		 * Create a new database.
		 * 
		 * @param string $db The name of the database to create.
		 * 
		 * @return boolean If creating a new database went successfully or not.
		 */

		function add_db($db)
		{

		}


		/**
		 * Create a new table.
		 * 
		 * @param string $table The name of the table to create.
		 * 
		 * @return boolean If creating a new table went successfully or not.
		 */
		
		function add_table($table)
		{

		}


		/**
		 * Delete a new database.
		 * 
		 * @param string $db The name of the database to delete.
		 * 
		 * @return boolean If deleting the database went successfully or not.
		 */
		
		function delete_db($db)
		{

		}


		/**
		 * Delete a new table.
		 * 
		 * @param string $table The name of the table to delete.
		 * 
		 * @return boolean If deleting the table went successfully or not.
		 */
		
		function delete_table($table)
		{

		}
	}
?>