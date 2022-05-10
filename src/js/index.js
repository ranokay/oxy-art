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

const toTopBtn = document.querySelector('.btn-to-top')

window.addEventListener('scroll', function () {
	if (window.scrollY > 100) {
		toTopBtn.classList.add('active')
	} else {
		toTopBtn.classList.remove('active')
	}
})
