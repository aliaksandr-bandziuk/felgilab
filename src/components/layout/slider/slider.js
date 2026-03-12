
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

function initReviewMedia(sliderBlock, swiperInstance) {
	const mediaWrap = document.querySelector('.reviews__media');
	if (!mediaWrap || !swiperInstance) return;

	const reviewSlides = sliderBlock.querySelectorAll('.reviews__slide');
	const mediaGalleries = mediaWrap.querySelectorAll('.reviews__media-gallery');

	if (!reviewSlides.length || !mediaGalleries.length) return;

	const mediaSwipers = new Map();

	mediaGalleries.forEach((gallery) => {
		const sliderEl = gallery.querySelector('.reviews__media-slider');
		const paginationEl = gallery.querySelector('.reviews__media-pagination');
		const slides = gallery.querySelectorAll('.swiper-slide');

		if (!sliderEl) return;
		if (sliderEl.classList.contains('swiper-initialized')) return;

		const mediaSwiper = new Swiper(sliderEl, {
			modules: [Pagination],
			slidesPerView: 1,
			spaceBetween: 0,
			speed: 600,
			resistanceRatio: 0,
			pagination: {
				el: paginationEl,
				clickable: true,
			},
		});

		if (slides.length <= 1 && paginationEl) {
			paginationEl.style.display = 'none';
		}

		mediaSwipers.set(gallery.dataset.reviewGalleryId, mediaSwiper);
	});

	let currentGalleryId = reviewSlides[swiperInstance.realIndex]?.dataset.reviewGalleryId || '0';

	const switchGallery = (newGalleryId) => {
		if (!newGalleryId || newGalleryId === currentGalleryId) return;

		const currentGallery = mediaWrap.querySelector(`.reviews__media-gallery[data-review-gallery-id="${currentGalleryId}"]`);
		const nextGallery = mediaWrap.querySelector(`.reviews__media-gallery[data-review-gallery-id="${newGalleryId}"]`);

		if (!nextGallery) return;

		mediaWrap.classList.add('is-changing');

		setTimeout(() => {
			if (currentGallery) currentGallery.classList.remove('is-active');
			nextGallery.classList.add('is-active');

			const nextSwiper = mediaSwipers.get(newGalleryId);
			if (nextSwiper) {
				nextSwiper.update();
				nextSwiper.pagination.update();
			}

			currentGalleryId = newGalleryId;
			mediaWrap.classList.remove('is-changing');
		}, 180);
	};

	const initialGallery = mediaWrap.querySelector(`.reviews__media-gallery[data-review-gallery-id="${currentGalleryId}"]`);
	if (initialGallery) {
		mediaGalleries.forEach((gallery) => gallery.classList.remove('is-active'));
		initialGallery.classList.add('is-active');
	}

	swiperInstance.on('slideChange', () => {
		const activeSlide = reviewSlides[swiperInstance.realIndex];
		if (!activeSlide) return;

		const newGalleryId = activeSlide.dataset.reviewGalleryId;
		switchGallery(newGalleryId);
	});
}

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

		if (sliderType === 'reviews') {
			options = {
				...options,
				loop: true,
				slidesPerView: 1,
				spaceBetween: 0,
				navigation: {
					prevEl: sliderBlock.querySelector('.reviews__button--prev'),
					nextEl: sliderBlock.querySelector('.reviews__button--next'),
				},
			};
		}

		const swiper = new Swiper(sliderEl, options);

		if (sliderType === 'reviews') {
			initReviewMedia(sliderBlock, swiper);
		}

		// new Swiper(sliderEl, options);
	});
}

window.addEventListener('load', initSliders);