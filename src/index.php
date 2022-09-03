@@include('php/components/_head.php',{ "title":"OxyProject | Homepage" })

<body class="home__body">
	<?php
	if (isset($_GET['success'])) {
		if ($_GET['success'] == "accountdeleted") {
			echo '<script>
							alert("Your account has been deleted.");
						</script>';
		}
	}
	?>
	<div class="wrapper wrapper__home">
		@@include('php/components/_header.php',{})
		<main class="main__content">
			<section class="hero">
				@@include('php/components/_waves-top.php',{})
				<div class="container">
					<div class="left__side">
						<h1 class="title">
							<span class="title__content">The Platform</span>
							<span class="title__content">For</span>
							<span class="title__content">Digital Arts</span>
						</h1>
						<div class="buttons">
							<a href="collections" class="btn btn__gradient">Explore</a>
							<a href="dashboard" class="btn btn__default">Upload</a>
						</div>
					</div>
					<iframe src='https://my.spline.design/miniroomartcopy-29903b597d4fe4c577dc95d57d419f96/' frameborder='0' width='100%' height='100%'></iframe>
				</div>
			</section>
		</main>
	</div>
</body>

</html>