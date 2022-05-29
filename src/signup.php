@@include('php/components/_head.php',{ "title":"OxyProject | Sign Up" })

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
					} else if ($_GET['error'] == 'invalidpassword') {
						echo '<p class="form__error">Password needs to be at least 8 characters long!</p>';
					} else if ($_GET['error'] == 'passwordcheck') {
						echo '<p class="form__error">Passwords do not match!</p>';
					} else if ($_GET['error'] == 'checkbox') {
						echo '<p class="form__error">You must agree to the terms and conditions!</p>';
					} else if ($_GET['error'] == 'userexists') {
						echo '<p class="form__error">Username or email already taken!</p>';
					} else if ($_GET['error'] == 'stmtfailed') {
						echo '<p class="form__error">Server error!</p>';
					}
				}
				?>
				<div class="form__group">
					<label for="full-name">Full name *</label>
					<input type="text" id="full-name" name="fullName" aria-describedby="fullnameHelp" placeholder="first and last name">
				</div>
				<div class="form__group">
					<label for="username">Username *</label>
					<input type="text" name="username" aria-describedby="usernameHelp" placeholder="username">
				</div>
				<div class="form__group">
					<label for="email">Email *</label>
					<input type="text" name="email" aria-describedby="emailHelp" placeholder="email">
				</div>
				<div class="form__group">
					<label for="password">Password *</label>
					<input type="password" name="password" placeholder="password">
				</div>
				<div class="form__group">
					<label for="password_confirm">Confirm password *</label>
					<input type="password" name="confirmPassword" placeholder="password">
				</div>
				<div class="form__checkbox">
					<input type="checkbox" name="checkbox" value="checkbox">
					<label for="checkbox-signup">I agree to the <a href="terms.php">Terms of Service</a> and <a href="terms.php/#privacy">Privacy Policy</a></label>
				</div>
				<div class="form__buttons">
					<button type="submit" class="btn btn__gradient" name="submit">Sign Up</button>
					<a href="login.php" class="have-account">
						Already have an account?
					</a>
				</div>
			</form>
		</main>
		@@include('php/components/_footer.php')
	</div>
	@@include('php/components/_to-top-btn.php',{})
	@@include('php/components/_scripts.php',{})
</body>

</html>