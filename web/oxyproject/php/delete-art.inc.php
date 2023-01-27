<?php
session_start();

if (isset($_POST['delete-art'])) {
	$artId = $_GET['artId'];

	include "dbh.inc.php";

	class DeleteArt extends Dbh
	{
		public function deleteArt($artId)
		{
			// Delete art from collection folder
			$sql = "SELECT `art_dir` FROM `arts` WHERE `id` = ?;";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$artId]);
			$artDir = $stmt->fetch();
			$stmt = null;
			if (file_exists($artDir['art_dir'])) {
				unlink($artDir['art_dir']);
			}

			$sql = "DELETE FROM `arts` WHERE `id` = ?;
							DELETE FROM `likes` WHERE `art_id` = ?;";
			$stmt = $this->connect()->prepare($sql);
			if (!$stmt->execute([$artId, $artId])) {
				$stmt = null;
				$_SESSION['error'] = "Failed to delete art. Please try again.";
				header("Location: ../art.php?id=$artId");
				exit();
			}

			$stmt = null;
			$_SESSION['success'] = "Art deleted successfully!";
			header("Location: ../dashboard.php");
			exit();
		}
	}

	$deleteArt = new DeleteArt();
	$deleteArt->deleteArt($artId);
} else {
	header("Location: ../index.php");
	exit();
}