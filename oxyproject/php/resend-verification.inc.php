<?php
session_start();

if (isset($_POST['resend'])) {
	$email = $_POST['email'];
	$userID = $_SESSION['userID'];

	include "dbh.inc.php";

	class ResendVerification  extends Dbh
	{
		public function resendVerification($email, $userID)
		{
			$vKey = random_bytes(32);
			$urlMail = "https://localhost:3000/php/verify.inc.php?email=" . $email . "&vkey=" . bin2hex($vKey);
			$hashedKey = password_hash($vKey, PASSWORD_BCRYPT);

			$sql = "UPDATE `users` SET `email` = ?, `v_key` = ?, `verified` = 0 WHERE `id` = ?;";
			$stmt = $this->connect()->prepare($sql);

			if (!$stmt->execute([$email, $hashedKey, $userID])) {
				$stmt = null;
				$_SESSION['error'] = "Something went wrong! Please try again.";
				header("Location: ../dashboard");
				exit();
			}

			$to = $email;
			$subject = "OxyProject - Account Verification";
			$message = '<p>Verify your account.</p>
									<p>Please click the link below to activate your account:</p>
									<a href="' . $urlMail . '">Verify Account</a>';
			$headers = "From: OxyProject <8dimmusic@gmail.com>\r\n";
			$headers .= "Content-type: text/html\r\n";

			mail($to, $subject, $message, $headers);

			$stmt = null;
			$_SESSION['success'] = "Verification email sent!";
			header("Location: ../dashboard");
			exit();
		}
	}

	$resend = new ResendVerification();
	$resend->resendVerification($email, $userID);
} else {
	header("Location: ../dashboard");
	exit();
}
