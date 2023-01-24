<?php
session_start();

if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	include "dbh.inc.php";

	class Login extends Dbh
	{
		protected function getUser($username, $password)
		{
			$sql = "SELECT `password` FROM users WHERE `username` = ? OR `email` = ?;";
			$stmt = $this->connect()->prepare($sql);

			if (!$stmt->execute([$username, $username])) {
				$stmt = null;
				$_SESSION['error'] = "Failed to connect to server. Please try again later.";
				header("Location: ../login.php");
				exit();
			}
			if ($stmt->rowCount() == 0) {
				$stmt = null;
				$_SESSION['error'] = "User not found!";
				header("Location: ../login.php");
				exit();
			}
			$passwordHashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$checkPassword = password_verify($password, $passwordHashed[0]['password']);

			if ($checkPassword === false) {
				$stmt = null;
				$_SESSION['error'] = "Password is incorrect!";
				header("Location: ../login.php");
				exit();
			} else if ($checkPassword === true) {
				$sql = "SELECT * FROM users WHERE (`username` = ? OR `email` = ?) AND `password` = ?;";
				$stmt = $this->connect()->prepare($sql);

				if (!$stmt->execute([$username, $username, $passwordHashed[0]['password']])) {
					$stmt = null;
					$_SESSION['error'] = "Failed to connect to server. Please try again later.";
					header("Location: ../login.php");
					exit();
				}
				if ($stmt->rowCount() === 0) {
					$stmt = null;
					$_SESSION['error'] = "User not found!";
					header("Location: ../login.php");
					exit();
				}
				$user = $stmt->fetchAll(PDO::FETCH_ASSOC);

				$_SESSION['userID'] = $user[0]['id'];
				$_SESSION['userType'] = $user[0]['user_type'];
				$stmt = null;
				header("Location: ../dashboard.php");
				exit();
			}
		}
	}
	class LoginContr extends Login
	{
		private $username;
		private $password;
		public function __construct($username, $password)
		{
			$this->username = $username;
			$this->password = $password;
		}
		public function loginUser()
		{
			if ($this->emptyFields() === false) {
				$_SESSION['error'] = "Please fill in all fields!";
				header("Location: ../login.php");
				exit();
			}
			if ($this->validPassword() === false) {
				$_SESSION['error'] = "Password is incorrect!";
				header("Location: ../login.php");
				exit();
			}
			$this->getUser($this->username, $this->password);
		}
		private function emptyFields()
		{
			if (empty($this->username) || empty($this->password)) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
		private function validPassword()
		{
			if (strlen($this->password) < 8 || strlen($this->password) > 30) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
	}
	$login = new LoginContr($username, $password);
	$login->loginUser();
} else {
	header("Location: ../index.php");
	exit();
}