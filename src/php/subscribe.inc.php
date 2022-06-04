<?php

if (isset($_POST['subscribe'])) {
	$userEmail = $_POST['email'];

	include "dbh.inc.php";

	class Subscribe extends Dbh
	{
		protected function subscribe($userEmail)
		{
			$sql = "SELECT `subscribed` FROM users WHERE `email` = ?;";
			$stmt = $this->connect()->prepare($sql);

			if (!$stmt->execute([$userEmail])) {
				$stmt = null;
				header("Location: ..?error=stmtfailed");
				exit();
			}
			if ($stmt->rowCount() == 0) {
				$stmt = null;
				header("Location: ..?error=invalidemail#footer");
				exit();
			}

			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if ($result[0]['subscribed'] == 1) {
				$stmt = null;
				header("Location: ..?error=alreadysubscribed#footer");
				exit();
			}
			$sql = "UPDATE users SET `subscribed` = 1 WHERE `email` = ?;";
			$stmt = $this->connect()->prepare($sql);

			if (!$stmt->execute([$userEmail])) {
				$stmt = null;
				header("Location: ..?error=stmtfailed");
				exit();
			}
			$stmt = null;

			$to = $userEmail;
			$subject = "Subscribed to the newsletter";
			$message = "You have successfully subscribed to the newsletter.";
			$headers = "From: OxyProject <chief5465@gmail.com>";

			mail($to, $subject, $message, $headers);
		}
	}
	class SubscribeContr extends Subscribe
	{
		private $email;

		public function __construct($email)
		{
			$this->email = $email;
		}
		public function subscribeUser()
		{
			if ($this->emptyFields() == false) {
				header("Location: ..?error=emptyfields#footer");
				exit();
			}
			if ($this->validateEmail() == false) {
				header("Location: ..?error=invalidemail#footer");
				exit();
			}

			$this->subscribe($this->email);
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
		private function emptyFields()
		{
			if (empty($this->email)) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
	}
	$subscribe = new SubscribeContr($userEmail);
	$subscribe->subscribeUser();

	header("Location: ..?error=success#footer");
} else {
	header("Location: ..");
}
