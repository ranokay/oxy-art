<?php
session_start();

if (isset($_POST['edit-art'])) {
	$artName = $_POST['art-name'];
	$artDesc = $_POST['art-desc'];
	$artId = $_GET['artId'];
	$url = "art?id=$artId";
	$checkbox = $_POST['checkbox-art-public'];

	include "dbh.inc.php";

	class UpdateArt extends Dbh
	{
		protected function updateArt($artName, $artDesc, $artId, $url, $checkbox)
		{
			if (isset($artName)) {
				$sql = "UPDATE `arts` SET `name` = ? WHERE `id` = ?;";
				$stmt = $this->connect()->prepare($sql);
				if (!$stmt->execute([ucfirst($artName), $artId])) {
					$stmt = null;
					$_SESSION['error'] = "Failed to update art name! Try again later.";
					header("Location: ../$url");
					exit();
				}
			}

			if (isset($artDesc)) {
				$sql = "UPDATE `arts` SET `description` = ? WHERE `id` = ?;";
				$stmt = $this->connect()->prepare($sql);
				if (!$stmt->execute([ucfirst($artDesc), $artId])) {
					$stmt = null;
					$_SESSION['error'] = "Failed to update art description! Try again later.";
					header("Location: ../$url");
					exit();
				}
			}

			if (isset($checkbox)) {
				$sql = "UPDATE `arts` SET `public` = 1 WHERE `id` = ?;";
				$stmt = $this->connect()->prepare($sql);
				if (!$stmt->execute([$artId])) {
					$stmt = null;
					$_SESSION['error'] = "Failed to update art public status";
					header("Location: ../$url");
					exit();
				}
			} else {
				$sql = "UPDATE `arts` SET `public` = 0 WHERE `id` = ?;";
				$stmt = $this->connect()->prepare($sql);
				if (!$stmt->execute([$artId])) {
					$stmt = null;
					$_SESSION['error'] = "Failed to update art public status";
					header("Location: ../$url");
					exit();
				}
			}
			$stmt = null;
			$_SESSION['success'] = "Art updated successfully!";
			header("Location: ../$url");
			exit();
		}
	}
	class UpdateContr extends UpdateArt
	{
		public function __construct($artName, $artDesc, $artId, $url, $checkbox)
		{
			$this->artName = $artName;
			$this->artDesc = $artDesc;
			$this->artId = $artId;
			$this->url = $url;
			$this->checkbox = $checkbox;
		}

		public function editArt()
		{
			if ($this->emptyFields() === false) {
				$_SESSION['error'] = "Please fill in all fields.";
				header("Location: ../$this->url");
				exit();
			}
			if (!empty($this->artName) && $this->validateName() === false) {
				$_SESSION['error'] = "Name must be between 3 and 25 characters and only contain letters.";
				header("Location: ../$this->url");
				exit();
			}
			if (!empty($this->artDesc) && $this->validateDesc() === false) {
				$_SESSION['error'] = "Description must be between 10 and 300 characters and only contain letters, numbers and some special characters (. , : ; - _ () [] {} ! ? / &).";
				header("Location: ../$this->url");
				exit();
			}
			$this->updateArt($this->artName, $this->artDesc, $this->artId, $this->url, $this->checkbox);
		}
		private function emptyFields()
		{
			if (empty($this->artName) || empty($this->artDesc)) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
		private function validateName()
		{
			if (!preg_match("/^[a-zA-Z ]*$/", $this->artName)) {
				$result = false;
			} else if (strlen($this->artName) < 3 || strlen($this->artName) > 25) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
		private function validateDesc()
		{
			$desc = trim($this->artDesc);
			$desc = stripslashes($desc);
			$desc = htmlspecialchars($desc);
			if (!preg_match("/^[A-Za-z0-9\s\.,:;\-_()\[\]{}!\?\/&]*$/", $desc)) {
				$result = false;
			} else if (strlen($desc) < 10 || strlen($desc) > 300) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
	}
	$update = new UpdateContr($artName, $artDesc, $artId, $url, $checkbox);
	$update->editArt();
} else {
	header("Location: ../home");
	exit();
}
