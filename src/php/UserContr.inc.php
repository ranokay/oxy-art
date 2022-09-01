<?php
class User extends Dbh
{
	protected function getUser($userID)
	{
		$sql = "SELECT * FROM `users` WHERE `id` = ?;";
		$stmt = $this->connect()->prepare($sql);

		if (!$stmt->execute([$userID])) {
			$stmt = null;
			header("Location: home?error=stmtfailed");
			exit();
		}
		if ($stmt->rowCount() == 0) {
			$stmt = null;
			session_unset();
			session_destroy();
			header("Location: home?error=usernotfound");
			exit();
		}
		$user = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $user;
	}

	// protected function userItems($userID)
	// {
	// 	$sql = "SELECT `total_items` FROM user_collection WHERE `user_id` = ?;";
	// 	$stmt = $this->connect()->prepare($sql);

	// 	if (!$stmt->execute([$userID])) {
	// 		$stmt = null;
	// 		header("Location: home?error=stmtfailed");
	// 		exit();
	// 	}
	// 	if ($stmt->rowCount() == 0) {
	// 		return false;
	// 	} else {
	// 		$userItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
	// 		return $userItems;
	// 	}
	// }
}
class UserContr extends User
{
	private $fullName;
	private $username;
	private $email;
	private $verified;
	public $avatar;
	private $subscribed;
	public $userItems;

	public function __construct($userID)
	{
		$user = $this->getUser($userID);
		$this->fullName = $user[0]['full_name'];
		$this->username = $user[0]['username'];
		$this->email = $user[0]['email'];
		$this->verified = $user[0]['verified'];
		$this->avatar = $user[0]['avatar'];
		$this->subscribed = $user[0]['subscribed'];

		// if ($this->userItems($userID)) {
		// 	$userItems = $this->userItems($userID);
		// 	$this->userItems = $userItems[0]['total_items'];
		// }
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
	public function getUserItems()
	{
		if (!$this->userItems == false) {
			return $this->userItems;
		} else {
			return "0";
		}
	}
}
