<?php
session_start();

if (isset($_POST['send-message'])) {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$subject = $_POST['subject'];
	$message = $_POST['message'];

	include "dbh.inc.php";

	class SendMessage extends Dbh
	{
		protected function sendMessage($name, $email, $subject, $message)
		{
			$to = "8dimmusic@gmail.com";
			$subject = $subject;
			$message = $message . "\r\n\r\n" . "From: " . $name . "\r\n" . "Email: " . $email;
			$headers = "From: " . $email;

			mail($to, $subject, $message, $headers);

			$_SESSION['success'] = "Message sent successfully! <br> We will get back to you as soon as possible.";
			header("Location: ../contact");
			exit();
		}
	}
	class SendMsgContr extends SendMessage
	{
		public function __construct($name, $email, $subject, $message)
		{
			$this->name = $name;
			$this->email = $email;
			$this->subject = $subject;
			$this->message = $message;
		}

		public function sendMessageCheck()
		{
			if ($this->emptyFields() === false) {
				$_SESSION['error'] = "Please fill in all fields.";
				header("Location: ../contact");
				exit();
			}
			if ($this->validateEmail() === false) {
				$_SESSION['error'] = "Please enter a valid email.";
				header("Location: ../contact");
				exit();
			}

			$this->sendMessage($this->name, $this->email, $this->subject, $this->message);
		}
		private function validateEmail()
		{
			if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
				return false;
			} else {
				return true;
			}
		}
		private function emptyFields()
		{
			if (empty($this->email) || empty($this->name) || empty($this->subject) || empty($this->message)) {
				return false;
			} else {
				return true;
			}
		}
	}
	$sendMsg = new SendMsgContr($name, $email, $subject, $message);
	$sendMsg->sendMessageCheck();
} else {
	header("Location: ../home");
	exit();
}
