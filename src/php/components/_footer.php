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
					$url = $_SERVER['REQUEST_URI'];
					if (str_contains($url, 'error')) {
						if (str_contains($url, 'error=emptyfields')) {
							echo '<p class="form__error">Please fill in all fields!</p>';
						}
						if (str_contains($url, 'error=invalidemail')) {
							echo '<p class="form__error">Invalid email!</p>';
						}
						if (str_contains($url, 'error=usernotfound')) {
							echo '<p class="form__error">User not found!</p>';
						}
						if (str_contains($url, 'error=alreadysubscribed')) {
							echo '<p class="form__error">You are already subscribed!</p>';
						}
					}
					if (str_contains($url, 'success')) {
						if (str_contains($url, 'success=subscribed')) {
							echo '<p class="form__success">You have been subscribed!</p>';
						}
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