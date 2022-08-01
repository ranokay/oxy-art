@@include('php/components/_head.php',{ "title":"OxyProject | Art" })


<body>
	<div class="wrapper">
		@@include('php/components/_header.php',{})
		<main class="main__content main__explore">

			<?php
			include "php/ArtContr.inc.php";
			?>
			<h2>
				<?php echo $art->getArtName(); ?>
			</h2>
			<section class="explore__container">
				<div class="explore__art">
					<div class="explore__art-card">
						<img src="<?php echo $art->getArtDir(); ?>" alt="Art Image">
					</div>
				</div>
			</section>
		</main>
		@@include('php/components/_footer.php')
	</div>
	@@include('php/components/_to-top-btn.php',{})
</body>

</html>