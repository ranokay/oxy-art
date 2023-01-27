@@include('php/components/_head.php',{ "title":"OxyProject | Login" })
<?php
if (isset($_SESSION['userID'])) {
	header("Location: ../dashboard.php");
	exit();
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
					<input type="text" name="username" placeholder="Username or Email">
				</div>
				<div class="form__group">
					<input type="password" name="password" placeholder="Password">
				</div>
				<div class="form__buttons">
					<button type="submit" class="btn btn__gradient" name="submit">Log In</button>
					<a class="forgot-password" href="reset-password-request.php">Forgot Password?</a>
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
</body>

</html>