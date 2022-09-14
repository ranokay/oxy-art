<?php
class User extends Dbh
{
	protected function getUser($userID)
	{
		$sql = "SELECT * FROM `users` WHERE `id` = ?;";
		$stmt = $this->connect()->prepare($sql);

		if (!$stmt->execute([$userID])) {
			$stmt = null;
			header("Location: ../home");
			exit();
		}
		if ($stmt->rowCount() === 0) {
			$stmt = null;
			session_unset();
			session_destroy();
			header("Location: ../home");
			exit();
		}
		$user = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $user;
	}

	protected function countUserArts($userID)
	{
		$sql = "SELECT COUNT(*) FROM `arts` WHERE `owner_id` = ?;";
		$stmt = $this->connect()->prepare($sql);

		if (!$stmt->execute([$userID])) {
			$stmt = null;
			header("Location: ../home");
			exit();
		}
		$count = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $count[0]['COUNT(*)'];
	}

	protected function countUserLikes($userID)
	{
		$sql = "SELECT COUNT(*) FROM `likes` WHERE `user_id` = ?;";
		$stmt = $this->connect()->prepare($sql);

		if (!$stmt->execute([$userID])) {
			$stmt = null;
			header("Location: ../home");
			exit();
		}
		$count = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $count[0]['COUNT(*)'];
	}
}
class UserContr extends User
{
	public function __construct($userID)
	{
		$user = $this->getUser($userID);
		$this->fullName = $user[0]['full_name'];
		$this->username = $user[0]['username'];
		$this->email = $user[0]['email'];
		$this->verified = $user[0]['verified'];
		$this->avatar = $user[0]['avatar'];
		$this->subscribed = $user[0]['subscribed'];
		$this->artsCount = $this->countUserArts($userID);
		$this->likesCount = $this->countUserLikes($userID);
	}
	public function getFullName()
	{
		return $this->fullName;
	}
	public function getUsername()
	{
		return $this->username;
	}
	public function getEmail()
	{
		return $this->email;
	}
	public function getVerified()
	{
		return $this->verified;
	}
	public function getAvatar()
	{
		return $this->avatar;
	}
	public function getSubscribed()
	{
		return $this->subscribed;
	}
	public function getArtsCount()
	{
		return $this->artsCount;
	}
	public function getLikesCount()
	{
		return $this->likesCount;
	}
}
