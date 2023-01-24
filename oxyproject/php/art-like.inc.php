<?php
session_start();

if (isset($_POST['like-btn'])) {
	$artId = $_POST['art_id'];
	$userId = $_SESSION['userID'];

	if (!isset($_SESSION['userID'])) {
		$_SESSION['error'] = "You must be logged in to like an art!";
		header("Location: ../art.php?id={$artId}");
		exit();
	}

	include 'dbh.inc.php';

	class LikeArt extends Dbh
	{
		public function likeArt($artId, $userId)
		{
			$sql = "SELECT * FROM `likes` WHERE `art_id` = ? AND `user_id` = ?;";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$artId, $userId]);
			$result = $stmt->fetchAll();
			$stmt = null;

			if (count($result) > 0) {
				$sql = "DELETE FROM `likes` WHERE `art_id` = ? AND `user_id` = ?;";
				$stmt = $this->connect()->prepare($sql);
				if (!$stmt->execute([$artId, $userId])) {
					$stmt = null;
					$_SESSION['error'] = "Failed to unlike art! Try again later.";
					header("Location: ../art.php?id=$artId");
					exit();
				}
				$stmt = null;
				header("Location: ../art.php?id=$artId");
				exit();
			} else {
				$sql = "INSERT INTO `likes` (`art_id`, `user_id`) VALUES (?, ?);";
				$stmt = $this->connect()->prepare($sql);
				if (!$stmt->execute([$artId, $userId])) {
					$stmt = null;
					$_SESSION['error'] = "Failed to like art! Try again later.";
					header("Location: ../art.php?id=$artId");
					exit();
				}
				$stmt = null;
				header("Location: ../art.php?id=$artId");
				exit();
			}
		}
	}

	$likeArt = new LikeArt();
	$likeArt->likeArt($artId, $userId);
} else {
	echo "<h1>404. Page not found!</h1>";
	exit();
}