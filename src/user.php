@@include('php/components/_head.php',{ "title":"OxyProject | User" })

<body>
	<div class="wrapper">
		@@include('php/components/_header.php',{})
		<main class="main__content main__public">
			<section class="public__profile">
				<div class="profile__image">
					<?php
					if ($user->getAvatar() == "") {
						echo '<img class="user-pic" src="assets/icons/user.svg" alt="Profile Image">';
					} else {
						echo '<img class="user-pic" src="' . $user->getAvatar() . '" alt="Profile Image">';
					}
					if ($user->getVerified() == 1) {
						echo '<img class="profile-verified" src="assets/icons/verified.svg" alt="Verified">';
					}
					?>
				</div>
				<div class="profile__content">
					<h2 class="profile__content-displayname">
						<?php echo $user->getFullName(); ?>
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
			</section>
		</main>
		@@include('php/components/_footer.php')
	</div>
	@@include('php/components/_to-top-btn.php',{})
</body>

</html>