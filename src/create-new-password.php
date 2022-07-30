@@include('php/components/_head.php',{ "title":"OxyProject | Reset Password" })

<body>
	<div class="wrapper">
		@@include('php/components/_header.php',{})
		<main class="main__content main__reset">
			<?php
			if (empty($_GET['selector']) || empty($_GET['validator'])) {
				echo '<p class="form__error">Could not validate your request! Please try again.</p>';
			} else {
				if (ctype_xdigit($_GET['selector']) !== false && ctype_xdigit($_GET['validator']) !== false) {
			?>
					<form class="form form__reset" action="php/reset-password.inc.php" method="POST">
						<input type="hidden" name="selector" value="<?php echo $_GET['selector']; ?>">
						<input type="hidden" name="validator" value="<?php echo $_GET['validator']; ?>">
						<label for="form">Enter a new password for your account.</label>
						<span class="form__line"></span>
						<?php
						if (isset($_GET['error'])) {
							if ($_GET['error'] == 'emptyfields') {
								echo '<p class="form__error">Fill in all fields!</p>';
							} else if ($_GET['error'] == 'passwordlength') {
								echo '<p class="form__error">Password must be between 8 and 25 characters long!</p>';
							} else if ($_GET['error'] == 'invalidpassword') {
								echo '<p class="form__error">Password must contain at least 1 number, 1 letter, 1 uppercase letter and 1 special character!</p>';
							} else if ($_GET['error'] == 'passwordmatch') {
								echo '<p class="form__error">Your passwords do not match!</p>';
							}
						}
						?>
						<div class="form__group">
							<input type="password" name="password" placeholder="New password *">
							<p class="form__group-suggest">Password must contain at least one number, one letter, one uppercase letter and one special character!</p>
						</div>
						<div class="form__group">
							<input type="password" name="confirmPassword" placeholder="Confirm password *">
						</div>
						<button type="submit" class="btn btn__default" name="reset-password-submit">Reset password</button>
					</form>
			<?php
				} else {
					echo '<p class="form__error">Could not validate your request! Please try again.</p>';
				}
			}
			?>
		</main>
		@@include('php/components/_footer.php')
	</div>
	@@include('php/components/_to-top-btn.php',{})
</body>

</html>