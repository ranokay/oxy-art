@@include('php/components/_head.php',{ "title":"OxyProject | Dashboard" })

<body>
	<div class="wrapper">
		@@include('php/components/_header.php',{})
		<main class="main__content main__dashboard">
			<section class="profile">
				<div class="profile__image">
					<?php
					if (!isset($_SESSION['userID'])) {
						echo '<h2 class="profile__image-msg">You are not logged in!</h2>';
						return;
					}

					if ($user->getAvatar() == "") {
						echo '<img class="user-pic" src="assets/icons/user.svg" alt="Profile Image">';
					} else {
						echo '<img class="user-pic" src="' . $user->getAvatar() . '" alt="Profile Image">';
					}
					if ($user->getVerified() == 1) {
						echo '<img class="profile-verified" src="assets/icons/verified.svg" alt="Verified" title="Verified">';
					}
					?>
				</div>
				<div class="profile__content">
					<h2 class="profile__content-displayname">
						<?php echo $user->getFullName(); ?>
					</h2>
					<h3 class="profile__content-username">
						@
						<?php echo $user->getUsername(); ?>
					</h3>
				</div>
				<div class="profile__stats">
					<div class="profile__stats-item">
						<img src="assets/icons/likes.svg" alt="Likes">
						<h4>
							<?php
							if ($user->getLikesCount() === 1) {
								echo $user->getLikesCount() . " Like";
							} else {
								echo $user->getLikesCount() . " Likes";
							}
							?>
						</h4>
					</div>
					<div class="profile__stats-item">
						<img src="assets/icons/items.svg" alt="Items">
						<h4>
							<?php
							if ($user->getArtsCount() === 1) {
								echo $user->getArtsCount() . ' Art';
							} else {
								echo $user->getArtsCount() . ' Arts';
							}
							?>
						</h4>
					</div>
				</div>
				<?php
				if ($user->getVerified() === 0) {
					?>
					<form class="form-verification-msg" action="php/resend-verification.inc.php" method="POST">
						<input type="hidden" name="email" value="<?php echo $user->getEmail(); ?>">
						<p class="form__error-active">Your account is not verified. Please check your email for the verification link
							or <button class="resend-btn" type="submit" name="resend">click here</button> to resend the verification
							email.</p>
					</form>
					<?php
				}
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
				<div class="section__buttons">
					<a href="new-art.php" class="btn btn__gradient">
						<img class="btn-icon" src="assets/icons/upload.svg" alt="upload button">
						Upload Art
					</a>
					<a href="edit-profile.php" class="btn btn__default">
						<img class="btn-icon" src="assets/icons/edit.svg" alt="Edit">
						Edit profile
					</a>
				</div>
			</section>
			<div class="section__title">
				<h2>My Collection</h2>
				<span class="section__title-line"></span>
			</div>
			<section class="arts__container">
				<?php
				include "php/CollectionClass.inc.php";
				$artCollection = new Collection();
				if ($artCollection->getUserArts()) {
					foreach ($artCollection->getUserArts() as $art) {
						$artId = $art['id'];
						$artName = $art['name'];
						$artDir = $art['art_dir'];
						?>
						<a class="art-card" href="art.php?id=<?php echo $artId; ?>">
							<img class="card-image" src="<?php echo $artDir; ?>" alt="<?php echo $artName; ?>" loading="lazy">
							<div class="card-name">
								<h3 class="art-title">
									<?php echo $artName ?>
								</h3>
								<p class="likes-count">
									<?php echo $artCollection->getArtLikes($artId); ?>
									<i class="fas fa-heart liked"></i>
								</p>
							</div>
						</a>
						<?php
					}
				} else {
					echo '<h2 class="not-uploaded-images">You have not uploaded any art yet!</h2>';
				}
				?>
			</section>
		</main>
		@@include('php/components/_footer.php')
	</div>
	@@include('php/components/_to-top-btn.php',{})
</body>

</html>