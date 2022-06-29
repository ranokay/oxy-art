<?php
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
			$url = "http://localhost/OxyProject/oxyproject/php/verify.inc.php?email=" . $email . "&vkey=" . bin2hex($vKey);

			$sql = "INSERT INTO users (`full_name`, `username`, `email`, `v_key`, `password`) VALUES (?, ?, ?, ?, ?);";
			$stmt = $this->connect()->prepare($sql);

			$hashedKey = password_hash($vKey, PASSWORD_BCRYPT);
			$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

			if (!$stmt->execute([$fullName, $username, $email, $hashedKey, $hashedPassword])) {
				$stmt = null;
				header("Location: ../signup?error=stmtfailed");
				exit();
			}
			$stmt = null;

			$to = $email;
			$subject = "OxyProject - Account Verification";
			$message = '<p>Thank you for signing up!</p>
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
									href="' . $url . '">Verify Account</a>';
			$headers = "From: OxyProject <chief5465@gmail.com>\r\n";
			$headers .= "Content-type: text/html\r\n";

			mail($to, $subject, $message, $headers);
		}
		protected function checkUsername($username)
		{
			$sql = "SELECT `id` FROM users WHERE `username` = ?;";
			$stmt = $this->connect()->prepare($sql);

			if (!$stmt->execute([$username])) {
				$stmt = null;
				header("Location: ../signup?error=stmtfailed");
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
				header("Location: ../signup?error=stmtfailed");
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
		private $fullName;
		private $username;
		private $email;
		private $password;
		private $confirmPassword;
		private $checkbox;

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
				header("Location: ../signup?error=emptyfields");
				exit();
			}
			if ($this->validateFullName() == false) {
				header("Location: ../signup?error=invalidfullname");
				exit();
			}
			if ($this->validateUsername() == false) {
				header("Location: ../signup?error=invalidusername");
				exit();
			}
			if ($this->validateEmail() == false) {
				header("Location: ../signup?error=invalidmail");
				exit();
			}
			if ($this->validatePasswordLength() == false) {
				header("Location: ../signup?error=passwordlength");
				exit();
			}
			if ($this->validatePassword() == false) {
				header("Location: ../signup?error=invalidpassword");
				exit();
			}
			if ($this->passwordsMatch() == false) {
				header("Location: ../signup?error=passwordcheck");
				exit();
			}
			if ($this->validateCheckbox() == false) {
				header("Location: ../signup?error=checkbox");
				exit();
			}
			if ($this->usernameTakenCheck() == false) {
				header("Location: ../signup?error=usernameexists");
				exit();
			}
			if ($this->emailTakenCheck() == false) {
				header("Location: ../signup?error=emailexists");
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

	header("Location: ../login?signup=success");
} else {
	header("Location: ../home");
}
