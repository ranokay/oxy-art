@@include('php/components/_head.php',{ "title":"OxyProject | Reset Password" })

<body>
	<div class="wrapper">
		@@include('php/components/_header.php',{})
		<main class="main__content main__reset">
			<form class="form form__reset" action="php/reset-request.inc.php" method="POST">
				<label for="form">Reset your password</label>
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
				<p style="color:hsl(215, 20%, 65%);">An email will be send to you with instructions on how to reset your password.</p>
				<div class="form__group-reset">
					<input type="text" name="email" placeholder="Enter your email address">
					<button type="submit" name="reset-request-submit" class="btn btn__default">Reset password</button>
				</div>
			</form>
		</main>
		@@include('php/components/_footer.php')
	</div>
	@@include('php/components/_to-top-btn.php',{})
</body>

</html>