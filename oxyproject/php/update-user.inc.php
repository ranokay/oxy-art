<?php
session_start();

if (isset($_POST['save-changes'])) {
	$fullName = $_POST['fullName'];
	$username = $_POST['username'];
	$email = $_POST['email'];
	$userID = $_SESSION['userID'];
	$avatar = $_FILES['profile-img']['name'];
	$avatarSize = $_FILES['profile-img']['size'];
	$avatarError = $_FILES['profile-img']['error'];

	include "dbh.inc.php";

	class UpdateUser extends Dbh
	{
		protected function updateUser($fullName, $username, $email, $userID, $avatar)
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
				// $urlMail = "https://oxyproject.herokuapp.com/php/verify.inc.php?email=" . $email . "&vkey=" . bin2hex($vKey);
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
			if (isset($avatar) && !empty($avatar)) {
				$avatarTmp = $_FILES['profile-img']['tmp_name'];
				$fileExt = explode('.', $avatar);
				$fileActualExt = strtolower(end($fileExt));
				$allowed = array('jpg', 'jpeg', 'png');

				if (!in_array($fileActualExt, $allowed)) {
					$_SESSION['error'] = "You cannot upload files of this type! Only JPG, JPEG and PNG files are allowed.";
					header("Location: ../edit-profile");
					exit();
				}

				// Delete old avatar
				$sql = "SELECT `avatar` FROM `users` WHERE `id` = ?;";
				$stmt = $this->connect()->prepare($sql);
				$stmt->execute([$userID]);
				$oldAvatar = $stmt->fetch();
				$stmt = null;
				unlink($oldAvatar['avatar']);

				// Upload new avatar
				$avatarName = uniqid('', true) . "." . $fileActualExt;
				if (!is_dir('../assets/avatars/' . $userID)) {
					mkdir('../assets/avatars/' . $userID);
				}
				$avatarDestination = '../assets/avatars/' . $userID . '/' . $avatarName;
				move_uploaded_file($avatarTmp, $avatarDestination);

				$sql = "UPDATE `users` SET `avatar` = ? WHERE `id` = ?;";
				$stmt = $this->connect()->prepare($sql);
				if (!$stmt->execute([$avatarDestination, $userID])) {
					$stmt = null;
					$_SESSION['error'] = "Failed to update avatar!";
					header("Location: ../edit-profile");
					exit();
				}
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
		public function __construct($fullName, $username, $email, $userID, $avatar, $avatarError, $avatarSize)
		{
			$this->fullName = $fullName;
			$this->username = $username;
			$this->email = $email;
			$this->userID = $userID;
			$this->avatar = $avatar;
			$this->avatarError = $avatarError;
			$this->avatarSize = $avatarSize;
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
			if (!empty($this->avatar) && $this->avatarErrorCheck() === false) {
				$_SESSION['error'] = "There was an error uploading your file!";
				header("Location: ../edit-profile");
				exit();
			}
			if (!empty($this->avatar) && $this->avatarSizeCheck() === false) {
				$_SESSION['error'] = "Your file is too big! Max size is 5MB.";
				header("Location: ../edit-profile");
				exit();
			}
			$this->updateUser($this->fullName, $this->username, $this->email, $this->userID, $this->avatar);
		}
		private function emptyFields()
		{
			if (empty($this->fullName) && empty($this->username) && empty($this->email) && empty($this->avatar)) {
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
		private function avatarErrorCheck()
		{
			if ($this->avatarError !== 0) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
		private function avatarSizeCheck()
		{
			define('MB', 1048576);
			if ($this->avatarSize > 5 * MB) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
	}
	$update = new UpdateContr($fullName, $username, $email, $userID, $avatar, $avatarError, $avatarSize);
	$update->editUser();
} else {
	header("Location: ../home");
	exit();
}
