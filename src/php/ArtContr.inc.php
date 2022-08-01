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
	}

	class ArtContr extends Art
	{
		public $name;
		public $owner;
		public $description;
		public $dateAdded;
		public $artDir;

		public function __construct($artId)
		{
			$art = $this->getArt($artId);
			$this->name = $art[0]['name'];
			$this->owner = $art[0]['owner_id'];
			$this->description = $art[0]['description'];
			$this->dateAdded = $art[0]['date_added'];
			$this->artDir = $art[0]['art_dir'];
		}

		public function getArtName()
		{
			return $this->name;
		}

		public function getArtDir()
		{
			return $this->artDir;
		}

		public function getArtOwner()
		{
			return $this->owner;
		}

		public function getArtDescription()
		{
			return $this->description;
		}

		public function getArtDateAdded()
		{
			return $this->dateAdded;
		}

		public function getArtOwnerName()
		{
			$user = new UserContr($this->owner);
			return $user->getUserName();
		}
	}

	$art = new ArtContr($artId);
} else {
	header("Location: home?error=artnotfound");
	exit();
}
