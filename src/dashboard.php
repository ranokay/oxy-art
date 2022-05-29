@@include('php/components/_head.php',{ "title":"OxyProject | Dashboard" })

<body>
	<div class="wrapper">
		@@include('php/components/_header.php',{})
		<main class="main__content">
			<div class="dashboard">
				<h1 class="dashboard__title">Dashboard</h1>
			</div>
		</main>
		@@include('php/components/_footer.php')
	</div>
	@@include('php/components/_to-top-btn.php',{})
	@@include('php/components/_scripts.php',{})
</body>

</html>