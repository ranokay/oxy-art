@@include('php/components/_head.php',{ "title":"OxyProject | Reset Password" })

<body>
	<div class="wrapper">
		@@include('php/components/_header.php',{})
		<main class="main__content main__reset">
			<?php
			$selector = $_GET['selector'];
			$validator = $_GET['validator'];

			if (empty($selector) || empty($validator)) {
				echo '<p class="form__error">Could not validate your request! Please try again.</p>';
			} else {
				if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
			?>
					<form class="form form__reset" action="php/reset-password.inc.php" method="POST">
						<input type="hidden" name="selector" value="<?php echo $selector; ?>">
						<input type="hidden" name="validator" value="<?php echo $validator; ?>">
						<label for="form">Enter a new password for your account.</label>
						<span class="form__line"></span>
						<?php
						if (isset($_GET['error'])) {
							if ($_GET['error'] == 'emptyfields') {
								echo '<p class="form__error">Fill in all fields!</p>';
							} else if ($_GET['error'] == 'invalidpassword') {
								echo '<p class="form__error">Your password must be at least 8 characters long!</p>';
							} else if ($_GET['error'] == 'passwordcheck') {
								echo '<p class="form__error">Your passwords do not match!</p>';
							}
						}
						?>
						<div class="form__group">
							<label for="password"> New password *</label>
							<input type="password" name="password" placeholder="enter new password">
						</div>
						<div class="form__group">
							<label for="password_confirm">Confirm password *</label>
							<input type="password" name="confirmPassword" placeholder="confirm password">
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
	@@include('php/components/_scripts.php',{})
</body>

</html>