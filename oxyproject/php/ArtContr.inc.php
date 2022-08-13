<?php

if (isset($_GET['id'])) {
	$artId = $_GET['id'];
	class Art extends Dbh
	{
		public function getArt($artId)
		{
			$sql = "SELECT * FROM `arts` WHERE `id` = ?;";
			$stmt = $this->connect()->prepare($sql);

			if (!$stmt->execute([$artId])) {
				$stmt = null;
				header("Location: art?error=stmtfailed");
				exit();
			}
			if ($stmt->rowCount() == 0) {
				$stmt = null;
				echo "<h1>Art not found</h1>";
				exit();
			}
			$art = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $art;
		}

		public function getDate($artId)
		{
			$sql = "SELECT EXTRACT( DAY FROM `date_added` ) as 'day' , EXTRACT( MONTH FROM `date_added` ) as 'month', EXTRACT( YEAR FROM `date_added` ) as 'year' FROM `arts` WHERE `id` = ?;";
			$stmt = $this->connect()->prepare($sql);

			if (!$stmt->execute([$artId])) {
				$stmt = null;
				header("Location: art?error=stmtfailed");
				exit();
			}

			$date = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $date;
		}

		public function getOwnerName($artId)
		{
			$sqlFullName = "SELECT `full_name` FROM `users` WHERE `id` = (SELECT `owner_id` FROM `arts` WHERE `id` = ?);";
			$stmt = $this->connect()->prepare($sqlFullName);

			if (!$stmt->execute([$artId])) {
				$stmt = null;
				header("Location: art?error=stmtfailed");
				exit();
			}

			$ownerName = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $ownerName[0]['full_name'];
		}

		public function getOwnerAvatar($artId)
		{
			$sql = "SELECT `avatar` FROM `users` WHERE `id` = (SELECT `owner_id` FROM `arts` WHERE `id` = ?);";
			$stmt = $this->connect()->prepare($sql);
			$ownerAvatar = 'assets/icons/user.svg';

			if (!$stmt->execute([$artId])) {
				$stmt = null;
				header("Location: art?error=stmtfailed");
				exit();
			}

			$avatar = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if ($avatar[0]['avatar'] != null) {
				$ownerAvatar = $avatar[0]['avatar'];
			}
			return $ownerAvatar;
		}

		public function getOwnerId($artId)
		{
			$sql = "SELECT `owner_id` FROM `arts` WHERE `id` = ?;";
			$stmt = $this->connect()->prepare($sql);
			$ownerId = 0;
			if (!$stmt->execute([$artId])) {
				$stmt = null;
				header("Location: art?error=stmtfailed");
				exit();
			}
			$ownerId = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $ownerId[0]['owner_id'];
		}
	}

	class ArtContr extends Art
	{
		public $name;
		public $description;
		public $artDir;

		public function __construct($artId)
		{
			$art = $this->getArt($artId);
			$this->name = $art[0]['name'];
			$this->description = $art[0]['description'];
			$this->artDir = $art[0]['art_dir'];
			$dateAdded = $this->getDate($artId);
			$this->dateAdded = $dateAdded[0]['day'] . "." . $dateAdded[0]['month'] . "." . $dateAdded[0]['year'];
			$this->ownerAvatar = $this->getOwnerAvatar($artId);
			$this->ownerName = $this->getOwnerName($artId);
			$this->ownerId = $this->getOwnerId($artId);
		}

		public function getArtName()
		{
			return $this->name;
		}

		public function getArtDir()
		{
			return $this->artDir;
		}

		public function getArtDescription()
		{
			return $this->description;
		}

		public function getArtDate()
		{
			return $this->dateAdded;
		}

		public function getArtOwnerName()
		{
			return $this->ownerName;
		}

		public function getArtOwnerAvatar()
		{
			return $this->ownerAvatar;
		}

		public function getArtOwnerId()
		{
			return $this->ownerId;
		}
	}

	$art = new ArtContr($artId);
} else {
	header("Location: home?error=artnotfound");
	exit();
}
