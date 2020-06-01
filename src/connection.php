<?php
	namespace Database;

	use mysqli;

	/**
	*	Establishes connection with project's database in a form of singleton pattern
	*/
	class Connection 
	{
		protected const SERVER_NAME = 'localhost';
		protected const USERNAME = 'root';
		protected const PASSWORD = '';

		private static $connection;

		public static function GetConnection()
		{
			if (self::$connection == null) {
				self::$connection = new mysqli(
					self::SERVER_NAME,
					self::USERNAME,
					self::PASSWORD
				);

				if (self::$connection->connect_error) {
					die('Connection failed: '.$conn->connect_error);
				}
			}

			return self::$connection;
		}
	}
?>