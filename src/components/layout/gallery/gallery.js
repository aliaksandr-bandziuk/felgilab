const KEY = '7EC452A9-0CFD441C-BD984C7C-17C8456E';

let lightGalleryModulePromise = null;
let lightGalleryStylesPromise = null;

async function loadLightGalleryAssets() {
	if (!lightGalleryModulePromise) {
		lightGalleryModulePromise = import('lightgallery');
	}

	if (!lightGalleryStylesPromise) {
		lightGalleryStylesPromise = import('./assets/lightgallery.css');
	}

	const [{ default: lightGallery }] = await Promise.all([
		lightGalleryModulePromise,
		lightGalleryStylesPromise,
	]);

	return lightGallery;
}

async function initSingleGallery(gallery) {
	if (!gallery) return;
	if (gallery.dataset.galleryInitialized === 'true') return;
	if (gallery.dataset.galleryInitializing === 'true') return;
	if (!gallery.querySelector('a')) return;

	gallery.dataset.galleryInitializing = 'true';

	try {
		const lightGallery = await loadLightGalleryAssets();

		lightGallery(gallery, {
			licenseKey: KEY,
			selector: 'a',
			speed: 500,
		});

		gallery.dataset.galleryInitialized = 'true';
	} catch (error) {
		console.error('LightGallery init error:', error);
	} finally {
		gallery.removeAttribute('data-gallery-initializing');
	}
}

function observeGalleries() {
	const galleries = document.querySelectorAll('[data-fls-gallery]');
	if (!galleries.length) return;

	const observer = new IntersectionObserver((entries, obs) => {
		entries.forEach((entry) => {
			if (!entry.isIntersecting) return;

			const gallery = entry.target;
			initSingleGallery(gallery);
			obs.unobserve(gallery);
		});
	}, {
		rootMargin: '300px 0px',
		threshold: 0.01,
	});

	galleries.forEach((gallery) => observer.observe(gallery));
}

window.addEventListener('load', observeGalleries);

document.addEventListener('galleryTabLoaded', (e) => {
	const gallery = e.detail?.gallery;
	if (!gallery) return;

	initSingleGallery(gallery);
});