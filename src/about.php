@@include('php/components/_head.php',{ "title":"OxyProject | About" })

<body>
	<div class="wrapper">
		@@include('php/components/_header.php',{})
		<main class="main__content main__about">
			<section class="about__content first-section">
				<div class="container">
					<h1 class="about__title">Building an open digital economy</h1>
					<p class="about__text">
						OxyProject is a platform for artists to sell their art and collect money from their fans.
						We are a team of creative and passionate people who are dedicated to creating a better world.
						NFTs have exciting new properties: they’re unique, provably scarce, tradeable, and usable across multiple applications. Just like physical goods, you can do whatever you want with them! You could throw them in the trash, gift them to a friend across the world, or go sell them on an open marketplace. But unlike physical goods, they're armed with all the programmability of digital goods.
					</p>
				</div>
				<img class="about-img" src="assets/images/about.svg" alt="About">
			</section>
			<section class="about__content second-section">
				<img class="about-img lightbulb" src="assets/images/lightbulb.svg" alt="About">

				<div class="container story-container">
					<h1 class="about__title">Our story</h1>
					<p class="about__text">
						In 2020 the world witnessed the birth of CryptoKitties. For the first time, the world experienced a decentralized application built on blockchains but targetted towards a mainstream audience.
						While CryptoKitties felt like a toy to many, it represented a dramatic shift in how we interact with items in the digital world. While previous digital items lived on company servers, blockchain-native items lived on shared, public blockchains owned by no single party. They could be viewed anywhere, exchanged openly, and truly owned in a way that was never before possible in the digital world.
					</p>
					<p class="about__text">
						As a company, we’re thrilled to be at the center of this growing industry, and will continue to invest in our core infrastructure as we build the most accessible marketplace for buyers, sellers, and creators.
					</p>
				</div>
			</section>
		</main>
		@@include('php/components/_footer.php')
	</div>
	@@include('php/components/_to-top-btn.php',{})
</body>

</html>