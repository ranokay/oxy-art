<?php
class User extends Dbh
{
	protected function getUser($userId)
	{
		$sql = "SELECT * FROM `users` WHERE `id` = ?;";
		$stmt = $this->connect()->prepare($sql);

		if (!$stmt->execute([$userId])) {
			$stmt = null;
			header("Location: home?error=stmtfailed");
			exit();
		}
		if ($stmt->rowCount() == 0) {
			$stmt = null;
			header("Location: home?error=usernotfound");
			exit();
		}
		$user = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $user;
	}

	// protected function userItems($userId)
	// {
	// 	$sql = "SELECT `total_items` FROM user_collection WHERE `user_id` = ?;";
	// 	$stmt = $this->connect()->prepare($sql);

	// 	if (!$stmt->execute([$userId])) {
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
	public $displayName;
	private $username;
	private $email;
	private $verified;
	public $profileImg;
	private $subscribed;
	public $userItems;

	public function __construct($userId)
	{
		$user = $this->getUser($userId);
		$this->fullName = $user[0]['full_name'];
		$this->displayName = $user[0]['display_name'];
		$this->username = $user[0]['username'];
		$this->email = $user[0]['email'];
		$this->verified = $user[0]['verified'];
		$this->profileImg = $user[0]['avatar'];
		$this->subscribed = $user[0]['subscribed'];

		// if ($this->userItems($userId)) {
		// 	$userItems = $this->userItems($userId);
		// 	$this->userItems = $userItems[0]['total_items'];
		// }
	}
	public function getFullName()
	{
		return $this->fullName;
	}
	public function getDisplayName()
	{
		return $this->displayName;
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
	public function getProfileImg()
	{
		return $this->profileImg;
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
