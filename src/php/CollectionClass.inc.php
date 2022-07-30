<?php

class Collection extends Dbh
{
	public function getArts()
	{
		$sql = "SELECT * FROM `arts`;";
		$stmt = $this->connect()->prepare($sql);

		if (!$stmt->execute()) {
			$stmt = null;
			header("Location: home?error=stmtfailed");
			exit();
		}

		if ($stmt->rowCount() > 0) {
			$arts = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $arts;
		} else {
			return false;
		}
	}
}
