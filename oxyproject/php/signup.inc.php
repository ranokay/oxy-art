<?php
session_start();

if (isset($_POST['submit'])) {
	$fullName = $_POST['fullName'];
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$confirmPassword = $_POST['confirmPassword'];
	$checkbox = $_POST['checkbox'];

	include "dbh.inc.php";

	class Signup extends Dbh
	{
		protected function setUser($fullName, $username, $email, $password)
		{
			$vKey = random_bytes(32);
			// $urlMail = "https://oxyproject.herokuapp.com/php/verify.inc.php?email=" . $email . "&vkey=" . bin2hex($vKey);
			$urlMail = "https://localhost:3000/php/verify.inc.php?email=" . $email . "&vkey=" . bin2hex($vKey);

			$sql = "INSERT INTO users (`full_name`, `username`, `email`, `v_key`, `password`) VALUES (?, ?, ?, ?, ?);";
			$stmt = $this->connect()->prepare($sql);

			$hashedKey = password_hash($vKey, PASSWORD_BCRYPT);
			$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

			if (!$stmt->execute([ucfirst(trim($fullName)), lcfirst(trim($username)), trim($email), $hashedKey, $hashedPassword])) {
				$stmt = null;
				$_SESSION['error'] = "Failed to create user!";
				header("Location: ../signup");
				exit();
			}

			$to = $email;
			$subject = "OxyProject - Account Verification";
			$message = '<p>Thank you for signing up!</p>
									<p>Please click the link below to activate your account:</p>
									<a href="' . $urlMail . '">Verify Account</a>';
			$headers = "From: OxyProject <8dimmusic@gmail.com>\r\n";
			$headers .= "Reply-To: 8dimmusic@gmail.com\r\n";
			$headers .= "Content-type: text/html\r\n";

			mail($to, $subject, $message, $headers);

			$stmt = null;
			$_SESSION['success'] = "Account created successfully. Please check your email to verify your account!";
			header("Location: ../login");
			exit();
		}
		protected function checkUsername($username)
		{
			$sql = "SELECT `id` FROM users WHERE `username` = ?;";
			$stmt = $this->connect()->prepare($sql);

			if (!$stmt->execute([$username])) {
				$stmt = null;
				$_SESSION['error'] = "Failed to check username!";
				header("Location: ../signup");
				exit();
			}
			if ($stmt->rowCount() > 0) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
		protected function checkEmail($email)
		{
			$sql = "SELECT `id` FROM users WHERE `email` = ?;";
			$stmt = $this->connect()->prepare($sql);

			if (!$stmt->execute([$email])) {
				$stmt = null;
				$_SESSION['error'] = "Failed to check email!";
				header("Location: ../signup");
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
	class SignupContr extends Signup
	{
		public function __construct($fullName, $username, $email, $password, $confirmPassword, $checkbox)
		{
			$this->fullName = ucwords($fullName);
			$this->username = $username;
			$this->email = $email;
			$this->password = $password;
			$this->confirmPassword = $confirmPassword;
			$this->checkbox = $checkbox;
		}
		public function signupUser()
		{
			if ($this->emptyFields() == false) {
				$_SESSION['error'] = "Please fill in all fields!";
				header("Location: ../signup");
				exit();
			}
			if ($this->validateFullName() === false) {
				$_SESSION['error'] = "Full name must be between 3 and 50 characters!";
				header("Location: ../signup");
				exit();
			}
			if ($this->validateUsername() === false) {
				$_SESSION['error'] = "Username must be between 3 and 25 characters and can only contain letters, numbers and underscores!";
				header("Location: ../signup");
				exit();
			}
			if ($this->validateEmail() === false) {
				$_SESSION['error'] = "Please enter a valid email!";
				header("Location: ../signup");
				exit();
			}
			if ($this->validatePasswordLength() === false) {
				$_SESSION['error'] = "Password must be between 8 and 30 characters!";
				header("Location: ../signup");
				exit();
			}
			if ($this->validatePassword() === false) {
				$_SESSION['error'] = "Password must contain at least one number, one uppercase and lowercase letter, and one special character!";
				header("Location: ../signup");
				exit();
			}
			if ($this->passwordsMatch() === false) {
				$_SESSION['error'] = "Passwords do not match!";
				header("Location: ../signup");
				exit();
			}
			if ($this->validateCheckbox() === false) {
				$_SESSION['error'] = "Please accept the terms and conditions!";
				header("Location: ../signup");
				exit();
			}
			if ($this->usernameTakenCheck() === false) {
				$_SESSION['error'] = "Username already taken!";
				header("Location: ../signup");
				exit();
			}
			if ($this->emailTakenCheck() === false) {
				$_SESSION['error'] = "Email already taken!";
				header("Location: ../signup");
				exit();
			}
			$this->setUser($this->fullName, $this->username, $this->email, $this->password);
		}
		private function emptyFields()
		{
			if (empty($this->fullName) || empty($this->username) || empty($this->email) || empty($this->password) || empty($this->confirmPassword)) {
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
		private function validatePasswordLength()
		{
			if (strlen($this->password) < 8 || strlen($this->password) > 30) {
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
			if ($this->password !== $this->confirmPassword) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
		private function validateCheckbox()
		{
			if (!filter_has_var(INPUT_POST, $this->checkbox)) {
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
	$signup = new SignupContr($fullName, $username, $email, $password, $confirmPassword, $checkbox);
	$signup->signupUser();
} else {
	header("Location: ../home");
	exit();
}
