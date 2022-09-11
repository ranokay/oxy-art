<?php
session_start();

if (isset($_POST['save-changes'])) {
	$fullName = $_POST['fullName'];
	$username = $_POST['username'];
	$email = $_POST['email'];
	$userID = $_SESSION['userID'];

	include "dbh.inc.php";

	class UpdateUser extends Dbh
	{
		protected function updateUser($fullName, $username, $email, $userID)
		{
			if (isset($fullName) && !empty($fullName)) {
				$sql = "UPDATE `users` SET `full_name` = ? WHERE `id` = ?;";
				$stmt = $this->connect()->prepare($sql);
				if (!$stmt->execute([ucwords($fullName), $userID])) {
					$stmt = null;
					$_SESSION['error'] = "Failed to update full name!";
					header("Location: ../edit-profile");
					exit();
				}
			}

			if (isset($username) && !empty($username)) {
				$sql = "UPDATE `users` SET `username` = ? WHERE `id` = ?;";
				$stmt = $this->connect()->prepare($sql);
				if (!$stmt->execute([lcfirst($username), $userID])) {
					$stmt = null;
					$_SESSION['error'] = "Failed to update username!";
					header("Location: ../edit-profile");
					exit();
				}
			}

			if (isset($email) && !empty($email)) {
				$vKey = random_bytes(32);
				$urlMail = "https://localhost:3000/php/verify.inc.php?email=" . $email . "&vkey=" . bin2hex($vKey);
				$hashedKey = password_hash($vKey, PASSWORD_BCRYPT);

				$sql = "UPDATE `users` SET `email` = ?, `v_key` = ?,  `verified` = 0 WHERE `id` = ?;";
				$stmt = $this->connect()->prepare($sql);

				if (!$stmt->execute([$email, $hashedKey, $userID])) {
					$stmt = null;
					$_SESSION['error'] = "Failed to update email!";
					header("Location: ../edit-profile");
					exit();
				}

				$to = $email;
				$subject = "OxyProject - New Email Verification";
				$message = '<p>Verify your new email address.</p>
									<p>Please click the link below to activate your account:</p>
									<a href="' . $urlMail . '">Verify Email</a>';
				$headers = "From: OxyProject <8dimmusic@gmail.com>\r\n";
				$headers .= "Content-type: text/html\r\n";

				mail($to, $subject, $message, $headers);

				$stmt = null;
				session_unset();
				session_destroy();
				session_start();
				$_SESSION['success'] = "Email updated! Please verify your new email address.";
				header("Location: ../login");
				exit();
			}

			$stmt = null;
			$_SESSION['success'] = "Profile updated!";
			header("Location: ../edit-profile");
			exit();
		}

		protected function checkUsername($username)
		{
			if (isset($username) && !empty($username)) {
				$sql = "SELECT `id` FROM users WHERE `username` = ?;";
				$stmt = $this->connect()->prepare($sql);

				if (!$stmt->execute([$username])) {
					$stmt = null;
					$_SESSION['error'] = "Failed to check username!";
					header("Location: ../edit-profile");
					exit();
				}
				if ($stmt->rowCount() > 0) {
					$result = false;
				} else {
					$result = true;
				}
				return $result;
			}
		}
		protected function checkEmail($email)
		{
			if (isset($email) && !empty($email)) {
				$sql = "SELECT `id` FROM users WHERE `email` = ?;";
				$stmt = $this->connect()->prepare($sql);

				if (!$stmt->execute([$email])) {
					$stmt = null;
					$_SESSION['error'] = "Failed to check email!";
					header("Location: ../edit-profile");
					exit();
				}
				if ($stmt->rowCount() > 0) {
					$result = false;
				} else {
					$result = true;
				}
				return $result;
			}
		}
	}
	class UpdateContr extends UpdateUser
	{
		public function __construct($fullName, $username, $email, $userID)
		{
			$this->fullName = $fullName;
			$this->username = $username;
			$this->email = $email;
			$this->userID = $userID;
		}

		public function editUser()
		{
			if ($this->emptyFields() === false) {
				$_SESSION['error'] = "Please fill in at least one field!";
				header("Location: ../edit-profile");
				exit();
			}
			if (!empty($this->fullName) && $this->validateFullName() === false) {
				$_SESSION['error'] = "Full name must be between 3 and 50 characters!";
				header("Location: ../edit-profile");
				exit();
			}
			if (!empty($this->username) && $this->validateUsername() === false) {
				$_SESSION['error'] = "Username must be between 3 and 25 characters and can only contain letters, numbers and underscores!";
				header("Location: ../edit-profile");
				exit();
			}
			if (!empty($this->email) && $this->validateEmail() === false) {
				$_SESSION['error'] = "Please enter a valid email!";
				header("Location: ../edit-profile");
				exit();
			}
			if (!empty($this->username) && $this->usernameTakenCheck() === false) {
				$_SESSION['error'] = "Username already taken!";
				header("Location: ../edit-profile");
				exit();
			}
			if (!empty($this->email) && $this->emailTakenCheck() === false) {
				$_SESSION['error'] = "Email already taken!";
				header("Location: ../edit-profile");
				exit();
			}
			$this->updateUser($this->fullName, $this->username, $this->email, $this->userID);
		}
		private function emptyFields()
		{
			if (empty($this->fullName) && empty($this->username) && empty($this->email)) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
		private function validateFullName()
		{
			if (!preg_match("/^[a-zA-Z ]*$/", $this->fullName)) {
				$result = false;
			} else if (strlen($this->fullName) < 3 || strlen($this->fullName) > 50) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
		private function validateUsername()
		{
			if (!preg_match("/^[a-zA-Z0-9_]*$/", $this->username)) {
				$result = false;
			} else if (strlen($this->username) < 3 || strlen($this->username) > 25) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
		private function validateEmail()
		{
			if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
		private function usernameTakenCheck()
		{
			if (!$this->checkUsername($this->username)) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
		private function emailTakenCheck()
		{
			if (!$this->checkEmail($this->email)) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
	}
	$update = new UpdateContr($fullName, $username, $email, $userID);
	$update->editUser();
} else {
	header("Location: ../home");
	exit();
}
