<header class="header__main">
	<a class="logo" href="index.php">
		<img src="img/logo/logo.svg" alt="Oxy Project Logo" />
		<div class="logo__text">OxyProject</div>
	</a>
	<div class="line"></div>
	<div class="mobile__burger">
		<span class="mobile__burger_line"></span>
		<span class="mobile__burger_line"></span>
		<span class="mobile__burger_line"></span>
	</div>
	<div class="mobile">
		<div class="mobile__menu">
			<form class="mobile__menu_search" action="" autocomplete="on">
				<div class="search__icon">
					<img src="img/icons/search.svg" alt="Search" />
				</div>
				<input class="search__input" name="search" type="search" placeholder="Search items, collections, and creators" />
			</form>
			<nav class="navbar">
				<div class="navbar__resources">
					<a class="nav__btn" href="index.php"><img class="link__icon" src="img/icons/home.svg" alt="">Home</a>
				</div>
				<div class="navbar__resources dropbtn">
					<a class="nav__btn dropdown_menu">
						<img class="link__icon" src="img/icons/explore.svg" alt="">Explore
						<img class="link__icon arrow__down" src="img/icons/arrow-down.svg" alt="">
					</a>
					<div class="dropdown__content content">
						<a href="collections.php">Collections</a>
						<a href="auctions.php">Auctions</a>
						<a href="leaderboard.php">Leaderboard</a>
					</div>
				</div>
				<div class="navbar__resources dropbtn">
					<a class="nav__btn dropdown_menu">
						<img class="link__icon" src="img/icons/resources.svg" alt="">Resources
						<img class="link__icon arrow__down" src="img/icons/arrow-down.svg" alt="">
					</a>
					<div class="dropdown__content content">
						<a href="partners.php">Partners</a>
						<a href="blog.php">Blog</a>
						<a href="news.php">Newsletter</a>
					</div>
				</div>
				<div class="navbar__resources">
					<a class="nav__btn" href="contact.php"><img class="link__icon" src="img/icons/contact.svg" alt="">Contact</a>
				</div>
			</nav>
			<button class="btn btn__gradient btn_connect" type="submit">
				<div class="wallet__icon">
					<img src="img/icons/wallet.svg" alt="Connect" />
				</div>
				Connect
			</button>
			<button class="btn btn__default btn_profile" type="submit">
				<img class="profile__icon" src="img/icons/circle-user-regular.svg" alt="Profile" />
			</button>
		</div>
		<div class="mobile__footer">
			<button class="btn btn__blue" type="submit">Connect</button>
			<div class="mobile__footer_bg">
				@@include('_shareButtons.php')
			</div>
		</div>
	</div>

</header>