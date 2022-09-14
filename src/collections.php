@@include('php/components/_head.php',{ "title":"OxyProject | Collections" })

<body>
	<div class="wrapper">
		@@include('php/components/_header.php',{})
		<main class="main__content main__explore">
			<h2>Explore public arts</h2>
			<span class="main__explore-line"></span>
			<section class="explore__container">
				<?php
				include "php/CollectionClass.inc.php";
				$artCollection = new Collection();
				if ($artCollection->getPublicArts()) {
					foreach ($artCollection->getPublicArts() as $art) {
						$artId = $art['id'];
						$artName = $art['name'];
						$artDir = $art['art_dir'];
				?>
						<div class="explore__arts">
							<a class="explore__arts-card" href="art?id=<?php echo $artId; ?>">
								<img class="card-image" src="<?php echo $artDir; ?>" alt="<?php echo $artName; ?>" loading="lazy">
								<div class="card-name">
									<h3><?php echo $artName ?> </h3>
									<p class="likes-count">
										<?php echo $artCollection->getArtLikes($artId); ?>
										<i class="fas fa-heart liked"></i>
									</p>
								</div>
							</a>
						</div>
				<?php
					}
				} else {
					echo "<h2 class='no-public-arts'>No public art found.</h2>";
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
			</section>
		</main>
		@@include('php/components/_footer.php')
	</div>
	@@include('php/components/_to-top-btn.php',{})
</body>

</html>