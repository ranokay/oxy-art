<?php

class Dbh
{
	protected function connect()
	{
		try {
			$servername = "mysql-db";
			$username = "root";
			$password = "root";
			$dbname = "oxyproject";

			$dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $dbh;
		} catch (PDOException $e) {
			echo "Connection failled. " . $e->getMessage() . "<br>";
			die();
		}
	}
}