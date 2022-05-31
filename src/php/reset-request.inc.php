<?php
session_start();
session_unset();
session_destroy();

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
				header("Location: ../reset-password.php?error=stmtfailed");
				exit();
			}
			if ($stmt->rowCount() == 0) {
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
				header("Location: ../reset-password.php?error=stmtfailed");
				exit();
			}
		}
		protected function setToken($userEmail)
		{
			$selector = bin2hex(random_bytes(8));
			$token = random_bytes(32);
			$url = "http://localhost/OxyProject/oxyproject/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

			$expires = date("U") + 1800;

			$sql = "INSERT INTO password_reset (`reset_email`, `reset_selector`, `reset_token`, `reset_expires`) VALUES (?, ?, ?, ?);";
			$stmt = $this->connect()->prepare($sql);

			$hashedToken = password_hash($token, PASSWORD_BCRYPT);

			if (!$stmt->execute([$userEmail, $selector, $hashedToken, $expires])) {
				$stmt = null;
				header("Location: ../reset-password.php?error=stmtfailed");
				exit();
			}
			$stmt = null;

			$to = $userEmail;
			$subject = "OxyProject - Reset your password.";
			$message = "<p>We received a password reset request. The link to reset your password is below. If you did not make this request, you can ignore this email</p>
									<p>Here is your password reset link:</p>
									<a style='
										display: flex;
										white-space: nowrap;
										text-align: center;
										border-radius: 0.5rem;
										text-decoration: none;
										padding: .5rem 1rem;
										font-size: 1rem;
										width: fit-content;
										background-color: hsl(214, 20%, 34%);
										color: white;'
										href='" . $url . "'>Reset Password</a>";
			$headers = "From: OxyProject <chief5465@gmail.com>\r\n";
			$headers .= "Reply-To: chief5465@gmail.com\r\n";
			$headers .= "Content-type: text/html\r\n";

			mail($to, $subject, $message, $headers);
		}
	}

	class ResetRequestContr extends ResetRequest
	{
		public function __construct($userEmail)
		{
			$this->email = $userEmail;
		}
		public function resetRequest()
		{
			if ($this->emptyFields() == false) {
				header("Location: ../reset-password.php?error=emptyfields");
				exit();
			}
			if ($this->userNotFound() == false) {
				header("Location: ../reset-password.php?error=usernotfound");
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

	header("Location: ../reset-password.php?reset=success");
} else {
	header("Location: ../index.php");
}
