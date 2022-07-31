@@include('php/components/_head.php',{ "title":"OxyProject | Edit Profile" })
<?php
if (!isset($_SESSION['userId'])) {
	header("Location: login");
	exit();
}
?>

<body>
	<div class="wrapper">
		@@include('php/components/_header.php',{})
		<main class="main__content main__edit_profile">
			<section class="profile">
				<h1>Edit profile</h1>
				<form action="edit-profile" class="form-edit">
					<div class="change-avatar">
						<?php
						if ($user->getProfileImg() == "") {
							echo '<img class="user-pic" src="assets/icons/user.svg" alt="Profile Image">';
						} else {
							echo '<img class="user-pic" src="' . $user->getProfileImg() . '" alt="Profile Image">';
						}
						?>
						<input type="file" id="actual-btn" name="profile-img" hidden />
						<label class="choose-file" for="actual-btn">Choose File</label>
					</div>
					<div class="form__group">
						<label for="full-name">Full name</label>
						<input type="text" id="full-name" name="fullName" aria-describedby="fullnameHelp" placeholder="first and last name">
					</div>
					<div class="form__group">
						<label for="display-name">Display name</label>
						<input type="text" id="display-name" name="displayName" aria-describedby="displaynameHelp" placeholder="display name">
					</div>
					<div class="form__group">
						<label for="username">Username</label>
						<input type="text" name="username" aria-describedby="usernameHelp" placeholder="username">
					</div>
					<div class="form__group">
						<label for="email">Email</label>
						<input type="text" name="email" aria-describedby="emailHelp" placeholder="email">
					</div>
					<div class="form__group-btn">
						<a href="reset-password" class="btn btn__default">Change password
						</a>
						<button type="submit" name="save-changes" class="btn btn__default">Save changes</button>
					</div>
				</form>

			</section>
		</main>
		@@include('php/components/_footer.php')
	</div>
	@@include('php/components/_to-top-btn.php',{})
</body>

</html>