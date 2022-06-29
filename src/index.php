@@include('php/components/_head.php',{ "title":"OxyProject | Homepage" })

<body>
	<div class="loader">
		<img src="img/logo/logo-footer.svg" alt="">
	</div>
	<div class="wrapper wrapper__home">
		@@include('php/components/_header.php',{})
		<main class="main__content">
			@@include('php/layouts/_home-hero.php',{})
			@@include('php/layouts/_home-collections.php',{})
			@@include('php/layouts/_home-auctions.php',{})
		</main>
		@@include('php/components/_waves-bottom.php',{})
		@@include('php/components/_footer.php')
	</div>
	@@include('php/components/_to-top-btn.php',{})
	@@include('php/components/_scripts.php',{})
</body>

</html>