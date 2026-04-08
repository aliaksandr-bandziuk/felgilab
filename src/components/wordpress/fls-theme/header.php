<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package FLS
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta name="robots" content="noindex">
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="google-site-verification" content="JWfOx5kWt22-1CUSHB6SooXw8KgGcgwhoAjkmmuWNkg" />
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<!-- Google Tag Manager -->
	<script>
		(function(w, d, s, l, i) {
			w[l] = w[l] || [];
			w[l].push({
				'gtm.start': new Date().getTime(),
				event: 'gtm.js'
			});
			var f = d.getElementsByTagName(s)[0],
				j = d.createElement(s),
				dl = l != 'dataLayer' ? '&l=' + l : '';
			j.async = true;
			j.src =
				'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
			f.parentNode.insertBefore(j, f);
		})(window, document, 'script', 'dataLayer', 'GTM-PXHSGB3');
	</script>
	<!-- End Google Tag Manager -->

	<!-- critical css -->
	<style>
		body {
			margin: 0;
		}

		.header {
			position: relative;
			z-index: 50;
		}

		.header__wrapper {
			width: 100%;
		}

		.menu__wrapper {
			display: flex;
			justify-content: space-between;
			align-items: center;
		}

		.main-hero__body {
			position: relative;
			z-index: 2;
		}

		.main-hero__title {
			color: #fff;
		}

		.main-hero__pretitle {
			color: #fff;
		}

		.main-btn {
			padding: 15px;
			display: inline-flex;
		}
	</style>
	<!-- end critical css -->

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<!-- Google Tag Manager (noscript) -->
	<noscript>
		<iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PXHSGB3"
			height="0" width="0" style="display:none;visibility:hidden"></iframe>
	</noscript>
	<!-- End Google Tag Manager (noscript) -->

	<div id="page" class="wrapper">


		<header class="header" id="siteHeader">
			<!-- продумать, где разместить preheader в админке -->
			<div class="preheader" id="sitePreheader">
				<div class="preheader__container">
					<div class="preheader__wrapper">
						<div class="preheader-item preheader__address">
							<span>
								<svg class="svg-inline svg-inline--map" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="map-marker-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
									<path fill="#fd6b1c" d="M172.268 501.67C26.97 291.031 0 269.413 0 192 0 85.961 85.961 0 192 0s192 85.961 192 192c0 77.413-26.97 99.031-172.268 309.67-9.535 13.774-29.93 13.773-39.464 0zM192 272c44.183 0 80-35.817 80-80s-35.817-80-80-80-80 35.817-80 80 35.817 80 80 80z"></path>
								</svg>
							</span>
							<span>05-090, Falencka 19, Falenty Nowe</span>
						</div>
						<div class="preheader-item preheader__workhours">
							<span>
								<svg class="svg-inline svg-inline--clock" aria-hidden="true" focusable="false" data-prefix="far" data-icon="clock" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
									<path fill="#fd6b1c" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm61.8-104.4l-84.9-61.7c-3.1-2.3-4.9-5.9-4.9-9.7V116c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v141.7l66.8 48.6c5.4 3.9 6.5 11.4 2.6 16.8L334.6 349c-3.9 5.3-11.4 6.5-16.8 2.6z"></path>
								</svg>
							</span>
							<span>Godziny otwarcia: Po—Pi: 8.00 - 17.00 | So: 9.00 - 13.00</span>
						</div>
						<div class="preheader-item preheader__status">
							<div class="indicator-parent">
								<div class="indicator">
									<div class="indicator__marker"></div>
									<div class="indicator__text">Online</div>
								</div>
								<div class="work-info">
									<p class="work-info__start"></p>
									<p class="work-info__end"></p>
								</div>
							</div>
						</div>
						<div class="preheader-item preheader__lang">
							<div id="languageDropdown" class="language-dropdown">
								<div class="language-dropdown__wrapper">
									<button id="languageBtn" class="language-btn">
										<?php echo strtoupper(pll_current_language('slug')); ?>
									</button>
									<span id="arrowIcon" class="arrow-icon">
										<svg xmlns="http://www.w3.org/2000/svg" width="10" height="20" viewBox="0 0 10 20" fill="none">
											<path d="M1 9L4.64645 12.6464C4.84171 12.8417 5.15829 12.8417 5.35355 12.6464L9 9" stroke-linecap="round" />
										</svg>
									</span>
								</div>
								<ul class="language-list" id="languageList">
									<?php
									function get_excluded_languages()
									{
										return ['it', 'fr']; // hide Italian and French languages
									}
									$languages = pll_the_languages(['raw' => 1]);
									$current_language = pll_current_language('slug');
									$excluded_languages = get_excluded_languages();

									foreach ($languages as $language) {
										if ($language['slug'] !== $current_language && !in_array($language['slug'], $excluded_languages)) {
											echo '<li><a href="' . esc_url($language['url']) . '">' . strtoupper($language['slug']) . '</a></li>';
										}
									}
									?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="header__placeholder" id="headerPlaceholder"></div>
			<div class="header__wrapper" id="headerWrapper">
				<div class="header__container relative">
					<div class="header__menu menu">
						<div class="burger-bg" data-fls-menu>
							<button type="button" class="menu__icon icon-menu" aria-label="Toggle Burger Menu"><span></span></button>
						</div>
						<div class="menu__wrapper">
							<div class="header-logo">
								<a href="<?php echo get_home_url(); ?>" class="header-logo__link">
									<img src="<?php
														$custom_logo__url = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full');
														echo $custom_logo__url[0];
														?>" alt="Felgilab" class="logo-image" width="150" height="150">
								</a>
							</div>
							<div class="mobile-phone-link">
								<a href="tel:+48739103744">739 103 744</a>
							</div>
							<div class="header-elements">
								<nav class="menu__body">
									<div class="nav__wrapper">
										<?php
										if (function_exists('pll_current_language')) {
											$current_language = pll_current_language();
											$menu_slug = '';

											switch ($current_language) {
												case 'en':
													$menu_slug = 'english-menu';
													break;
												case 'pl':
													$menu_slug = 'polish-menu';
													break;
												case 'ru':
													$menu_slug = 'russian-menu';
													break;
												case 'uk':
													$menu_slug = 'ukranian-menu';
													break;
											}

											$menu = wp_get_nav_menu_object($menu_slug);

											if ($menu) {
												$menu_items = wp_get_nav_menu_items($menu->term_id);
												$menu_items_by_parent = array();

												foreach ($menu_items as $menu_item) {
													$menu_items_by_parent[$menu_item->menu_item_parent][] = $menu_item;
												}

												function display_menu_items($parent_id, $menu_items_by_parent)
												{
													if (!isset($menu_items_by_parent[$parent_id])) {
														return;
													}

													$is_submenu = $parent_id !== 0;
													$ul_class   = $is_submenu ? 'menu__sub-list' : 'menu__list';
													$link_class = $is_submenu ? 'menu__sub-link' : 'menu__link';

													echo '<ul class="' . esc_attr($ul_class) . '">';

													foreach ($menu_items_by_parent[$parent_id] as $menu_item) {
														$is_anchor         = strpos($menu_item->url, '#') !== false;
														$has_submenu       = isset($menu_items_by_parent[$menu_item->ID]);
														$is_active         = felgilab_is_menu_item_active($menu_item->url);
														$has_active_child  = $has_submenu ? felgilab_menu_item_has_active_child($menu_item->ID, $menu_items_by_parent) : false;

														$link_class_final = $link_class . ($is_anchor ? ' anchor-link' : '');
														if ($is_active) {
															$link_class_final .= ' is-active';
														}

														$item_class = $is_submenu ? 'menu__sub-item' : 'menu__item';

														if ($has_submenu && !$is_submenu) {
															$item_class .= ' menu__has-submenu';
														}

														if ($is_active) {
															$item_class .= ' is-active';
														}

														if ($has_active_child) {
															$item_class .= ' is-active-parent';
														}

														echo '<li class="' . esc_attr($item_class) . '">';

														echo '<a href="' . esc_url($menu_item->url) . '" class="' . esc_attr($link_class_final) . '"' . ($is_anchor ? ' data-scroll' : '') . ($is_active ? ' aria-current="page"' : '') . '>';
														echo esc_html($menu_item->title);

														if ($has_submenu) {
															echo '<svg class="menu__arrow" width="10" height="5" viewBox="7 10 10 5" fill="none" xmlns="http://www.w3.org/2000/svg">';
															echo '<path d="M17 10.5L12 14.5" stroke="#151618" stroke-width="1.25" stroke-linecap="round" />';
															echo '<path d="M12 14.5L7 10.5" stroke="#151618" stroke-width="1.25" stroke-linecap="round" />';
															echo '</svg>';
														}

														echo '</a>';

														if ($has_submenu) {
															display_menu_items($menu_item->ID, $menu_items_by_parent);
														}

														echo '</li>';
													}

													echo '</ul>';
												}

												display_menu_items(0, $menu_items_by_parent);
											}
										}
										?>
										<div class="menu__mob-btn">
											<a href="tel:+48739103744" class="mob-menu-button">
												<span class="--icon-ico-callback ico-callback-header"></span>
												<div class="mob-menu-content">
													<span class="mob-menu-content__text">
														<?php echo pll_current_language() == 'pl' ? 'Uzyskać wycenę' : (pll_current_language() == 'ru' ? 'Получить предложение' : (pll_current_language() == 'uk' ? 'Отримати пропозицію' : 'Get quote')); ?>
													</span>
													<span class="mob-menu-content__phone">739 103 744</span>
												</div>
											</a>
										</div>
									</div>
								</nav>
								<div class="header-buttons">
									<button data-fls-popup-link="popup-order" class="header-popup-button" type="button" aria-label="Open Order Popup">
										<span class="--icon-ico-callback ico-callback-header"></span>
										<div class="header-button-content">
											<span class="header-button-content__text">
												<?php echo pll_current_language() == 'pl' ? 'Uzyskać wycenę' : (pll_current_language() == 'ru' ? 'Получить предложение' : (pll_current_language() == 'uk' ? 'Отримати пропозицію' : 'Get quote')); ?>
											</span>
											<a class="header-button-content__phone" href="tel:+48739103744">739 103 744</a>
										</div>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>

		<?php
		$current_lang = function_exists('pll_current_language') ? pll_current_language() : 'pl';
		$lang = in_array($current_lang, ['pl', 'en', 'ru', 'uk'], true) ? $current_lang : 'pl';

		$popup_title = [
			'pl' => 'Skontaktuj się z nami',
			'en' => 'Contact us',
			'ru' => 'Свяжитесь с нами',
			'uk' => 'Зв’яжіться з нами',
		];

		$popup_description = [
			'pl' => 'Masz pytanie lub chcesz otrzymać wycenę? Wypełnij formularz, a odpowiemy tak szybko, jak to możliwe.',
			'en' => 'Have a question or want to get a quote? Fill out the form and we will get back to you as soon as possible.',
			'ru' => 'Есть вопрос или хотите получить оценку? Заполните форму, и мы ответим вам как можно скорее.',
			'uk' => 'Маєте запитання або хочете отримати оцінку? Заповніть форму, і ми відповімо вам якомога швидше.',
		];

		$popup_button_text = [
			'pl' => 'Wyślij formularz',
			'en' => 'Send form',
			'ru' => 'Отправить форму',
			'uk' => 'Надіслати форму',
		];

		$popup_i18n = [
			'name' => [
				'pl' => 'Imię',
				'en' => 'Name',
				'ru' => 'Имя',
				'uk' => 'Ім’я',
			],
			'phone' => [
				'pl' => 'Telefon',
				'en' => 'Phone',
				'ru' => 'Телефон',
				'uk' => 'Телефон',
			],
			'message' => [
				'pl' => 'Opisz problem z felgami (nieobowiązkowo)',
				'en' => 'Describe the problem with the wheels (optional)',
				'ru' => 'Опишите проблему с дисками (необязательно)',
				'uk' => 'Опишіть проблему з дисками (необов’язково)',
			],
			'message_placeholder' => [
				'pl' => 'np. rysa na rancie, skrzywienie, odpryski lakieru',
				'en' => 'e.g. curb rash, bent wheel, paint damage',
				'ru' => 'например: царапина на ободе, искривление, повреждение краски',
				'uk' => 'наприклад: подряпина на ободі, викривлення, пошкодження фарби',
			],
			'upload' => [
				'pl' => 'Dodaj zdjęcia uszkodzonych felg',
				'en' => 'Add photos of damaged wheels',
				'ru' => 'Добавьте фото повреждённых дисков',
				'uk' => 'Додайте фото пошкоджених дисків',
			],
			'upload_note' => [
				'pl' => 'Możesz dodać kilka zdjęć (JPG, PNG, WebP).',
				'en' => 'You can add several photos (JPG, PNG, WebP).',
				'ru' => 'Можно добавить несколько фото (JPG, PNG, WebP).',
				'uk' => 'Можна додати кілька фото (JPG, PNG, WebP).',
			],
		];
		?>

		<div id="popup-order" data-fls-popup="popup-order" aria-hidden="true" class="popup popup-order">
			<div data-fls-popup-wrapper class="popup__wrapper">
				<div data-fls-popup-body class="popup__body popup-order__content">
					<button data-fls-popup-close type="button" class="popup-order__close">
						<svg class="svg-icon" aria-hidden="true" role="img" focusable="false" width="24" height="24" viewBox="0 0 24 24" fill="#fff" xmlns="http://www.w3.org/2000/svg">
							<path d="M12.2218 13.6066L20 21.3848L21.4142 19.9706L13.636 12.1924L21.3848 4.44366L19.9706 3.02945L12.2218 10.7782L4.44365 3L3.02944 4.41421L10.8076 12.1924L3 20L4.41421 21.4142L12.2218 13.6066Z" fill="#fff"></path>
						</svg>
					</button>

					<div data-fls-popup-content class="popup__text">
						<div class="final-contact__inner popup-order__inner">
							<h2 class="h2-white mb20">
								<?php echo esc_html($popup_title[$lang]); ?>
							</h2>

							<div class="about-company__divider mb30">
								<svg xmlns="http://www.w3.org/2000/svg" width="64" height="8" aria-hidden="true">
									<path fill="#fd6b1c" d="M34 0h30v2H34zm0 6h15v2H34zM0 0h30v2H0zm15 6h15v2H15z" />
								</svg>
							</div>

							<form
								action="<?php echo esc_url(get_template_directory_uri() . '/sendmail.php'); ?>"
								method="post"
								autocomplete="off"
								class="small-form form-sending"
								enctype="multipart/form-data">

								<input type="hidden" name="page_url" value="">
								<input type="hidden" name="form_name" value="Popup order">

								<div class="input-container">
									<input id="popup-name" type="text" name="name" class="input-contact" />
									<label for="popup-name"><?php echo esc_html($popup_i18n['name'][$lang]); ?></label>
									<span><?php echo esc_html($popup_i18n['name'][$lang]); ?></span>
								</div>

								<div class="input-container">
									<input id="popup-phone" type="tel" name="phone" class="input-contact" />
									<label for="popup-phone"><?php echo esc_html($popup_i18n['phone'][$lang]); ?></label>
									<span><?php echo esc_html($popup_i18n['phone'][$lang]); ?></span>
								</div>

								<div class="input-container textarea">
									<textarea
										id="popup-message"
										name="message"
										class="input-contact"
										placeholder="<?php echo esc_attr($popup_i18n['message_placeholder'][$lang]); ?>"></textarea>
									<label for="popup-message"><?php echo esc_html($popup_i18n['message'][$lang]); ?></label>
									<span><?php echo esc_html($popup_i18n['message'][$lang]); ?></span>
								</div>

								<div class="file-upload">
									<input
										type="file"
										name="wheel_photos[]"
										id="wheel_photos_popup"
										class="input-file"
										accept="image/*"
										multiple />

									<label for="wheel_photos_popup" class="file-label">
										<?php echo esc_html($popup_i18n['upload'][$lang]); ?>
									</label>

									<div class="file-note">
										<?php echo esc_html($popup_i18n['upload_note'][$lang]); ?>
									</div>

									<div class="file-list" id="fileList_popup"></div>
								</div>

								<button type="submit" class="button-primary btn w_btn2" aria-label="<?php echo esc_attr($popup_button_text[$lang]); ?>">
									<?php echo esc_html($popup_button_text[$lang]); ?>
								</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>