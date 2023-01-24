<?php
session_start();

if (isset($_POST['subscribe'])) {
	$userEmail = $_POST['email'];
	$url = $_SERVER['HTTP_REFERER'] . '#footer';

	include "dbh.inc.php";

	class Subscribe extends Dbh
	{
		protected function subscribe($userEmail, $url)
		{
			$sql = "SELECT `subscribed` FROM users WHERE `email` = ?;";
			$stmt = $this->connect()->prepare($sql);

			if (!$stmt->execute([$userEmail])) {
				$stmt = null;
				$_SESSION['error-subs'] = 'Something went wrong!';
				header("Location: $url");
				exit();
			}
			if ($stmt->rowCount() === 0) {
				$stmt = null;
				$_SESSION['error-subs'] = "User with this email is not found!";
				header("Location: $url");
				exit();
			}

			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if ($result[0]['subscribed'] === 1) {
				$stmt = null;
				$_SESSION['error-subs'] = "You are already subscribed!";
				header("Location: $url");
				exit();
			}
			$sql = "UPDATE users SET `subscribed` = 1 WHERE `email` = ?;";
			$stmt = $this->connect()->prepare($sql);

			if (!$stmt->execute([$userEmail])) {
				$stmt = null;
				$_SESSION['error-subs'] = 'Something went wrong!';
				header("Location: $url");
				exit();
			}

			$to = $userEmail;
			$subject = "Subscribed to the newsletter";
			$message = "You have successfully subscribed to the newsletter.";
			$headers = "From: OxyProject <8dimmusic@gmail.com>";
			$headers .= "Reply-To: 8dimmusic@gmail.com\r\n";
			$headers .= "Content-type: text/html\r\n";

			mail($to, $subject, $message, $headers);

			$stmt = null;
			$_SESSION['success-subs'] = "You have successfully subscribed to the newsletter!";
			header("Location: $url");
			exit();
		}
	}
	class SubscribeContr extends Subscribe
	{
		private $email;
		private $url;
		public function __construct($email, $url)
		{
			$this->email = $email;
			$this->url = $url;
		}
		public function subscribeUser()
		{
			if ($this->emptyFields() === false) {
				$_SESSION['error-subs'] = "Please fill in all fields!";
				header("Location: $this->url");
				exit();
			}
			if ($this->validateEmail() === false) {
				$_SESSION['error-subs'] = "Please enter a valid email!";
				header("Location: $this->url");
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
} else {
	header("Location: ../index.php");
	exit();
}