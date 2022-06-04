@@include('php/components/_head.php',{ "title":"OxyProject | Collections" })

<body>
	<div class="wrapper">
		@@include('php/components/_header.php',{})
		<main class="main__content">
			<section class="explore">
				<h2>Explore</h2>
				<div class="section__header">
					<div class="section__header-title">
						<img src="img/icons/collections.svg" alt="">
						<h2>Art Collections</h2>
					</div>
					<button class="btn btn__default see-all-btn">
						<a href="#">See All</a>
						<i class="fa-solid fa-arrow-right-long"></i>
					</button>
				</div>
			</section>
		</main>
		@@include('php/components/_footer.php')
	</div>
	@@include('php/components/_to-top-btn.php',{})
	@@include('php/components/_scripts.php',{})
</body>

</html>