const headerMain = document.querySelector('.header-main')

window.onscroll = function () {
	handleScroll()
}
function handleScroll() {
	if (window.scrollY > 0) {
		headerMain.classList.add('header-main--scrolled')
	} else {
		headerMain.classList.remove('header-main--scrolled')
	}
}
