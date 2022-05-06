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
		</main>
		@@include('php/partials/_wavesBottom.php')
	</div>
	@@include('php/partials/_js.php',{})
</body>

</html>