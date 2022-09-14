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
const toTopBtn = document.querySelector('.btn_to_top')
window.addEventListener('scroll', () => {
	if (!toTopBtn) {
		return
	}
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

// remove open class when resize window
window.addEventListener('resize', () => {
	if (breakpointDesktop.matches) {
		mobile.classList.remove('open')
		mobileBurger.classList.remove('open')
		bodyScrollLock.classList.remove('scroll__lock')
		headerMain.classList.remove('focus')
	}
})

// fadeout loader on page load
const loader = document.querySelector('.loader')
window.addEventListener('load', () => {
	if (loader) {
		loader.classList.add('fadeout')
	}
})

// autogrow art textarea
const textarea = document.querySelectorAll('.art-textarea')
if (textarea) {
	textarea.forEach(item => {
		if (item.scrollHeight > item.clientHeight) {
			item.style.height = item.scrollHeight + 'px'
		}
	})
}

// hide edit button and show edit form
const editBtn = document.querySelector('.edit-btn')
const editBtnsDiv = document.querySelector('.edit-buttons')
const artBtnsDiv = document.querySelector('.art-buttons')
const cancelEditBtn = document.querySelector('.cancel-edit-btn')
const checkboxPublic = document.querySelector('.form__checkbox')
const editTextarea = document.querySelectorAll('.art-textarea')
const eyeIcon = document.querySelector('.eye-icon')
if (editBtn) {
	editBtn.addEventListener('click', () => {
		editBtnsDiv.classList.add('hidden')
		eyeIcon.classList.add('hidden')
		artBtnsDiv.classList.remove('hidden')
		checkboxPublic.classList.remove('hidden')
		editTextarea.forEach(item => {
			item.removeAttribute('readonly')
			item.classList.add('art-textarea--edit')
		})
	})
}
if (cancelEditBtn) {
	cancelEditBtn.addEventListener('click', () => {
		editBtnsDiv.classList.remove('hidden')
		eyeIcon.classList.remove('hidden')
		artBtnsDiv.classList.add('hidden')
		checkboxPublic.classList.add('hidden')
		editTextarea.forEach(item => {
			item.setAttribute('readonly', 'readonly')
			item.classList.remove('art-textarea--edit')
		})
		window.location.reload()
	})
}

// hide success message
const formSuccess = document.querySelector('.form__success')
const successMsg = document.querySelector('.success-msg')
if (formSuccess) {
	setTimeout(() => {
		formSuccess.style.display = 'none'
	}, 5000)
}
if (successMsg) {
	setTimeout(() => {
		successMsg.style.display = 'none'
	}, 5000)
}

// hide error message
const formError = document.querySelector('.form__error')
const errorMsg = document.querySelector('.error-msg')
if (formError) {
	setTimeout(() => {
		formError.style.display = 'none'
	}, 10000)
}
if (errorMsg) {
	setTimeout(() => {
		errorMsg.style.display = 'none'
	}, 10000)
}

// image upload preview
const imageUpload = document.querySelector('#image-upload')
const imagePreview = document.querySelector('#image-preview')
if (imageUpload) {
	imageUpload.addEventListener('change', () => {
		const file = imageUpload.files[0]
		if (file) {
			const reader = new FileReader()
			reader.addEventListener('load', () => {
				imagePreview.setAttribute('src', reader.result)
			})
			reader.readAsDataURL(file)
		}
	})
}

// if image is not found
const images = document.querySelectorAll('img')
images.forEach(item => {
	item.addEventListener('error', () => {
		item.src = '../assets/icons/no-image.svg'
	})
})
