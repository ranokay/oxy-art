// const breakpointTablet = matchMedia('(min-width: 768px)')
const breakpointDesktop = matchMedia('(min-width: 1024px)')

// header scrolled
const headerMain = document.querySelector('.header__main')
const navBtn = document.querySelectorAll('.nav__btn')
window.addEventListener('scroll', () => {
	if (window.scrollY > 0) {
		headerMain.classList.add('scrolled')
		navBtn.forEach(item => {
			item.classList.add('scrolled')
		})
	} else {
		headerMain.classList.remove('scrolled')
		navBtn.forEach(item => {
			item.classList.remove('scrolled')
		})
	}
})

// to top button
window.addEventListener('scroll', () => {
	const toTopBtn = document.querySelector('.btn_to_top')
	if (window.scrollY > 100) {
		toTopBtn.classList.add('active')
	} else {
		toTopBtn.classList.remove('active')
	}
})

// open mobile menu
const mobileBurger = document.querySelector('.mobile__burger')
const mobile = document.querySelector('.mobile')
const bodyScrollLock = document.querySelector('body')
mobileBurger.addEventListener('click', () => {
	mobileBurger.classList.toggle('open')
	mobile.classList.toggle('open')
	bodyScrollLock.classList.toggle('scroll__lock')
	headerMain.classList.toggle('focus')
})

// open menu dropdown links
const dropbtn = document.querySelectorAll('.dropbtn')
const dropdownContent = document.querySelectorAll('.content')

window.onclick = event => {
	dropdownContent.forEach(item => {
		if (!event.target.closest('.dropbtn')) {
			item.classList.remove('open')
		}
	})
}
const showDropdown = () => {
	dropbtn[0].addEventListener('click', () => {
		if (!breakpointDesktop.matches) {
			dropdownContent[0].classList.toggle('open')
			dropdownContent[1].classList.remove('open')
		}
	})
	dropbtn[1].addEventListener('click', () => {
		if (!breakpointDesktop.matches) {
			dropdownContent[1].classList.toggle('open')
			dropdownContent[0].classList.remove('open')
		}
	})
}
showDropdown()

window.addEventListener('resize', () => {
	if (breakpointDesktop.matches) {
		mobile.classList.remove('open')
		mobileBurger.classList.remove('open')
		bodyScrollLock.classList.remove('scroll__lock')
		headerMain.classList.remove('focus')
		dropdownContent.forEach(item => {
			item.classList.remove('open')
		})
	}
})
