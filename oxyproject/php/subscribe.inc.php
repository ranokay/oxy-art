<?php

if (isset($_POST['subscribe'])) {
	$userEmail = $_POST['email'];
	$url = $_SERVER['HTTP_REFERER'];

	if (str_contains($url, '?error'))
		$url = substr($url, 0, strpos($url, '?error'));

	include "dbh.inc.php";

	class Subscribe extends Dbh
	{
		protected function subscribe($userEmail, $url)
		{
			$sql = "SELECT `subscribed` FROM users WHERE `email` = ?;";
			$stmt = $this->connect()->prepare($sql);

			if (!$stmt->execute([$userEmail])) {
				$stmt = null;
				header("Location: $url?error=stmtfailed");
				exit();
			}
			if ($stmt->rowCount() == 0) {
				$stmt = null;
				header("Location: $url?error=usernotfound#footer");
				exit();
			}

			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if ($result[0]['subscribed'] == 1) {
				$stmt = null;
				header("Location: $url?error=alreadysubscribed#footer");
				exit();
			}
			$sql = "UPDATE users SET `subscribed` = 1 WHERE `email` = ?;";
			$stmt = $this->connect()->prepare($sql);

			if (!$stmt->execute([$userEmail])) {
				$stmt = null;
				header("Location: $url?error=stmtfailed");
				exit();
			}
			$stmt = null;

			$to = $userEmail;
			$subject = "Subscribed to the newsletter";
			$message = "You have successfully subscribed to the newsletter.";
			$headers = "From: OxyProject <octaw13@gmail.com>";

			mail($to, $subject, $message, $headers);
		}
	}
	class SubscribeContr extends Subscribe
	{
		private $email;
		public $url;

		public function __construct($email, $url)
		{
			$this->email = $email;
			$this->url = $url;
		}
		public function subscribeUser()
		{
			if ($this->emptyFields() == false) {
				header("Location: $this->url?error=emptyfields#footer");
				exit();
			}
			if ($this->validateEmail() == false) {
				header("Location: $this->url?error=invalidemail#footer");
				exit();
			}

			$this->subscribe($this->email, $this->url);
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
	$subscribe = new SubscribeContr($userEmail, $url);
	$subscribe->subscribeUser();

	header("Location: $url?success=subscribed#footer");
} else {
	header("Location: ../home");
}
