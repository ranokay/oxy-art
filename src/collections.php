@@include('php/components/_head.php',{ "title":"OxyProject | Collections" })

<body>
	<div class="wrapper">
		@@include('php/components/_header.php',{})
		<main class="main__content main__explore">
			<h2>Explore arts from other creators</h2>
			<section class="explore__container">
				<?php
				include "php/dbh.inc.php";
				include "php/CollectionClass.inc.php";
				$art = new Collection();
				if ($art) {
					foreach ($art->getArts() as $art) {
						$artId = $art['id'];
						$artName = $art['name'];
						$artDir = $art['art_dir'];
				?>
						<div class="explore__arts">
							<a class="explore__arts-card" href="art.php?art=<?php echo $artId; ?>">
								<img src="<?php echo $artDir; ?>" alt="<?php echo $artName; ?>">
								<h3><?php echo $artName; ?></h3>
							</a>
						</div>
				<?php
					}
				} else {
					echo '<p>No arts found</p>';
				}
				?>
			</section>
		</main>
		@@include('php/components/_footer.php')
	</div>
	@@include('php/components/_to-top-btn.php',{})
</body>

</html>