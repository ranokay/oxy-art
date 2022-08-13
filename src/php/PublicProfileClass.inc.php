<?php

class PuclicProfile extends Dbh
{
	public function getUserPublic()
	{
		$sql = "SELECT * FROM `users` WHERE `public` = 1;";
	}
}
