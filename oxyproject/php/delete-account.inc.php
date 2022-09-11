<?php
session_start();

if (isset($_POST['delete-account'])) {
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
				$_SESSION['error'] = "Failed to delete account! Please try again later.";
				header("Location: ../dashboard");
				exit();
			}

			$stmt = null;
			session_unset();
			session_destroy();
			session_start();
			$_SESSION['success'] = "Account deleted successfully!";
			header("Location: ../login");
			exit();
		}
	}

	$deleteAccount = new DeleteAccount();
	$deleteAccount->deleteAccount($userID);
} else {
	header("Location: ../home");
	exit();
}
