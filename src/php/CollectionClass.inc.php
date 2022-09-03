<?php

class Collection extends Dbh
{
	public function getPublicArts()
	{
		$sql = "SELECT * FROM `arts` WHERE `public` = 1;";
		$stmt = $this->connect()->prepare($sql);

		if (!$stmt->execute()) {
			$stmt = null;
			header("Location: home?error=stmtfailed");
			exit();
		}

		if ($stmt->rowCount() >= 0) {
			$arts = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $arts;
		} else {
			return false;
		}
	}


	public function getUserArts()
	{
		$userID = $_SESSION['userID'];

		$sql = "SELECT * FROM `arts` WHERE `owner_id` = ?;";
		$stmt = $this->connect()->prepare($sql);
		$stmt->bindParam(1, $userID);

		if (!$stmt->execute()) {
			$stmt = null;
			header("Location: ../home?error=stmtfailed");
			exit();
		}

		if ($stmt->rowCount() >= 0) {
			$arts = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $arts;
		} else {
			return false;
		}
	}
}
