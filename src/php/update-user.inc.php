<?php
if (isset($_POST['save-changes'])) {
	$fullName = $_POST['fullName'];
	$username = $_POST['username'];
	$email = $_POST['email'];
	session_start();
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
					header("Location: home?error=stmtfailed");
					exit();
				}

				$stmt = null;
				header("Location: ../edit-profile?error=none");
				exit();
			}

			if (isset($username) && !empty($username)) {
				$sql = "UPDATE `users` SET `username` = ? WHERE `id` = ?;";
				$stmt = $this->connect()->prepare($sql);
				if (!$stmt->execute([lcfirst($username), $userID])) {
					$stmt = null;
					header("Location: home?error=stmtfailed");
					exit();
				}

				$stmt = null;
				header("Location: ../edit-profile?error=none");
				exit();
			}

			if (isset($email) && !empty($email)) {
				$vKey = random_bytes(32);
				$url = "https://localhost:3000/php/verify.inc.php?email=" . $email . "&vkey=" . bin2hex($vKey);
				$hashedKey = password_hash($vKey, PASSWORD_BCRYPT);

				$sql = "UPDATE `users` SET `email` = ?, `v_key` = ?,  `verified` = 0 WHERE `id` = ?;";
				$stmt = $this->connect()->prepare($sql);

				if (!$stmt->execute([$email, $hashedKey, $userID])) {
					$stmt = null;
					header("Location: home?error=stmtfailed");
					exit();
				}

				$to = $email;
				$subject = "OxyProject - New Email Verification";
				$message = '<p>Verify your new email address.</p>
									<p>Please click the link below to activate your account:</p>
									<a style="
									display: flex;
									white-space: nowrap;
									text-align: center;
									border-radius: 0.5rem;
									text-decoration: none;
									padding: .5rem 1rem;
									font-size: 1rem;
									width: fit-content;
									background-color: hsl(214, 20%, 34%);
									color: white;"
									href="' . $url . '">Verify Email</a>';
				$headers = "From: OxyProject <8dimmusic@gmail.com>\r\n";
				$headers .= "Content-type: text/html\r\n";

				mail($to, $subject, $message, $headers);

				$stmt = null;
				session_unset();
				session_destroy();
				header("Location: ../login?error=verify");
				exit();
			}
		}

		protected function checkUsername($username)
		{
			if (isset($username) && !empty($username)) {
				$sql = "SELECT `id` FROM users WHERE `username` = ?;";
				$stmt = $this->connect()->prepare($sql);

				if (!$stmt->execute([$username])) {
					$stmt = null;
					header("Location: ../edit-profile?error=stmtfailed");
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
					header("Location: ../edit-profile?error=stmtfailed");
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
		private $fullName;
		private $username;
		private $email;

		public function __construct($fullName, $username, $email, $userID)
		{
			$this->fullName = $fullName;
			$this->username = $username;
			$this->email = $email;
			$this->userID = $userID;
		}

		public function editUser()
		{
			if ($this->emptyFields() == false) {
				header("Location: ../edit-profile?error=emptyeditfields");
				exit();
			}
			if (!empty($this->fullName) && $this->validateFullName() == false) {
				header("Location: ../edit-profile?error=invalidfullname");
				exit();
			}
			if (!empty($this->username) && $this->validateUsername() == false) {
				header("Location: ../edit-profile?error=invalidusername");
				exit();
			}
			if (!empty($this->email) && $this->validateEmail() == false) {
				header("Location: ../edit-profile?error=invalidemail");
				exit();
			}
			if (!empty($this->username) && $this->usernameTakenCheck() == false) {
				header("Location: ../edit-profile?error=usernametaken");
				exit();
			}
			if (!empty($this->email) && $this->emailTakenCheck() == false) {
				header("Location: ../edit-profile?error=emailtaken");
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
			} else if (strlen($this->fullName) < 2 || strlen($this->fullName) > 25) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
		private function validateUsername()
		{
			if (!preg_match("/^[a-zA-Z0-9]*$/", $this->username)) {
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
	header("Location: home");
}
