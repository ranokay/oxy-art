@@include('php/components/_head.php',{ "title":"OxyProject | Reset Password" })

<body>
	<div class="wrapper">
		@@include('php/components/_header.php',{})
		<main class="main__content main__reset">
			<?php
			if (empty($_GET['selector']) || empty($_GET['validator'])) {
				echo '<p class="form__error">Could not validate your request! Invalid or expired link.</p>';
				exit();
			}
			if (ctype_xdigit($_GET['selector']) !== false && ctype_xdigit($_GET['validator']) !== false) {
			?>
				<form class="form form__reset" action="php/reset-password.inc.php" method="POST">
					<input type="hidden" name="selector" value="<?php echo htmlspecialchars($_GET['selector']); ?>">
					<input type="hidden" name="validator" value="<?php echo htmlspecialchars($_GET['validator']); ?>">
					<label for="form">Enter a new password for your account.</label>
					<span class="form__line"></span>
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
			?>
		</main>
		@@include('php/components/_footer.php')
	</div>
	@@include('php/components/_to-top-btn.php',{})
</body>

</html>