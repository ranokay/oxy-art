@@include('php/components/_head.php',{ "title":"OxyProject | Contact" })

<body>
	<div class="wrapper">
		@@include('php/components/_header.php',{})
		<main class="main__content main__contact">
			<section class="left__side">
				<form class="form form__contact" action="php/send-issue-message.inc.php" method="POST">
					<?php
					if (isset($_GET['error'])) {
						if ($_GET['error'] == 'emptyfields') {
							echo '<p class="form__error">Fill in all fields!</p>';
						} else if ($_GET['error'] == 'stmtfailed') {
							echo '<p class="form__error">Server error!</p>';
						} else if ($_GET['error'] == 'invalidemail') {
							echo '<p class="form__error">Invalid email!</p>';
						}
					}
					if (isset($_GET['sent'])) {
						if ($_GET['sent'] == 'success') {
							echo '<p class="form__success">Your message has been sent!</p>';
						}
					}
					?>
					<div class="form__group">
						<input type="text" name="name" class="form__input" placeholder="Your name" required>
					</div>
					<div class="form__group">
						<input type="email" name="email" class="form__input" placeholder="Your email" required>
					</div>
					<div class="form__group">
						<input type="text" name="subject" class="form__input" placeholder="Subject" required>
					</div>
					<div class="form__group">
						<textarea name="message" class="form__input form__input-textarea" placeholder="Your message" required></textarea>
					</div>
					<div class="form__group">
						<button type="submit" name="send-message" class="btn btn__gradient">Send Message</button>
					</div>
				</form>
			</section>
			<section class="right__side">
				<div class="contact__info">
					<h2 class="contact__info__title">Get in touch</h2>
					<div class="contact__info__item">
						<div class="contact__info__item__icon">
							<i class="fas fa-map-marker-alt"></i>
						</div>
						<div class="contact__info__item__text">
							<p>
								<span>Address:</span>
								<span>Street, City, Country</span>
							</p>
						</div>
					</div>
					<div class="contact__info__item">
						<div class="contact__info__item__icon">
							<i class="fas fa-phone"></i>
						</div>
						<div class="contact__info__item__text">
							<p>
								<span>Phone:</span>
								<span>+1 (123) 456-7890</span>
							</p>
						</div>
					</div>
					<div class="contact__info__item">
						<div class="contact__info__item__icon">
							<i class="fas fa-envelope"></i>
						</div>
						<div class="contact__info__item__text">
							<p>
								<span>Email:</span>
								<span>example@mail.com </span>
							</p>
						</div>
					</div>
				</div>
			</section>
		</main>
		@@include('php/components/_footer.php')
	</div>
	@@include('php/components/_to-top-btn.php',{})
</body>

</html>