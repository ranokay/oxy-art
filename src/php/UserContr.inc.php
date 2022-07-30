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

	// protected function userLevel($userId)
	// {
	// 	$sql = "SELECT `user_level` FROM user_level WHERE `user_id` = ?;";
	// 	$stmt = $this->connect()->prepare($sql);

	// 	if (!$stmt->execute([$userId])) {
	// 		$stmt = null;
	// 		header("Location: home?error=stmtfailed");
	// 		exit();
	// 	}
	// 	if ($stmt->rowCount() == 0) {
	// 		return false;
	// 	} else {
	// 		$userLevel = $stmt->fetchAll(PDO::FETCH_ASSOC);
	// 		return $userLevel;
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
	public $about;
	private $subscribed;
	public $userItems;
	public $userLevel;

	public function __construct($userId)
	{
		$user = $this->getUser($userId);
		$this->fullName = $user[0]['full_name'];
		$this->displayName = $user[0]['display_name'];
		$this->username = $user[0]['username'];
		$this->email = $user[0]['email'];
		$this->verified = $user[0]['verified'];
		$this->profileImg = $user[0]['profile_img'];
		$this->about = $user[0]['about'];
		$this->subscribed = $user[0]['subscribed'];

		// if ($this->userItems($userId)) {
		// 	$userItems = $this->userItems($userId);
		// 	$this->userItems = $userItems[0]['total_items'];
		// }
		// if ($this->userLevel($userId)) {
		// 	$userLevel = $this->userLevel($userId);
		// 	$this->userLevel = $userLevel[0]['user_level'];
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
	public function getAbout()
	{
		return $this->about;
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
	public function getUserLevel()
	{
		if (!$this->userLevel == false) {
			return $this->userLevel;
		} else {
			return "Bronze";
		}
	}
}
