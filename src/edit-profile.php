@@include('php/components/_head.php',{ "title":"OxyProject | Edit Profile" })
<?php
if (!isset($_SESSION['userID'])) {
	header("Location: ../login");
	exit();
}
?>

<body>
	<div class="wrapper">
		@@include('php/components/_header.php',{})
		<main class="main__content main__edit_profile">
			<section class="profile">
				<h1>Edit profile</h1>
				<?php
				if (isset($_SESSION['error'])) {
					$errorMsg = $_SESSION['error'];
					unset($_SESSION['error']);
					echo "<p class='form__error'>{$errorMsg}</p>";
				}
				if (isset($_SESSION['success'])) {
					$successMsg = $_SESSION['success'];
					unset($_SESSION['success']);
					echo "<p class='form__success'>{$successMsg}</p>";
				}
				?>
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
						<a href="reset-password-request" class="btn btn__default">
							Change password
						</a>
						<button type="submit" name="save-changes" class="btn btn__default">
							Save changes
						</button>
					</div>
				</form>

				<form class="danger-zone" action="php/delete-account.inc.php" method="POST">
					<a href="dashboard" class="btn btn__default">Back to dash</a>
					<button type="submit" name="delete-account" class="btn btn__danger">Delete account</button>
				</form>
			</section>
		</main>
		@@include('php/components/_footer.php')
	</div>
	@@include('php/components/_to-top-btn.php',{})
</body>

</html>