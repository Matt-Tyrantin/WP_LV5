<?php
	namespace Database;

	require_once 'connection.php';

	/**
	*	Class for easier insertation of data into the database. Can only change one row at a time.
	*/
	class TableManager 
	{
		protected $row;

		private $database;
		private $table;

		public function __construct($database, $table)
		{
			$this->database = $database;
			$this->table = $table;
			$this->row = array();
		}

		/**
		*	Adds the specified column with given value into the editing row
		*/
		public function AddColumn($col, $value, $editExisting = false)
		{
			if (empty($this->row[$col])) {
				$this->row[$col] = $value;
			} else {
				if ($editExisting) {
					$this->EditColumn($col, $value);
				}
			}
		}

		/**
		*	Edits the specified column with given value from the editing row
		*/
		public function EditColumn($col, $value, $addIfNone = false)
		{
			if (!empty($this->row[$col])) {
				$this->row[$col] = $value;
			} else {
				if ($addIfNone) {
					$this->AddColumn($col, $value);
				}
			}
		}

		/**
		*	Removes the specified column from the editing row
		*/
		public function RemoveColumn($col) 
		{
			if (!empty($this->row[$col])) {
				unset($this->row[$col]);
			}
		}

		/**
		*	Inserts modified row into connected table. Returns true if row has been inserted.
		*/
		public function InsertRow()
		{
			$sql = 'INSERT INTO '.$this->database.'.'.$this->table.'(';

			foreach ($this->row as $col => $value) {
				$sql .= $col.',';
			}

			// Remove the last comma
			$sql = substr($sql, 0, -1);
			$sql .= ') VALUES (';

			foreach ($this->row as $col => $value) {
				if (is_numeric($value)) {
					$sql .= $value.',';
				} else {
					$sql .= "'".$value."',";
				}	
			}

			// Remove the last comma
			$sql = substr($sql, 0, -1);
			$sql .= ')';

			return Connection::GetConnection()->query($sql);
		}

		/**
		*	Removes a row which contains given columns and their values. Returns true if row has been removed
		*/
		public function RemoveRow()
		{
			$sql = 'DELETE FROM '.$this->database.'.'.$this->table.' WHERE ';

			foreach ($this->row as $col => $value) {
				$sql .= $col.'='.$value.' AND ';
			}

			// Remove the last AND expression
			$sql = substr($sql, 0, -5);

			if (Connection::GetConnection()->query($sql)) {
				// Because choosing fighters is dependant on their IDs (e.g. fighter with ID 1 is first in line), there must not
				// be any empty rows between IDs
				Connection::GetConnection()->query('ALTER TABLE '.$this->database.'.'.$this->table.' AUTO_INCREMENT=1');

				return true;
			} else {
				return false;
			}
		}

		/**
		*	Updates columns in a row where $whereKey and $whereValue match (preferably ID). Returns true if the 
		*	update was successful
		*/
		public function UpdateRow($whereKey, $whereValue)
		{
			$sql = 'UPDATE '.$this->database.'.'.$this->table.' SET ';

			foreach ($this->row as $col => $value) {
				$sql .= $col.'=';
				if (is_numeric($value)) {
					$sql .= $value.',';
				} else {
					$sql .= "'".$value."',";
				}	
			}

			// Remove the last comma
			$sql = substr($sql, 0, -1);
			$sql .= ' WHERE '.$whereKey.'='.$whereValue;

			return Connection::GetConnection()->query($sql);
		}
	}

?>