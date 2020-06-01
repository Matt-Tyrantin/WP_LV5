<?php
	namespace Database;

	require_once 'connection.php';

	/**
	*	Class for easier insertation of data into the database. Can only change one row at a time.
	*/
	class TableManager 
	{
		protected $row;

		private $table;

		public function __construct($table)
		{
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
		*	Inserts modified column into connected table
		*/
		public function InsertColumn()
		{
			$sql = 'INSERT INTO '.$this->table.'(';

			foreach ($this->row as $col => $value) {
				$sql .= $col.',';
			}

			// Remove the last comma
			$sql = substr($sql, 0, -1);
			$sql .= ') VALUES (';

			foreach ($this->row as $col => $value) {
				$sql .= "'".$value."',";
			}

			// Remove the last comma
			$sql = substr($sql, 0, -1);
			$sql .= ')';

			if (!Connection::GetConnection()->query($sql)) {
				die('Error inserting data into table.');
			}
		}
	}

?>