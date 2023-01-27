@@include('php/components/_head.php',{ "title":"OxyProject | Sign Up" })
<?php
if (isset($_SESSION['userID'])) {
	header("Location: ../dashboard.php");
	exit();
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
					<input type="text" id="full-name" name="fullName" aria-describedby="fullnameHelp"
						placeholder="First and last name *">
				</div>
				<div class="form__group">
					<input type="text" name="username" aria-describedby="usernameHelp" placeholder="Username *">
				</div>
				<div class="form__group">
					<input type="text" name="email" aria-describedby="emailHelp" placeholder="Email *">
				</div>
				<div class="form__group">
					<input type="password" name="password" placeholder="Password *" autocomplete="off">
					<p class="form__group-suggest">Password must contain at least one number, one letter, one uppercase letter and
						one special character!</p>
				</div>
				<div class="form__group">
					<input type="password" name="confirmPassword" placeholder="Confirm password *">
				</div>
				<div class="form__checkbox">
					<input type="checkbox" name="checkbox" value="off">
					<label for="checkbox-signup">I agree to the <a href="terms.php">Terms of Service</a> and <a
							href="terms.php#privacy-policy">Privacy Policy</a></label>
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
</body>

</html>