<?php
session_start();

if (isset($_POST['delete-art'])) {
	$artId = $_GET['artId'];

	include "dbh.inc.php";

	class DeleteArt extends Dbh
	{
		public function deleteArt($artId)
		{
			$sql = "DELETE FROM `arts` WHERE `id` = ?;";
			$stmt = $this->connect()->prepare($sql);
			if (!$stmt->execute([$artId])) {
				$stmt = null;
				$_SESSION['error'] = "Failed to delete art. Please try again.";
				header("Location: ../art?id=$artId");
				exit();
			}

			$stmt = null;
			$_SESSION['success'] = "Art deleted successfully!";
			header("Location: ../dashboard");
			exit();
		}
	}

	$deleteArt = new DeleteArt();
	$deleteArt->deleteArt($artId);
} else {
	header("Location: ../home");
	exit();
}
