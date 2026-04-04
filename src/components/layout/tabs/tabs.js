import { FLS, slideUp, slideDown, dataMediaQueries, getHash, setHash } from "@js/common/functions.js";
import "./tabs.scss";

export function tabs() {
	const tabs = document.querySelectorAll('[data-fls-tabs]');
	let tabsActiveHash = [];

	if (tabs.length > 0) {
		const hash = getHash();

		FLS(`_FLS_TABS_START`, tabs.length);

		if (hash && hash.startsWith('tab-')) {
			tabsActiveHash = hash.replace('tab-', '').split('-');
		}

		tabs.forEach((tabsBlock, index) => {
			if (tabsBlock.dataset.tabsReady === 'true') return;

			tabsBlock.classList.add('--tab-init');
			tabsBlock.setAttribute('data-fls-tabs-index', index);
			tabsBlock.dataset.tabsReady = 'true';
			tabsBlock.addEventListener("click", setTabsAction);

			initTabs(tabsBlock);
		});

		let mdQueriesArray = dataMediaQueries(tabs, "flsTabs");
		if (mdQueriesArray && mdQueriesArray.length) {
			mdQueriesArray.forEach(mdQueriesItem => {
				mdQueriesItem.matchMedia.addEventListener("change", function () {
					setTitlePosition(mdQueriesItem.itemsArray, mdQueriesItem.matchMedia);
				});
				setTitlePosition(mdQueriesItem.itemsArray, mdQueriesItem.matchMedia);
			});
		}
	}

	function setTitlePosition(tabsMediaArray, matchMedia) {
		tabsMediaArray.forEach(tabsMediaItem => {
			tabsMediaItem = tabsMediaItem.item;
			let tabsTitles = tabsMediaItem.querySelector('[data-fls-tabs-titles]');
			let tabsTitleItems = tabsMediaItem.querySelectorAll('[data-fls-tabs-title]');
			let tabsContent = tabsMediaItem.querySelector('[data-fls-tabs-body]');
			let tabsContentItems = tabsMediaItem.querySelectorAll('[data-fls-tabs-item]');

			tabsTitleItems = Array.from(tabsTitleItems).filter(item => item.closest('[data-fls-tabs]') === tabsMediaItem);
			tabsContentItems = Array.from(tabsContentItems).filter(item => item.closest('[data-fls-tabs]') === tabsMediaItem);

			tabsContentItems.forEach((tabsContentItem, index) => {
				if (matchMedia.matches) {
					tabsContent.append(tabsTitleItems[index]);
					tabsContent.append(tabsContentItem);
					tabsMediaItem.classList.add('--tab-spoller');
				} else {
					tabsTitles.append(tabsTitleItems[index]);
					tabsMediaItem.classList.remove('--tab-spoller');
				}
			});
		});
	}

	function initTabs(tabsBlock) {
		let tabsTitles = tabsBlock.querySelectorAll('[data-fls-tabs-titles]>*');
		let tabsContent = tabsBlock.querySelectorAll('[data-fls-tabs-body]>*');
		const tabsBlockIndex = tabsBlock.dataset.flsTabsIndex;
		const tabsActiveHashBlock = tabsActiveHash[0] == tabsBlockIndex;

		if (tabsActiveHashBlock) {
			const tabsActiveTitle = tabsBlock.querySelector('[data-fls-tabs-titles]>.--tab-active');
			if (tabsActiveTitle) {
				tabsActiveTitle.classList.remove('--tab-active');
			}
		}

		if (tabsContent.length) {
			tabsContent.forEach((tabsContentItem, index) => {
				tabsTitles[index].setAttribute('data-fls-tabs-title', '');
				tabsContentItem.setAttribute('data-fls-tabs-item', '');

				if (tabsActiveHashBlock && index == tabsActiveHash[1]) {
					tabsTitles[index].classList.add('--tab-active');
				}

				tabsContentItem.hidden = !tabsTitles[index].classList.contains('--tab-active');
			});
		}

		const activeTitle = tabsBlock.querySelector('[data-fls-tabs-title].--tab-active');
		if (activeTitle) {
			loadTabGallery(activeTitle, tabsBlock);
			loadTabImages(activeTitle, tabsBlock);
		}
	}

	function loadTabGallery(tabTitle, tabsBlock) {
		const tabsTitles = Array.from(tabsBlock.querySelectorAll('[data-fls-tabs-title]')).filter(
			item => item.closest('[data-fls-tabs]') === tabsBlock
		);
		const tabsContent = Array.from(tabsBlock.querySelectorAll('[data-fls-tabs-item]')).filter(
			item => item.closest('[data-fls-tabs]') === tabsBlock
		);

		const tabIndex = tabsTitles.indexOf(tabTitle);
		if (tabIndex === -1 || !tabsContent[tabIndex]) return;

		const currentBody = tabsContent[tabIndex];
		const gallery = currentBody.querySelector('[data-fls-gallery]');
		const template = currentBody.querySelector('.gallery-tab-template');

		if (!gallery || !template) return;
		if (gallery.dataset.galleryLoaded === 'true') return;

		gallery.append(template.content.cloneNode(true));
		gallery.dataset.galleryLoaded = 'true';

		document.dispatchEvent(new CustomEvent('galleryTabLoaded', {
			detail: { gallery }
		}));
	}

	function loadTabImages(tabTitle, tabsBlock) {
		const tabsTitles = Array.from(tabsBlock.querySelectorAll('[data-fls-tabs-title]')).filter(
			item => item.closest('[data-fls-tabs]') === tabsBlock
		);
		const tabsContent = Array.from(tabsBlock.querySelectorAll('[data-fls-tabs-item]')).filter(
			item => item.closest('[data-fls-tabs]') === tabsBlock
		);

		const tabIndex = tabsTitles.indexOf(tabTitle);
		if (tabIndex === -1 || !tabsContent[tabIndex]) return;

		const currentBody = tabsContent[tabIndex];

		const lazySources = currentBody.querySelectorAll('source[data-srcset]');
		lazySources.forEach((source) => {
			source.setAttribute('srcset', source.dataset.srcset);
			source.removeAttribute('data-srcset');
		});

		const lazyImages = currentBody.querySelectorAll('img[data-src], img[data-srcset]');
		lazyImages.forEach((img) => {
			if (img.dataset.src) {
				img.setAttribute('src', img.dataset.src);
				img.removeAttribute('data-src');
			}

			if (img.dataset.srcset) {
				img.setAttribute('srcset', img.dataset.srcset);
				img.removeAttribute('data-srcset');
			}

			if (img.decode) {
				img.decode().catch(() => { });
			}
		});
	}

	function setTabsStatus(tabsBlock) {
		let tabsTitles = tabsBlock.querySelectorAll('[data-fls-tabs-title]');
		let tabsContent = tabsBlock.querySelectorAll('[data-fls-tabs-item]');
		const tabsBlockIndex = tabsBlock.dataset.flsTabsIndex;

		function isTabsAnimate(tabsBlock) {
			if (tabsBlock.hasAttribute('data-fls-tabs-animate')) {
				return tabsBlock.dataset.flsTabsAnimate > 0 ? Number(tabsBlock.dataset.flsTabsAnimate) : 500;
			}
		}

		const tabsBlockAnimate = isTabsAnimate(tabsBlock);

		if (tabsContent.length > 0) {
			const isHash = tabsBlock.hasAttribute('data-fls-tabs-hash');
			tabsContent = Array.from(tabsContent).filter(item => item.closest('[data-fls-tabs]') === tabsBlock);
			tabsTitles = Array.from(tabsTitles).filter(item => item.closest('[data-fls-tabs]') === tabsBlock);

			tabsContent.forEach((tabsContentItem, index) => {
				if (tabsTitles[index].classList.contains('--tab-active')) {
					if (tabsBlockAnimate) {
						slideDown(tabsContentItem, tabsBlockAnimate);
					} else {
						tabsContentItem.hidden = false;
					}

					if (isHash && !tabsContentItem.closest('.popup')) {
						setHash(`tab-${tabsBlockIndex}-${index}`);
					}
				} else {
					if (tabsBlockAnimate) {
						slideUp(tabsContentItem, tabsBlockAnimate);
					} else {
						tabsContentItem.hidden = true;
					}
				}
			});
		}
	}

	function setTabsAction(e) {
		const el = e.target;

		if (el.closest('[data-fls-tabs-title]')) {
			const tabTitle = el.closest('[data-fls-tabs-title]');
			const tabsBlock = tabTitle.closest('[data-fls-tabs]');

			if (!tabTitle.classList.contains('--tab-active') && !tabsBlock.querySelector('.--slide')) {
				let tabActiveTitle = tabsBlock.querySelectorAll('[data-fls-tabs-title].--tab-active');
				tabActiveTitle = Array.from(tabActiveTitle).filter(item => item.closest('[data-fls-tabs]') === tabsBlock);

				if (tabActiveTitle.length) {
					tabActiveTitle[0].classList.remove('--tab-active');
				}

				tabTitle.classList.add('--tab-active');

				loadTabGallery(tabTitle, tabsBlock);
				loadTabImages(tabTitle, tabsBlock);
				setTabsStatus(tabsBlock);
			}

			e.preventDefault();
		}
	}
}

window.addEventListener('load', tabs);