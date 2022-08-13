@@include('php/components/_head.php',{ "title":"OxyProject | Art" })

<body>
	<div class="wrapper">
		@@include('php/components/_header.php',{})
		<main class="main__content main__art">

			<?php
			include "php/ArtContr.inc.php";
			?>

			<section class="art__container">
				<div class="art-card">
					<img class="art-image" src="<?php echo $art->getArtDir(); ?>" alt="Art Image">
				</div>
			</section>
			<section class="description__container">
				<h2 class="art-name">
					<?php echo $art->getArtName(); ?>
				</h2>
				<p class="art-desc">
					<?php echo $art->getArtDescription(); ?>
				</p>
				<div class="art-owner-n-date">
					<a class="art-owner" href="user?id=<?php echo $art->getArtOwnerId(); ?>">
						<img class="owner-avatar" src="<?php echo $art->getArtOwnerAvatar(); ?>" alt="Owner Avatar">
						<?php echo $art->getArtOwnerName(); ?>
					</a>
					<p class="art-date">
						<?php echo $art->getArtDate(); ?>
					</p>
				</div>
			</section>
		</main>
		@@include('php/components/_footer.php')
	</div>
	@@include('php/components/_to-top-btn.php',{})
</body>

</html>