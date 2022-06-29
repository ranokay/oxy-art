@@include('php/components/_head.php',{ "title":"OxyProject | Collections" })

<body>
	<div class="wrapper">
		@@include('php/components/_header.php',{})
		<main class="main__content main__explore">
			<h2>Explore</h2>
			<section class="explore__container">
				<div class="explore__header">
					<button class="btn btn__default" type="menu" name="all-styles">All Styles</button>
					<button class="btn btn__default" type="menu" name="synthwave">Synthwave</button>
					<button class="btn btn__default" type="menu" name="steampunk">Steampunk</button>
					<button class="btn btn__default" type="menu" name="vibrant">Vibrant</button>
					<button class="btn btn__default" type="menu" name="psychic">Psychic</button>
					<button class="btn btn__default" type="menu" name="mystical">Mystical</button>
				</div>
				<?php
				$art = new ArtContr();
				if ($art) {
					foreach ($art->getArts() as $art) {
						$artId = $art['id'];
						$artName = $art['name'];
						$artCollection = $art['collection_name'];
						$artDesc = $art['description'];
						$artOwner = $art['owner_id'];
						$artPrice = $art['price'];
						$artDir = $art['art_dir'];
						$artDate = $art['date_added'];
				?>
						<div class="explore__arts">
							<div class="explore__arts-card">
								<img src="<?php echo $artDir; ?>" alt="<?php echo $artName; ?>">
								<h3><?php echo $artName; ?></h3>
								<p><?php echo $artPrice . ' $' ?></p>
							</div>
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
	@@include('php/components/_scripts.php',{})
</body>

</html>