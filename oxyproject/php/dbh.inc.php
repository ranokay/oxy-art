<?php

class Dbh
{
	protected function connect()
	{
		try {
			$servername = "localhost";
			$username = "root";
			$password = "qazwsx123";
			$dbname = "oxyproject";

			$dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $dbh;
		} catch (PDOException $e) {
			echo "Connection failled" . $e->getMessage() . "<br>";
			die();
		}
	}
}
