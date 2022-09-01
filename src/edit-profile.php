@@include('php/components/_head.php',{ "title":"OxyProject | Edit Profile" })
<?php
if (!isset($_SESSION['userID'])) {
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
				<form action="php/update-user.inc.php" class="form-edit" method="POST">
					<div class="change-avatar">
						<?php
						if ($user->getAvatar() == "") {
							echo '<img class="user-pic" src="assets/icons/user.svg" alt="Profile Image">';
						} else {
							echo '<img class="user-pic" src="' . $user->getAvatar() . '" alt="Profile Image">';
						}
						?>
						<input type="file" id="actual-btn" name="profile-img" hidden />
						<label class="choose-file" for="actual-btn">Choose File</label>
					</div>
					<?php
					if (isset($_GET['error'])) {
						if ($_GET['error'] == "emptyeditfields") {
							echo '<p class="form__error">Fill at least one field.</p>';
						} else if ($_GET['error'] == "invalidfullname") {
							echo '<p class="form__error">Invalid full name!</p>';
						} else if ($_GET['error'] == "invalidusername") {
							echo '<p class="form__error">Choose a proper username!</p>';
						} else if ($_GET['error'] == "invalidemail") {
							echo '<p class="form__error">Choose a proper email!</p>';
						} else if ($_GET['error'] == "usernametaken") {
							echo '<p class="form__error">Username is already taken!</p>';
						} else if ($_GET['error'] == "emailtaken") {
							echo '<p class="form__error">Email is already taken!</p>';
						} else if ($_GET['error'] == "stmtfailed") {
							echo '<p class="form__error">Something went wrong, try again!</p>';
						} else if ($_GET['error'] == "none") {
							echo '<p class="form__success">Your profile has been updated!</p>';
						} else if ($_GET['error'] == "verify") {
							echo '<p class="form__success">Your profile has been updated! <br> Please verify your new email!</p>';
						}
					}
					?>
					<div class="form__group">
						<label for="full-name">
							Full name
							<?php
							echo '<p class="form__subtitle">' . $user->getFullName() . '</p>';
							?>
						</label>
						<input type="text" name="fullName" aria-describedby="fullnameHelp" placeholder="first and last name">
					</div>
					<div class="form__group">
						<label for="username">
							Username
							<?php
							echo '<p class="form__subtitle">' . $user->getUsername() . '</p>';
							?>
						</label>
						<input type="text" name="username" aria-describedby="usernameHelp" placeholder="new username">
					</div>
					<div class="form__group">
						<label for="email">
							Email
							<?php
							echo '<p class="form__subtitle">' . $user->getEmail() . '</p>';
							?>
						</label>
						<input type="text" name="email" aria-describedby="emailHelp" placeholder="new email">
					</div>
					<div class="form__group-btn">
						<a href="reset-password" class="btn btn__default">
							Change password
						</a>
						<button type="submit" name="save-changes" class="btn btn__default">
							Save changes
						</button>
					</div>
				</form>

			</section>
		</main>
		@@include('php/components/_footer.php')
	</div>
	@@include('php/components/_to-top-btn.php',{})
</body>

</html>