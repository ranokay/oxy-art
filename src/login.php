@@include('php/components/_head.php',{ "title":"OxyProject | Login" })

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
					} else if ($_GET['error'] == 'stmtfailed') {
						echo '<p class="form__error">Server error!</p>';
					}
				}
				if (isset($_GET['signup'])) {
					if ($_GET['signup'] == 'success') {
						echo '<p class="form__success">You have successfully signed up!</p>';
					}
				}
				if (isset($_GET['reset'])) {
					if ($_GET['reset'] == 'passwordupdated') {
						echo '<p class="form__success">Your password has been reset!</p>';
					}
				}
				?>
				<div class="form__group">
					<label for="username">Username or Email</label>
					<input type="text" name="username" placeholder="username or email">
				</div>
				<div class="form__group">
					<label for="password">Password</label>
					<input type="password" name="password" placeholder="password">
				</div>
				<div class="form__buttons">
					<button type="submit" class="btn btn__gradient" name="submit">Log In</button>
					<a class="forgot-password" href="reset-password.php">Forgot Password?</a>
				</div>
				<div class="form__delimiter">
					<span class="line"></span>
					<span class="text">or</span>
					<span class="line"></span>
				</div>
				<a href="signup.php" class="btn btn__default create-account">
					Create an account
				</a>
			</form>
		</main>
		@@include('php/components/_footer.php')
	</div>
	@@include('php/components/_to-top-btn.php',{})
	@@include('php/components/_scripts.php',{})
</body>

</html>