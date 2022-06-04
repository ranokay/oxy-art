	@@include('php/components/_head.php',{ "title":"OxyProject | Dashboard" })
	<?php
	if (isset($_SESSION['userId'])) {
		$userId = $_SESSION['userId'];
		include "php/dbh.inc.php";
		include 'php/auto-loader.inc.php';
		$user = new UserContr($userId);
	} else {
		header("Location: login");
		exit();
	}
	?>

	<body>
		<div class="wrapper">
			@@include('php/components/_header.php',{})
			<main class="main__content main__dashboard">
				<div class="dashboard">
					<h1 class="dashboard__title">Dashboard</h1>
					<div class="dashboard__content">
						<div class="dashboard__content-item">
							<div class="dashboard__content-item-img">
								<img src="img/icons/user.svg" alt="">
							</div>
							<div class="dashboard__content-item-info">
								<h2 class="dashboard__content-item-info-title">
									<?php
									echo $user->getFullName();
									?>
								</h2>
								<p class="dashboard__content-item-info-text">
									<?php
									echo $user->getDisplayName();
									?>
								</p>
							</div>
						</div>
						<div class="dashboard__content-item">
							<div class="dashboard__content-item-img">
								<img src="img/icons/email.svg" alt="">
							</div>
							<div class="dashboard__content-item-info">
								<h2 class="dashboard__content-item-info-title">
									<?php
									echo $user->getEmail();
									?>
								</h2>
								<p class="dashboard__content-item-info-text">
									<?php
									echo $user->getBalance();
									echo $user->getAbout();
									?>
								</p>
								<p>
									<?php
									echo $user->getVerified();
									?>
								</p>
								<p>
									<?php
									echo $user->getSubscribed();
									?>
								</p>
							</div>
						</div>
					</div>


				</div>

				<form class="form form__reset" action="reset-password" method="POST">
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

	</html>