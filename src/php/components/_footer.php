<footer class="footer__main" id="footer">
	<div class="container">
		<span class="container__line"></span>
		<div class="logo">
			<div class="logo__content">
				<img src="assets/logo/logo-footer.svg" alt="Oxy Project Logo" />
				<a class="logo__content_text" href="home">OxyProject</a>
			</div>
			@@include('_share-buttons.php')
		</div>
		<div class="navigation">
			<div class="column">
				<div class="column__title">Navigation</div>
				<div class="column__links">
					<a href="home">Home</a>
					<a href="collections">Collections</a>
				</div>
			</div>
			<div class="column">
				<div class="column__title">Community</div>
				<div class="column__links">
					<a href="about">About</a>
					<a href="contact">Help Center</a>
				</div>
			</div>
		</div>
		<div class="subscribe">
			<div class="subscribe__title">Subscribe Us</div>
			<div class="subscribe__form form">
				<form action="php/subscribe.inc.php" method="POST">
					<input class="form__input" name="email" type="email" placeholder="Enter your email" />
					<button class="plane__btn" type="submit" name="subscribe">
						<img class="plane__icon" src="assets/icons/paper-plane.svg" alt="Send message">
					</button>
					<?php
					if (isset($_SESSION['error-subs'])) {
						$errorMsg = $_SESSION['error-subs'];
						unset($_SESSION['error-subs']);
						echo "<p class='error-msg'>{$errorMsg}</p>";
					}
					if (isset($_SESSION['success-subs'])) {
						$successMsg = $_SESSION['success-subs'];
						unset($_SESSION['success-subs']);
						echo "<p class='success-msg'>{$successMsg}</p>";
					}
					?>
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
			<a href="terms#privacy-policy">Privacy Policy</a>
			<a href="terms">Terms of Service</a>
		</div>
	</div>
</footer>