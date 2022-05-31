	@@include('php/components/_head.php',{ "title":"OxyProject | Dashboard" })
	<?php
	if (isset($_SESSION['userId'])) {
	?>

		<body>
			<div class="wrapper">
				@@include('php/components/_header.php',{})
				<main class="main__content">
					<div class="dashboard">
						<h1 class="dashboard__title">Dashboard</h1>
						<form class="form form__reset" action="reset-password.php" method="POST">
							<div class="form__group-reset">
								<button type="submit" name="reset-request-submit" class="btn btn__default">Change password</button>
							</div>
						</form>
					</div>
				</main>
				@@include('php/components/_footer.php')
			</div>
			@@include('php/components/_to-top-btn.php',{})
			@@include('php/components/_scripts.php',{})
		</body>
	<?php
	} else {
		header("Location: index.php");
	}
	?>

	</html>