@@include('php/components/_head.php',{ "title":"OxyProject | Homepage" })

<body class="home__body">
	<div class="wrapper wrapper__home">
		@@include('php/components/_header.php',{})
		<main class="main__content">
			<section class="hero">
				@@include('php/components/_waves-top.php',{})
				<div class="container">
					<div class="left__side">
						<h1 class="title">
							<span class="title__content">Your Platform</span>
							<span class="title__content">For</span>
							<span class="title__content">Digital Arts</span>
						</h1>
						<div class="buttons">
							<a href="collections.php" class="btn btn__gradient">Explore</a>
							<?php
							if (isset($_SESSION['userID'])) {
								echo '<a href="new-art.php" class="btn btn__default">Upload</a>';
							} else {
								echo '<a href="login.php" class="btn btn__default">Upload</a>';
							}
							?>
						</div>
					</div>
					<iframe id="iframe" src='https://my.spline.design/miniroomartcopy-29903b597d4fe4c577dc95d57d419f96/'
						frameborder='0' width='100%' height='100%'></iframe>
				</div>
			</section>
		</main>
	</div>
</body>

</html>