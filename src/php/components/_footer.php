<footer class="footer__main">
	<div class="container">
		<span class="container__line"></span>
		<div class="logo">
			<div class="logo__content">
				<img src="img/logo/logo-footer.svg" alt="Oxy Project Logo" />
				<a class="logo__content_text" href="index.php">OxyProject</a>
			</div>
			@@include('_share-buttons.php')
		</div>
		<div class="navigation">
			<div class="column">
				<div class="column__title">Navigation</div>
				<div class="column__links">
					<a href="index.php">Home</a>
					<a href="#">Explore</a>
					<a href="#">Authors</a>
					<a href="blog.php">Blog</a>
				</div>
			</div>
			<div class="column">
				<div class="column__title">Explore</div>
				<div class="column__links">
					<a href="collections.php">Collections</a>
					<a href="auctions.php">Auctions</a>
					<a href="leaderboard.php">Leaderboard</a>
					<a href="#">Community</a>
				</div>
			</div>
			<div class="column">
				<div class="column__title">Community</div>
				<div class="column__links">
					<a href="#">Partners</a>
					<a href="#">Blog</a>
					<a href="#">Newsletter</a>
					<a href="#">Help Center</a>
				</div>
			</div>
		</div>
		<div class="subscribe">
			<div class="subscribe__title">Subscribe Us</div>
			<div class="subscribe__form">
				<form action="sendEmail.php" method="POST">
					<input class="form__input" name="subscribe" type="email" placeholder="Enter your email" />
					<button class="plane__icon fa-regular fa-paper-plane" type="submit" name="submit"></button>
				</form>
			</div>
			<p class="subscribe__subtitle">Your privacy is protected! We dont disclose Email.</p>
		</div>
	</div>
	<div class="copyright">
		<div class="copyright__text">
			&copy; <?= date('Y') ?> - OxyProject. All rights reserved.
		</div>
		<div class="copyright__links">
			<a href="#">Privacy Policy</a>
			<a href="#">Terms of Service</a>
		</div>
	</div>
</footer>