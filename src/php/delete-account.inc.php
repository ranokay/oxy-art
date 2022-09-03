<?php

if (isset($_POST['delete-account'])) {
	session_start();
	$userID = $_SESSION['userID'];

	include "dbh.inc.php";

	class DeleteAccount extends Dbh
	{
		public function deleteAccount($userID)
		{
			$sql = "DELETE FROM `arts` WHERE `owner_id` = ?;
							DELETE FROM `users` WHERE `id` = ?;";
			$stmt = $this->connect()->prepare($sql);
			if (!$stmt->execute([$userID, $userID])) {
				$stmt = null;
				header("Location: ../home?error=stmtfailed");
				exit();
			}

			$stmt = null;
			session_unset();
			session_destroy();
			header("Location: ../home?success=accountdeleted");
			exit();
		}
	}

	$deleteAccount = new DeleteAccount();
	$deleteAccount->deleteAccount($userID);
} else {
	header("Location: ../home");
	exit();
}
