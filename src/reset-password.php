@@include('php/components/_head.php',{ "title":"OxyProject | Reset Password" })

<body>
	<div class="wrapper">
		@@include('php/components/_header.php',{})
		<main class="main__content main__reset">
			<form class="form form__reset" action="php/reset-request.inc.php" method="POST">
				<label for="form">Reset your password</label>
				<span class="form__line"></span>
				<?php
				if (isset($_GET['reset'])) {
					if ($_GET['reset'] == 'success') {
						echo '<p class="form__success">Check your email for a reset link!</p>';
					}
				}
				if (isset($_GET['error'])) {
					if ($_GET['error'] == 'stmtfailed') {
						echo '<p class="form__error">Something went wrong!</p>';
					}
					if ($_GET['error'] == 'usernotfound') {
						echo '<p class="form__error">User with that email not found!</p>';
					}
					if ($_GET['error'] == 'emptyfields') {
						echo '<p class="form__error">Please fill in all fields!</p>';
					}
					if ($_GET['error'] == 'invalidtoken') {
						echo '<p class="form__error">Invalid link! Please try again.</p>';
					}
				}
				?>
				<p>An email will be send to you with instructions on how to reset your password.</p>
				<div class="form__group-reset">
					<input type="text" name="email" placeholder="Enter your email address">
					<button type="submit" name="reset-request-submit" class="btn btn__default">Reset password</button>
				</div>
			</form>
		</main>
		@@include('php/components/_footer.php')
	</div>
	@@include('php/components/_to-top-btn.php',{})
	@@include('php/components/_scripts.php',{})
</body>

</html>