<footer class="footer__main">
	<div class="column">
		<div class="column__title">Subscribe Us</div>
		<div class="column__form">
			<form action="" method="post">
				<input class="form__input" name="subscribe" type="text" placeholder="Enter your email..." />
				<button class="plane__icon fa-regular fa-paper-plane" type="submit"></button>
			</form>
		</div>
	</div>
	<div class="column">
		<div class="column__logo">
			<img src="img/logo/logo.svg" alt="Oxy Project Logo" />
			<a class="column__logo_text" href="index.php">OxyProject</a>
		</div>
		@@include('_shareButtons.php')
	</div>
	<div class="container">
		<div class="column">
			<div class="column__title">Navigation</div>
			<div class="column__links">
				<a href="index.php">Home</a>
				<a href="#">Explore</a>
				<a href="#">Authors</a>
				<a href="php/blog.php">Blog</a>
			</div>
		</div>
		<div class="column">
			<div class="column__title">Explore</div>
			<div class="column__links">
				<a href="php/collections.php">Collections</a>
				<a href="php/auctions.php">Auctions</a>
				<a href="php/leaderboard.php">Leaderboard</a>
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
	<div class="copyright">
		<div class="copyright__text">
			&copy; <?= date('Y') ?> OxyProject. All rights reserved.
		</div>
		<a class="copyright__link" href="#">Privacy Policy</a>
		<a class="copyright__link" href="#">Terms of Service</a>
	</div>
</footer>