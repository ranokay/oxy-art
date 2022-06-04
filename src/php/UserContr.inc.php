<?php

class User extends Dbh
{
	protected function getUser($userId)
	{
		$sql = "SELECT `full_name`, `display_name`,`username`, `email`,`verified`, `profile_img`, `about`, `balance`, `subscribed` FROM users WHERE `id` = ?;";
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
	private $balance;
	private $subscribed;

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
		$this->balance = $user[0]['balance'];
		$this->subscribed = $user[0]['subscribed'];
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
		if ($this->verified == 1) {
			return "Your account is verified";
		} else {
			return "Please verify your account";
		}
	}
	public function getProfileImg()
	{
		return $this->profileImg;
	}
	public function getAbout()
	{
		return $this->about;
	}
	public function getBalance()
	{
		return $this->balance . " $";
	}
	public function getSubscribed()
	{
		if ($this->subscribed == 1) {
			return "You are subscribed to our newsletter";
		} else {
			return "You are not subscribed";
		}
	}
}
