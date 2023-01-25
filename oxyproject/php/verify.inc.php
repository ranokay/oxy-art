<?php
session_start();

function redirect()
{
	if (isset($_SESSION['userID'])) {
		header("Location: ../dashboard.php");
		exit();
	} else {
		header("Location: ../login.php");
		exit();
	}
}

if (isset($_GET['vkey']) && !empty($_GET['vkey'])) {
	$vKey = $_GET['vkey'];
	$email = $_GET['email'];

	include 'dbh.inc.php';

	class VerifyAccount extends Dbh
	{
		protected function verify($email, $vKey)
		{
			$sql = "SELECT `v_key`, `verified` FROM users WHERE `email` = ?;";
			$stmt = $this->connect()->prepare($sql);

			if (!$stmt->execute([$email])) {
				$stmt = null;
				$_SESSION['error'] = "Failed to verify account!";
				redirect();
				exit();
			}
			if ($stmt->rowCount() === 0) {
				$stmt = null;
				$_SESSION['error'] = "Failed to verify account!";
				redirect();
				exit();
			}
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if ($result[0]['verified'] === 1) {
				$stmt = null;
				$_SESSION['error'] = "Account already verified!";
				redirect();
				exit();
			}
			$keyBin = hex2bin($vKey);
			$checkVKey = password_verify($keyBin, $result[0]['v_key']);

			if ($checkVKey === false) {
				$stmt = null;
				$_SESSION['error'] = "Failed to verify account!";
				redirect();
				exit();
			}
			if ($checkVKey === true) {
				$sql = "UPDATE users SET `verified` = 1, `v_key` = 0 WHERE `email` = ?;";
				$stmt = $this->connect()->prepare($sql);

				if (!$stmt->execute([$email])) {
					$stmt = null;
					$_SESSION['error'] = "Failed to verify account!";
					redirect();
					exit();
				}
				$stmt = null;
				$_SESSION['success'] = "Account verified!";
				redirect();
				exit();
			}

			$stmt = null;
			exit();
		}
	}

	class VerifyAccountContr extends VerifyAccount
	{
		private $email;
		private $vKey;
		public function __construct($email, $vKey)
		{
			$this->email = $email;
			$this->vKey = $vKey;
		}
		public function verifyUser()
		{
			$this->verify($this->email, $this->vKey);
		}
	}
	$verifyAccount = new VerifyAccountContr($email, $vKey);
	$verifyAccount->verifyUser();
} else {
	header("Location: ../index.php");
	exit();
}