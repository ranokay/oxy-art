<?php

class Collection extends Dbh
{
	public function getPublicArts()
	{
		$sql = "SELECT * FROM `arts` WHERE `public` = 1;";
		$stmt = $this->connect()->prepare($sql);

		if (!$stmt->execute()) {
			$stmt = null;
			echo "<h1 class='form__error'>Failed to get data from server!</h1>";
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
			echo "<h1 class='form__error'>Failed to get data from server!</h1>";
			exit();
		}

		if ($stmt->rowCount() >= 0) {
			$arts = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $arts;
		} else {
			return false;
		}
	}

	public function getArtLikes($artId)
	{
		$sql = "SELECT * FROM `likes` WHERE `art_id` = ?;";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$artId]);
		$result = $stmt->fetchAll();
		$stmt = null;

		if (count($result) > 0) {
			return count($result);
		} else {
			return 0;
		}
	}
}