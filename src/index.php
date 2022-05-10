<!DOCTYPE html>
<html lang="en">
@@include('php/partials/_head.php',{ "title":"Oxy Project | Homepage" })

<body>
	@@include('php/partials/_wavesTop.php')
	@@include('php/partials/_header.php',{})
	<div class="wrapper-page">
		<main class="home-page">
			@@include('php/partials/_hero.php',{})
			@@include('php/partials/_collections.php',{})
			@@include('php/partials/_auctions.php',{})
		</main>
	</div>
	@@include('php/partials/_wavesBottom.php')
	@@include('php/partials/_toTopButton.php',{})
	@@include('php/partials/_js.php',{})
</body>

</html>