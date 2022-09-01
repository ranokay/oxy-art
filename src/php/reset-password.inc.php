<?php

if (isset($_POST['reset-password-submit'])) {
	$selector = $_POST['selector'];
	$validator = $_POST['validator'];
	$password = $_POST['password'];
	$confirmPassword = $_POST['confirmPassword'];

	include_once 'dbh.inc.php';

	class ResetPassword extends Dbh
	{
		protected function updatePassword($selector, $validator, $password)
		{
			$currentDate = date("U");
			$sql = "SELECT * FROM password_reset WHERE `reset_selector` = ? AND `reset_expires` >= ?;";
			$stmt = $this->connect()->prepare($sql);

			if (!$stmt->execute([$selector, $currentDate])) {
				$stmt = null;
				header("Location: ../reset-password?error=stmtfailed");
				exit();
			}
			if ($stmt->rowCount() == 0) {
				$stmt = null;
				header("Location: ../reset-password?error=invalidtoken");
				exit();
			}
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$tokenBin = hex2bin($validator);
			$tokenCheck = password_verify($tokenBin, $result[0]['reset_token']);

			if ($tokenCheck === false) {
				$stmt = null;
				header("Location: ../reset-password?error=invalidtoken");
				exit();
			} else if ($tokenCheck === true) {
				$tokenEmail = $result[0]['reset_email'];
				$sql = "SELECT * FROM users WHERE `email` = ?;";
				$stmt = $this->connect()->prepare($sql);

				if (!$stmt->execute([$tokenEmail])) {
					$stmt = null;
					header("Location: ../reset-password?error=stmtfailed");
					exit();
				}
				if ($stmt->rowCount() == 0) {
					$stmt = null;
					header("Location: ../reset-password?error=invalidtoken");
					exit();
				}
			}
			$sql = "UPDATE users SET `password` = ? WHERE `email` = ?;";
			$stmt = $this->connect()->prepare($sql);

			$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

			if (!$stmt->execute([$hashedPassword, $tokenEmail])) {
				$stmt = null;
				header("Location: ../reset-password?error=stmtfailed");
				exit();
			}
			$sql = "DELETE FROM password_reset WHERE `reset_email` = ?;";
			$stmt = $this->connect()->prepare($sql);

			if (!$stmt->execute([$tokenEmail])) {
				$stmt = null;
				header("Location: ../reset-password?error=stmtfailed");
				exit();
			}
			$stmt = null;
		}
	}

	class ResetPasswordContr extends ResetPassword
	{
		private $selector;
		private $validator;
		private $password;
		private $confirmPassword;

		public function __construct($selector, $validator, $password, $confirmPassword)
		{
			$this->selector = $selector;
			$this->validator = $validator;
			$this->password = $password;
			$this->confirmPassword = $confirmPassword;
		}
		public function resetPassword()
		{
			if ($this->emptyFields() == false) {
				header("Location: ../create-new-password?selector=" . $this->selector . "&validator=" . $this->validator . "&error=emptyfields");
				exit();
			}
			if ($this->validatePasswordLength() == false) {
				header("Location: ../create-new-password?selector=" . $this->selector . "&validator=" . $this->validator . "&error=passwordlength");
				exit();
			}
			if ($this->validatePassword() == false) {
				header("Location: ../create-new-password?selector=" . $this->selector . "&validator=" . $this->validator . "&error=invalidpassword");
				exit();
			}
			if ($this->passwordsMatch() == false) {
				header("Location: ../create-new-password?selector=" . $this->selector . "&validator=" . $this->validator . "&error=passwordmatch");
				exit();
			}
			$this->updatePassword($this->selector, $this->validator, $this->password);
		}
		private function emptyFields()
		{
			if (empty($this->password) || empty($this->confirmPassword)) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
		private function validatePasswordLength()
		{
			if (strlen($this->password) < 8 || strlen($this->password) > 25) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
		private function validatePassword()
		{
			$number = preg_match('/[0-9]/', $this->password);
			$letter = preg_match('/[a-z]/', $this->password);
			$upper = preg_match('/[A-Z]/', $this->password);
			$specialChars = preg_match('/[^\w]/', $this->password);
			if (!$number || !$letter || !$upper || !$specialChars) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
		private function passwordsMatch()
		{
			if ($this->password != $this->confirmPassword) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
	}
	$resetPassword = new ResetPasswordContr($selector, $validator, $password, $confirmPassword);
	$resetPassword->resetPassword();

	session_unset();
	session_destroy();

	header("Location: ../login?reset=passwordupdated");
} else {
	header("Location: ../home");
}
