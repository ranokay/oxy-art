<header class="header__main">
	<a class="logo" href="home" title="Homepage">
		<img src="img/logo/logo.svg" alt="Oxy Project Logo" />
		<div class="logo__text">OxyProject</div>
	</a>
	<div class="line"></div>
	<div class="left__side-mobile">
		<?php
		if (isset($_SESSION['userId'])) {
		?>
			<a class="btn btn-profile-mobile" href="dashboard">
				<img class="profile__icon-mobile" src="img/icons/circle-user-regular.svg" alt="Profile" />
			</a>
		<?php
		} else {
		?>
			<a class="btn btn-profile-mobile" href="login">
				<img class="profile__icon-mobile" src="img/icons/circle-user-regular.svg" alt="Profile" />
			</a>
		<?php
		}
		?>
		<div class="mobile__burger">
			<span class="mobile__burger_line"></span>
			<span class="mobile__burger_line"></span>
			<span class="mobile__burger_line"></span>
		</div>
	</div>
	<div class="mobile">
		<div class="mobile__menu">
			<form class="mobile__menu_search" action="" autocomplete="on">
				<div class="search__icon">
					<img src="img/icons/search.svg" alt="Search" />
				</div>
				<input class="search__input" name="search" type="search" placeholder="Search arts, collections, and creators" />
			</form>
			<nav class="navbar">
				<div class="navbar__resources dropbtn">
					<a class="nav__btn dropdown_menu">
						<img class="link__icon" src="img/icons/explore.svg" alt="">Explore
						<img class="link__icon arrow__down" src="img/icons/arrow-down.svg" alt="">
					</a>
					<div class="dropdown__content content">
						<a href="collections">Collections</a>
						<a href="auctions">Auctions</a>
						<a href="leaderboard">Leaderboard</a>
					</div>
				</div>
				<div class="navbar__resources dropbtn">
					<a class="nav__btn dropdown_menu">
						<img class="link__icon" src="img/icons/resources.svg" alt="">Resources
						<img class="link__icon arrow__down" src="img/icons/arrow-down.svg" alt="">
					</a>
					<div class="dropdown__content content">
						<a href="partners">Partners</a>
						<a href="blog">Blog</a>
						<a href="news">Newsletter</a>
					</div>
				</div>
				<div class="navbar__resources">
					<a class="nav__btn" href="contact"><img class="link__icon" src="img/icons/contact.svg" alt="">Contact</a>
				</div>
				<div class="navbar__resources">
					<a class="nav__btn" href="about"><img class="link__icon" src="img/icons/home.svg" alt="">About</a>
				</div>
			</nav>
			<?php
			if (isset($_SESSION['userId'])) {
			?>
				<a class="btn btn-balance" href="dashboard" title="Balance">
					<img class="wallet__icon" src="img/icons/wallet.svg" alt="Balance" />
					$ 123.45
				</a>
				<a class="btn btn-profile" href="dashboard">
					<img class="profile__icon" src="img/icons/circle-user-regular.svg" alt="Profile" title="Profile" />
				</a>
				<a class="btn btn-profile" href="php/logout.inc.php">
					<img class="profile__icon" src="img/icons/logout.svg" alt="Logout" title="Logout" />
				</a>
			<?php
			} else {
			?>
				<a class="btn btn__gradient btn-connect" href="signup">Sign Up</a>
				<a class="btn  btn-profile" href="login">
					<img class="profile__icon" src="img/icons/circle-user-regular.svg" alt="Profile" title="Login" />
				</a>
			<?php
			}
			?>
		</div>
		<div class="mobile__footer">
			<?php
			if (isset($_SESSION['userId'])) {
			?>
				<a class="btn btn__blue" href="php/logout.inc.php">
					Logout
				</a>
			<?php
			} else {
			?>
				<a class="btn btn__blue" href="signup">
					Sign Up
				</a>
			<?php
			}
			?>
			<div class="mobile__footer_bg">
				@@include('_share-buttons.php')
			</div>
		</div>
	</div>

</header>