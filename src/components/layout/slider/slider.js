
/*
Документація по роботі у шаблоні: 
Документація слайдера: https://swiperjs.com/
Сніппет(HTML): swiper
*/

// Підключаємо слайдер Swiper з node_modules
// При необхідності підключаємо додаткові модулі слайдера, вказуючи їх у {} через кому
// Приклад: { Navigation, Autoplay }
import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
/*
Основні модулі слайдера:
Navigation, Pagination, Autoplay, 
EffectFade, Lazy, Manipulation
Детальніше дивись https://swiperjs.com/
*/

// Стилі Swiper
// Підключення базових стилів
import "./slider.scss";
// Повний набір стилів з node_modules
// import 'swiper/css/bundle';

function initSliders() {
	const sliders = document.querySelectorAll('[data-fls-slider]');

	if (!sliders.length) return;

	sliders.forEach((sliderBlock) => {
		const sliderEl = sliderBlock.querySelector('.swiper');
		const prevBtn = sliderBlock.querySelector('.slider-block__button--prev');
		const nextBtn = sliderBlock.querySelector('.slider-block__button--next');
		const paginationEl = sliderBlock.querySelector('.slider-block__pagination');
		const sliderType = sliderBlock.dataset.sliderType || 'default';

		if (!sliderEl) return;
		if (sliderEl.classList.contains('swiper-initialized')) return;

		let options = {
			modules: [Navigation, Pagination],
			observer: true,
			observeParents: true,
			speed: 800,
			watchOverflow: true,
			slidesPerView: 1,
			spaceBetween: 16,
		};

		if (prevBtn && nextBtn) {
			options.navigation = {
				prevEl: prevBtn,
				nextEl: nextBtn,
			};
		}

		if (paginationEl) {
			options.pagination = {
				el: paginationEl,
				clickable: true,
			};
		}

		if (sliderType === 'services') {
			options = {
				...options,
				loop: true,
				slidesPerView: 1.2,
				spaceBetween: 16,
				breakpoints: {
					576: {
						slidesPerView: 2,
						spaceBetween: 16,
					},
					768: {
						slidesPerView: 2.2,
						spaceBetween: 20,
					},
					992: {
						slidesPerView: 3,
						spaceBetween: 24,
					},
					// 1268: {
					// 	slidesPerView: 3.5,
					// 	spaceBetween: 24,
					// },
				},
			};
		}

		new Swiper(sliderEl, options);
	});
}

window.addEventListener('load', initSliders);