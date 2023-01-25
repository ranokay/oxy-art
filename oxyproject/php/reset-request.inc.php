<?php
session_start();
session_unset();
session_destroy();
session_start();

if (isset($_POST['reset-request-submit'])) {
	$userEmail = $_POST['email'];

	include "dbh.inc.php";

	class ResetRequest extends Dbh
	{
		protected function getEmail($userEmail)
		{
			$sql = "SELECT * FROM users WHERE `email` = ?;";
			$stmt = $this->connect()->prepare($sql);

			if (!$stmt->execute([$userEmail])) {
				$stmt = null;
				$_SESSION['error'] = "Failed to send reset request! Please try again later.";
				header("Location: ../reset-password-request.php");
				exit();
			}
			if ($stmt->rowCount() === 0) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
		protected function deleteToken($userEmail)
		{
			$sql = "DELETE FROM password_reset WHERE `reset_email` = ?;";
			$stmt = $this->connect()->prepare($sql);

			if (!$stmt->execute([$userEmail])) {
				$stmt = null;
				$_SESSION['error'] = "Failed to send reset request! Please try again later.";
				header("Location: ../reset-password-request.php");
				exit();
			}
		}
		protected function setToken($userEmail)
		{
			$selector = bin2hex(random_bytes(8));
			$token = random_bytes(32);
			$url = "https://localhost:3000/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

			$expires = date("U") + 1800;

			$sql = "INSERT INTO password_reset (`reset_email`, `reset_selector`, `reset_token`, `reset_expires`) VALUES (?, ?, ?, ?);";
			$stmt = $this->connect()->prepare($sql);

			$hashedToken = password_hash($token, PASSWORD_BCRYPT);

			if (!$stmt->execute([$userEmail, $selector, $hashedToken, $expires])) {
				$stmt = null;
				$_SESSION['error'] = "Failed to send reset request! Please try again later.";
				header("Location: ../reset-password-request.php");
				exit();
			}

			$to = $userEmail;
			$subject = "OxyProject - Reset your password.";
			$message = "<p>We received a password reset request. The link to reset your password is below. If you did not make this request, you can ignore this email</p>
									<p>Here is your password reset link:</p>
									<a href='" . $url . "'>Reset Password</a>";
			$headers = "From: OxyProject <8dimmusic@gmail.com>\r\n";
			$headers .= "Reply-To: 8dimmusic@gmail.com\r\n";
			$headers .= "Content-type: text/html\r\n";

			mail($to, $subject, $message, $headers);

			$stmt = null;
			$_SESSION['success'] = "Email sent to <span style='font-weight: bold;'>" . $userEmail . "</span> with further instructions.";
			header("Location: ../reset-password-request.php");
			exit();
		}
	}

	class ResetRequestContr extends ResetRequest
	{
		private $email;
		public function __construct($userEmail)
		{
			$this->email = $userEmail;
		}
		public function resetRequest()
		{
			if ($this->emptyFields() == false) {
				$_SESSION['error'] = "Please fill in all fields.";
				header("Location: ../reset-password-request.php");
				exit();
			}
			if ($this->userNotFound() == false) {
				$_SESSION['error'] = "No user found with that email.";
				header("Location: ../reset-password-request.php");
				exit();
			}
			$this->deleteToken($this->email);
			$this->setToken($this->email);
		}
		private function emptyFields()
		{
			if (empty($this->email)) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
		private function userNotFound()
		{
			if (!$this->getEmail($this->email)) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
	}
	$resetRequest = new ResetRequestContr($userEmail);
	$resetRequest->resetRequest();
} else {
	header("Location: ../index.php");
	exit();
}