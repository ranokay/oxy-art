@@include('php/components/_head.php',{ "title":"OxyProject | Login" })
<?php
if (isset($_SESSION['userID'])) {
	header("Location: dashboard");
}
?>

<body>
	<div class="wrapper">
		@@include('php/components/_header.php',{})
		<main class="main__content main__login">
			<form class="form form__login" action="php/login.inc.php" method="POST">
				<label for="form">Login</label>
				<span class="form__line"></span>
				<?php
				if (isset($_GET['error'])) {
					if ($_GET['error'] == 'emptyfields') {
						echo '<p class="form__error">Fill in all fields!</p>';
					} else if ($_GET['error'] == 'usernotfound') {
						echo '<p class="form__error">Incorrect username or password!</p>';
					} else if ($_GET['error'] == 'invalidkey') {
						echo '<p class="form__error">Invalid verification link! Please try again.</p>';
					} else if ($_GET['error'] == 'alreadyverified') {
						echo '<p class="form__error">Your account has already been verified!</p>';
					} else if ($_GET['error'] == 'verified') {
						echo '<p class="form__success">Your account has been verified!</p>';
					} else if ($_GET['error'] == 'verify') {
						echo '<p class="form__success">Please verify your new email address!</p>';
					} else if ($_GET['error'] == 'stmtfailed') {
						echo '<p class="form__error">Server error!</p>';
					}
				}
				if (isset($_GET['signup'])) {
					if ($_GET['signup'] == 'success') {
						echo '<p class="form__success">You have successfully signed up! <br> Please check your email to verify your account.</p>';
					}
				}
				if (isset($_GET['reset'])) {
					if ($_GET['reset'] == 'passwordupdated') {
						echo '<p class="form__success">Your password has been reset!</p>';
					}
				}
				?>
				<div class="form__group">
					<input type="text" name="username" placeholder="Username or Email">
				</div>
				<div class="form__group">
					<input type="password" name="password" placeholder="Password">
				</div>
				<div class="form__buttons">
					<button type="submit" class="btn btn__gradient" name="submit">Log In</button>
					<a class="forgot-password" href="reset-password">Forgot Password?</a>
				</div>
				<div class="form__delimiter">
					<span class="line"></span>
					<span class="text">or</span>
					<span class="line"></span>
				</div>
				<a href="signup" class="btn btn__default create-account">
					Create an account
				</a>
			</form>
		</main>
		@@include('php/components/_footer.php')
	</div>
	@@include('php/components/_to-top-btn.php',{})
</body>

</html>