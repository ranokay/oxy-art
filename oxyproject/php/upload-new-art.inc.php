<?php
session_start();

if (isset($_POST['upload-art'])) {
	$userID = $_SESSION['userID'];
	$artName = $_POST['art-name'];
	$artDesc = $_POST['art-desc'];
	$checkbox = $_POST['checkbox-art-public'];
	$fileSize = $_FILES['art-file']['size'];
	$fileError = $_FILES['art-file']['error'];

	include "dbh.inc.php";

	class UploadNewArt extends Dbh
	{
		protected function uploadNewArt($artName, $artDesc, $userID, $checkbox)
		{
			$fileName = $_FILES['art-file']['name'];
			$fileTmpName = $_FILES['art-file']['tmp_name'];
			$fileExt = explode('.', $fileName);
			$fileActualExt = strtolower(end($fileExt));
			$allowed = array('jpg', 'jpeg', 'png', 'svg', 'gif');

			if (!in_array($fileActualExt, $allowed)) {
				$_SESSION['error'] = "You cannot upload files of this type! Only JPG, JPEG, PNG, SVG and GIF files are allowed.";
				header("Location: ../new-art");
				exit();
			}

			$uniqueString = uniqid('', true) . $userID;
			$fileNewName = bin2hex($uniqueString) . "." . $fileActualExt;
			if (!is_dir('../assets/collection/' . $userID)) {
				mkdir('../assets/collection/' . $userID);
			}
			$artDir = '../assets/collection/' . $userID . '/' . $fileNewName;
			move_uploaded_file($fileTmpName, $artDir);
			function checkPublic($checkbox)
			{
				if (isset($checkbox)) {
					return 1;
				} else {
					return 0;
				}
			}

			$sql = "INSERT INTO `arts` (`name`, `description`, `owner_id`, `art_dir`, `public`) VALUES (?, ?, ?, ?, ?);";
			$stmt = $this->connect()->prepare($sql);

			if (!$stmt->execute([ucfirst(trim($artName)), ucfirst(trim($artDesc)), $userID, $artDir, checkPublic($checkbox)])) {
				$_SESSION['error'] = "Something went wrong. Please try again later.";
				header("Location: ../new-art");
				exit();
			}
			$_SESSION['success'] = "Art uploaded successfully!";
			header("Location: ../dashboard");
			exit();
		}
	}
	class UploadContr extends UploadNewArt
	{
		public function __construct($artName, $artDesc, $userID, $checkbox, $fileSize, $fileError)
		{
			$this->artName = $artName;
			$this->artDesc = $artDesc;
			$this->userID = $userID;
			$this->checkbox = $checkbox;
			$this->fileSize = $fileSize;
			$this->fileError = $fileError;
		}

		public function uploadArt()
		{
			if ($this->emptyFields() === false) {
				$_SESSION['error'] = "Please fill in all fields.";
				header("Location: ../new-art");
				exit();
			}
			if (!empty($this->artName) && $this->validateName() === false) {
				$_SESSION['error'] = "Name must be between 3 and 25 characters and only contain letters.";
				header("Location: ../new-art");
				exit();
			}
			if (!empty($this->artDesc) && $this->validateDesc() === false) {
				$_SESSION['error'] = "Description must be between 10 and 300 characters and only contain letters, numbers and punctuation.";
				header("Location: ../new-art");
				exit();
			}
			if ($this->validFileSize() === false) {
				$_SESSION['error'] = "File size must be less than 10MB.";
				header("Location: ../new-art");
				exit();
			}
			if ($this->validFileError() === false) {
				$_SESSION['error'] = "Something went wrong. Please try again later.";
				header("Location: ../new-art");
				exit();
			}
			$this->uploadNewArt($this->artName, $this->artDesc, $this->userID, $this->checkbox);
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
			if (!$desc) {
				$result = false;
			} else if (strlen($desc) < 10 || strlen($desc) > 300) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
		private function validFileSize()
		{
			define('MB', 1048576);
			if ($this->fileSize > 10 * MB) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
		private function validFileError()
		{
			if ($this->fileError !== 0) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
	}
	$upload = new UploadContr($artName, $artDesc, $userID, $checkbox, $fileSize, $fileError);
	$upload->uploadArt();
} else {
	header("Location: ../home");
	exit();
}
