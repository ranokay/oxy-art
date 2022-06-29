	@@include('php/components/_head.php',{ "title":"OxyProject | Dashboard" })
	<?php
	if (!isset($_SESSION['userId'])) {
		header("Location: login");
		exit();
	}
	?>

	<body>
		<div class="wrapper">
			@@include('php/components/_header.php',{})
			<main class="main__content main__dashboard">
				<section class="profile">
					<div class="profile__image">
						<?php
						if ($user->getProfileImg() == "") {
							echo '<img class="user-pic" src="img/icons/user.svg" alt="Profile Image">';
						} else {
							echo '<img class="user-pic" src="' . $user->getProfileImg() . '" alt="Profile Image">';
						}
						if ($user->getVerified() == 1) {
							echo '<img class="profile-verified" src="img/icons/verified.svg" alt="Verified">';
						}
						?>
					</div>
					<div class="profile__content">
						<h2 class="profile__content-displayname">
							<?php
							if ($user->getDisplayName() == "") {
								echo $user->getFullName();
							} else {
								echo $user->getDisplayName();
							}
							?>
						</h2>
						<p class="profile__content-about">
							<?php
							echo $user->getAbout();
							?>
						</p>
					</div>
					<div class="profile__stats">
						<div class="profile__stats-item">
							<img src="img/icons/level.svg" alt="User Level">
							<h4>
								<?php
								echo 'Rank ' . $user->getUserLevel();
								?>
							</h4>
						</div>
						<div class="profile__stats-item">
							<img src="img/icons/likes.svg" alt="Likes">
							<h4>
								324 Likes
							</h4>
						</div>
						<div class="profile__stats-item">
							<img src="img/icons/items.svg" alt="Items">
							<h4>
								<?php
								echo $user->getUserItems() . ' Items';
								?>
							</h4>
						</div>
					</div>
				</section>

				<section class="section__buttons">
					<form class="form form__reset" action="reset-password" method="POST">
						<div class="form__group-reset">
							<button type="submit" name="reset-request-submit" class="btn btn__default">Change password</button>
						</div>
					</form>
					<form class="form form__reset" action="create-art" method="POST">
						<div class="form__group-reset">
							<button type="submit" name="upload-art" class="btn btn__gradient">Create Art</button>
						</div>
					</form>
				</section>

		</div>
		</main>
		@@include('php/components/_footer.php')
		</div>
		@@include('php/components/_to-top-btn.php',{})
		@@include('php/components/_scripts.php',{})
	</body>

	</html>