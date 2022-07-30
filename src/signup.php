@@include('php/components/_head.php',{ "title":"OxyProject | Sign Up" })
<?php
if (isset($_SESSION['userId'])) {
	header("Location: dashboard");
}
?>

<body>
	<div class="wrapper">
		@@include('php/components/_header.php',{})
		<main class="main__content main__signup">
			<form class="form form__signup" action="php/signup.inc.php" method="POST">
				<label for="form">Sign Up</label>
				<span class="form__line"></span>
				<?php
				if (isset($_GET['error'])) {
					if ($_GET['error'] == 'emptyfields') {
						echo '<p class="form__error">Fill in all fields!</p>';
					} else if ($_GET['error'] == 'invalidfullname') {
						echo '<p class="form__error">Please enter a valid name.</p>';
					} else if ($_GET['error'] == 'invalidmail') {
						echo '<p class="form__error">Invalid email!</p>';
					} else if ($_GET['error'] == 'invalidusername') {
						echo '<p class="form__error">Username can only contain digits and letters!</p>';
					} else if ($_GET['error'] == 'passwordlength') {
						echo '<p class="form__error">Password must be between 8 and 25 characters long!</p>';
					} else if ($_GET['error'] == 'invalidpassword') {
						echo '<p class="form__error">Password must contain at least 1 number, 1 letter, 1 uppercase letter and 1 special character!</p>';
					} else if ($_GET['error'] == 'passwordcheck') {
						echo '<p class="form__error">Passwords do not match!</p>';
					} else if ($_GET['error'] == 'checkbox') {
						echo '<p class="form__error">You must agree to the terms and conditions!</p>';
					} else if ($_GET['error'] == 'usernameexists') {
						echo '<p class="form__error">Username already taken!</p>';
					} else if ($_GET['error'] == 'emailexists') {
						echo '<p class="form__error">User with this email already exists!</p>';
					} else if ($_GET['error'] == 'stmtfailed') {
						echo '<p class="form__error">Server error!</p>';
					}
				}
				?>
				<div class="form__group">
					<input type="text" id="full-name" name="fullName" aria-describedby="fullnameHelp" placeholder="First and last name *">
				</div>
				<div class="form__group">
					<input type="text" name="username" aria-describedby="usernameHelp" placeholder="Username *">
				</div>
				<div class="form__group">
					<input type="text" name="email" aria-describedby="emailHelp" placeholder="Email *">
				</div>
				<div class="form__group">
					<input type="password" name="password" placeholder="Password *">
					<p class="form__group-suggest">Password must contain at least one number, one letter, one uppercase letter and one special character!</p>
				</div>
				<div class="form__group">
					<input type="password" name="confirmPassword" placeholder="Confirm password *">
				</div>
				<div class="form__checkbox">
					<input type="checkbox" name="checkbox" value="checkbox">
					<label for="checkbox-signup">I agree to the <a href="terms">Terms of Service</a> and <a href="terms/#privacy">Privacy Policy</a></label>
				</div>
				<div class="form__buttons">
					<button type="submit" class="btn btn__gradient" name="submit">Sign Up</button>
					<a href="login" class="have-account">
						Already have an account?
					</a>
				</div>
			</form>
		</main>
		@@include('php/components/_footer.php')
	</div>
	@@include('php/components/_to-top-btn.php',{})
</body>

</html>