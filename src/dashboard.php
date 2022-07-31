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
							echo '<img class="user-pic" src="assets/icons/user.svg" alt="Profile Image">';
						} else {
							echo '<img class="user-pic" src="' . $user->getProfileImg() . '" alt="Profile Image">';
						}
						if ($user->getVerified() == 1) {
							echo '<img class="profile-verified" src="assets/icons/verified.svg" alt="Verified">';
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
					</div>
					<div class="profile__stats">
						<div class="profile__stats-item">
							<img src="assets/icons/likes.svg" alt="Likes">
							<h4>
								324 Likes
							</h4>
						</div>
						<div class="profile__stats-item">
							<img src="assets/icons/items.svg" alt="Items">
							<h4>
								<?php
								echo $user->getUserItems() . ' Items';
								?>
							</h4>
						</div>
					</div>
					<?php
					if ($user->getVerified() == 0) {
						echo '<p style="color: hsl(348, 76%, 62%);">Your account is not verified. Please check your email for the verification link.</p>';
					}
					?>
					<div class="section__buttons">
						<form class="form form__reset" action="upload-art" method="POST">
							<div class="form__group-reset">
								<button type="submit" name="upload-art" class="btn btn__gradient">Upload Art</button>
							</div>
						</form>
						<a href="edit-profile">
							<button type="submit" name="edit-profile" class="btn btn__default">
								<img class="edit-profile-icon" src="assets/icons/edit.svg" alt="Edit">
								Edit profile
							</button>
						</a>
					</div>
				</section>
			</main>
			@@include('php/components/_footer.php')
		</div>
		@@include('php/components/_to-top-btn.php',{})
	</body>

	</html>