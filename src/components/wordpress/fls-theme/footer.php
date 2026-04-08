	<?php
	// Определяем текущий язык через Polylang
	$current_language = function_exists('pll_current_language') ? pll_current_language() : 'en';

	// Формируем идентификатор опций футера для текущего языка
	$footer_option_id = 'footer_' . $current_language;

	// Все поля футера
	$footer_logo         = get_field('footer_logo', $footer_option_id);
	$footer_description  = get_field('footer_description', $footer_option_id);
	$footer_cta          = get_field('footer_cta', $footer_option_id);
	$footer_socials      = get_field('footer_socials', $footer_option_id);
	$footer_links_first  = get_field('footer_links_first', $footer_option_id);
	$footer_links_second = get_field('footer_links_second', $footer_option_id);
	$footer_contact      = get_field('footer_contact', $footer_option_id);
	$footer_bottom       = get_field('footer_bottom', $footer_option_id);

	// CTA
	$footer_cta_label     = $footer_cta['label'] ?? '';
	$footer_cta_phone_raw = $footer_cta['phone_raw'] ?? '';

	// Форматирование CTA телефона для отображения
	$footer_cta_phone_digits = preg_replace('/\D+/', '', $footer_cta_phone_raw);
	if (strlen($footer_cta_phone_digits) === 11 && strpos($footer_cta_phone_digits, '48') === 0) {
		$footer_cta_phone_digits = substr($footer_cta_phone_digits, 2);
	}
	$footer_cta_phone_display = strlen($footer_cta_phone_digits) === 9
		? trim(chunk_split($footer_cta_phone_digits, 3, ' '))
		: $footer_cta_phone_raw;

	// Первая колонка ссылок
	$footer_links_first_title = $footer_links_first['title'] ?? '';
	$footer_links_first_items = $footer_links_first['items'] ?? [];

	// Вторая колонка ссылок
	$footer_links_second_title = $footer_links_second['title'] ?? '';
	$footer_links_second_items = $footer_links_second['items'] ?? [];

	// Контакты
	$footer_contact_title = $footer_contact['title'] ?? '';

	$footer_phone_box       = $footer_contact['phone_box'] ?? [];
	$footer_phone_label     = $footer_phone_box['label'] ?? '';
	$footer_phone_raw       = $footer_phone_box['phone_raw'] ?? '';

	$footer_phone_digits = preg_replace('/\D+/', '', $footer_phone_raw);
	if (strlen($footer_phone_digits) === 11 && strpos($footer_phone_digits, '48') === 0) {
		$footer_phone_digits = substr($footer_phone_digits, 2);
	}
	$footer_phone_display = strlen($footer_phone_digits) === 9
		? trim(chunk_split($footer_phone_digits, 3, ' '))
		: $footer_phone_raw;

	$footer_hours_box   = $footer_contact['hours_box'] ?? [];
	$footer_hours_label = $footer_hours_box['label'] ?? '';
	$footer_hours_text  = $footer_hours_box['hours_text'] ?? '';

	$footer_email_box   = $footer_contact['email_box'] ?? [];
	$footer_email_label = $footer_email_box['label'] ?? '';
	$footer_email       = $footer_email_box['email'] ?? '';

	// Нижняя часть
	$footer_privacy_label = $footer_bottom['privacy_label'] ?? '';
	$footer_privacy_url   = $footer_bottom['privacy_url'] ?? '';
	?>

	<footer class="footer">
		<div class="footer__container">
			<div class="footer-data">
				<div class="footer-data__wrapper">
					<div class="footer-block">
						<div class="footer-block__wrapper">
							<div class="footer-block__logo">
								<div class="header-logo">
									<a href="<?php echo esc_url(get_home_url()); ?>" class="header-logo__link">
										<?php if (!empty($footer_logo['url'])) : ?>
											<img
												src="<?php echo esc_url($footer_logo['url']); ?>"
												alt="<?php echo esc_attr(!empty($footer_logo['alt']) ? $footer_logo['alt'] : 'Felgilab'); ?>"
												class="logo-image"
												width="<?php echo esc_attr($footer_logo['width'] ?? ''); ?>"
												height="<?php echo esc_attr($footer_logo['height'] ?? ''); ?>">
										<?php endif; ?>
									</a>
								</div>
							</div>

							<?php if ($footer_description) : ?>
								<div class="footer-block__descr">
									<?php echo esc_html($footer_description); ?>
								</div>
							<?php endif; ?>

							<div class="--icon-decor-line-right-accent decor-line-subcolor mb20"></div>

							<?php if ($footer_cta_label || $footer_cta_phone_raw) : ?>
								<div class="footer-block__menu-btn">
									<a href="tel:<?php echo esc_attr($footer_cta_phone_raw); ?>" class="footer-menu-button">
										<span class="--icon-ico-comment ico-callback-header"></span>
										<div class="mob-menu-content">
											<?php if ($footer_cta_label) : ?>
												<span class="mob-menu-content__text">
													<?php echo esc_html($footer_cta_label); ?>
												</span>
											<?php endif; ?>

											<?php if ($footer_cta_phone_display) : ?>
												<span class="mob-menu-content__phone">
													<?php echo esc_html($footer_cta_phone_display); ?>
												</span>
											<?php endif; ?>
										</div>
									</a>
								</div>
							<?php endif; ?>

							<?php if (!empty($footer_socials)) : ?>
								<div class="footer-block__socials">
									<?php foreach ($footer_socials as $social_item) : ?>
										<?php
										$social_icon      = $social_item['icon'] ?? null;
										$social_label     = $social_item['label'] ?? '';
										$social_link_type = $social_item['link_type'] ?? 'url';
										$social_link_value = $social_item['link_value'] ?? '';

										$social_href = '';

										if ($social_link_type === 'email') {
											$social_href = 'mailto:' . $social_link_value;
										} elseif ($social_link_type === 'phone') {
											$social_href = 'tel:' . $social_link_value;
										} else {
											$social_href = $social_link_value;
										}
										?>

										<?php if ($social_icon && $social_href) : ?>
											<a href="<?php echo esc_url($social_href); ?>" class="footer-social-link" aria-label="<?php echo esc_attr($social_label); ?>">
												<img src="<?php echo esc_url($social_icon['url']); ?>" alt="<?php echo esc_attr($social_icon['alt'] ?: $social_label); ?>">
											</a>
										<?php endif; ?>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>

					<div class="footer-block">
						<div class="footer-block__wrapper">
							<?php if ($footer_links_first_title) : ?>
								<div class="footer-block__title"><?php echo esc_html($footer_links_first_title); ?></div>
							<?php endif; ?>

							<div class="--icon-decor-line-right-accent decor-line-subcolor mb20"></div>

							<?php if (!empty($footer_links_first_items)) : ?>
								<ul class="footer-block__list">
									<?php foreach ($footer_links_first_items as $item) : ?>
										<?php
										$item_label = $item['label'] ?? '';
										$item_url   = $item['url'] ?? '';
										?>
										<?php if ($item_label && $item_url) : ?>
											<li class="footer-block__item">
												<a href="<?php echo esc_url($item_url); ?>" class="footer-block__link">
													<?php echo esc_html($item_label); ?>
												</a>
											</li>
										<?php endif; ?>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						</div>
					</div>

					<div class="footer-block">
						<div class="footer-block__wrapper">
							<?php if ($footer_links_second_title) : ?>
								<div class="footer-block__title"><?php echo esc_html($footer_links_second_title); ?></div>
							<?php endif; ?>

							<div class="--icon-decor-line-right-accent decor-line-subcolor mb20"></div>

							<?php if (!empty($footer_links_second_items)) : ?>
								<ul class="footer-block__list">
									<?php foreach ($footer_links_second_items as $item) : ?>
										<?php
										$item_label = $item['label'] ?? '';
										$item_url   = $item['url'] ?? '';
										?>
										<?php if ($item_label && $item_url) : ?>
											<li class="footer-block__item">
												<a href="<?php echo esc_url($item_url); ?>" class="footer-block__link">
													<?php echo esc_html($item_label); ?>
												</a>
											</li>
										<?php endif; ?>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						</div>
					</div>

					<div class="footer-block">
						<div class="footer-block__wrapper">
							<?php if ($footer_contact_title) : ?>
								<div class="footer-block__title"><?php echo esc_html($footer_contact_title); ?></div>
							<?php endif; ?>

							<div class="--icon-decor-line-right-accent decor-line-subcolor mb20"></div>

							<div class="footer-contact-buttons">
								<?php if ($footer_phone_raw) : ?>
									<a href="tel:<?php echo esc_attr($footer_phone_raw); ?>" class="footer-contact-button">
										<span class="--icon-ico-phone24 ico-phone-footer footer-btn-ico"></span>
										<div class="footer-contact-button__content">
											<?php if ($footer_phone_label) : ?>
												<p class="footer-contact-button__descr"><?php echo esc_html($footer_phone_label); ?></p>
											<?php endif; ?>
											<?php if ($footer_phone_display) : ?>
												<p class="footer-contact-button__text"><?php echo esc_html($footer_phone_display); ?></p>
											<?php endif; ?>
										</div>
									</a>
								<?php endif; ?>

								<?php if ($footer_hours_text) : ?>
									<div class="footer-contact-button">
										<span class="--icon-ico-timer ico-timer-footer footer-btn-ico"></span>
										<div class="footer-contact-button__content">
											<?php if ($footer_hours_label) : ?>
												<p class="footer-contact-button__descr"><?php echo esc_html($footer_hours_label); ?></p>
											<?php endif; ?>
											<p class="footer-contact-button__text"><?php echo esc_html($footer_hours_text); ?></p>
										</div>
									</div>
								<?php endif; ?>

								<?php if ($footer_email) : ?>
									<a href="mailto:<?php echo esc_attr($footer_email); ?>" class="footer-contact-button">
										<span class="--icon-ico-mail ico-mail-footer footer-btn-ico"></span>
										<div class="footer-contact-button__content">
											<?php if ($footer_email_label) : ?>
												<p class="footer-contact-button__descr"><?php echo esc_html($footer_email_label); ?></p>
											<?php endif; ?>
											<p class="footer-contact-button__text"><?php echo esc_html($footer_email); ?></p>
										</div>
									</a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="footer-company">
				<div class="footer-company__wrapper">
					<div class="footer-text">
						<?php
						$current_year = date('Y');

						switch ($current_language) {
							case 'pl':
								echo '<p class="footer-text__item">© ' . esc_html($current_year) . ' Felgilab. Wszelkie prawa zastrzeżone.</p>';
								break;
							case 'ru':
								echo '<p class="footer-text__item">© ' . esc_html($current_year) . ' Felgilab. Все права защищены.</p>';
								break;
							case 'uk':
								echo '<p class="footer-text__item">© ' . esc_html($current_year) . ' Felgilab. Всі права захищені.</p>';
								break;
							default:
								echo '<p class="footer-text__item">© ' . esc_html($current_year) . ' Felgilab. All rights reserved.</p>';
								break;
						}
						?>
					</div>

					<?php if ($footer_privacy_label && $footer_privacy_url) : ?>
						<a href="<?php echo esc_url($footer_privacy_url); ?>" class="footer-text__item">
							<?php echo esc_html($footer_privacy_label); ?>
						</a>
					<?php endif; ?>

					<div class="developer-data">
						<p class="developer-data__text">
							<?php
							switch ($current_language) {
								case 'pl':
									echo 'Strona stworzona przez';
									break;
								case 'ru':
									echo 'Сайт разработан';
									break;
								case 'uk':
									echo 'Сайт розроблено';
									break;
								default:
									echo 'Developed by';
									break;
							}
							?>
						</p>
						<a href="https://www.bandziuk.com" target="_blank" class="developer-data__link" rel="noopener noreferrer">Bandziuk</a>
					</div>
				</div>
			</div>
		</div>
	</footer>
	</div>
	<script>
		var currentLang = '<?php echo pll_current_language(); ?>';
	</script>
	<div id="messagePopup" class="message-popup-form" style="display: none;">
		<div class="message-popup-form-content">
			<span class="close-popup-form-button" onclick="document.getElementById('messagePopup').style.display='none'">&times;</span>
			<div class="order-content">
				<p id="popupTitle" class="order-content__title">Ваше сообщение здесь</p>
				<p id="popupMessage" class="order-content__subtitle">Ваше сообщение здесь</p>
			</div>
		</div>
	</div>

	<?php
	$current_lang = function_exists('pll_current_language') ? pll_current_language() : 'pl';
	$lang = in_array($current_lang, ['pl', 'en', 'ru', 'uk'], true) ? $current_lang : 'pl';

	$cookie_i18n = [
		'text' => [
			'pl' => 'Używamy plików cookies, aby zapewnić prawidłowe działanie strony oraz analizować ruch. Możesz zaakceptować lub odrzucić dodatkowe cookies.',
			'en' => 'We use cookies to ensure proper website operation and to analyze traffic. You can accept or reject additional cookies.',
			'ru' => 'Мы используем cookies, чтобы сайт работал корректно и для анализа трафика. Вы можете принять или отклонить дополнительные cookies.',
			'uk' => 'Ми використовуємо cookies, щоб сайт працював коректно та для аналізу трафіку. Ви можете прийняти або відхилити додаткові cookies.',
		],
		'accept' => [
			'pl' => 'Akceptuję',
			'en' => 'Accept',
			'ru' => 'Принять',
			'uk' => 'Прийняти',
		],
		'decline' => [
			'pl' => 'Odrzucam',
			'en' => 'Decline',
			'ru' => 'Отклонить',
			'uk' => 'Відхилити',
		],
		'policy' => [
			'pl' => 'Polityka prywatności',
			'en' => 'Privacy Policy',
			'ru' => 'Политика конфиденциальности',
			'uk' => 'Політика конфіденційності',
		],
	];

	$privacy_page_url = 'https://felgilab.pl/polityka-prywatnosci/';
	?>

	<div class="cookie-banner" id="cookie-banner" hidden>
		<div class="cookie-banner__inner">
			<p class="cookie-banner__text">
				<?php echo esc_html($cookie_i18n['text'][$lang]); ?>
				<a href="<?php echo esc_url($privacy_page_url); ?>">
					<?php echo esc_html($cookie_i18n['policy'][$lang]); ?>
				</a>
			</p>

			<div class="cookie-banner__actions">
				<button type="button" class="cookie-banner__button cookie-banner__button--accept" id="cookie-accept">
					<?php echo esc_html($cookie_i18n['accept'][$lang]); ?>
				</button>

				<button type="button" class="cookie-banner__button cookie-banner__button--decline" id="cookie-decline">
					<?php echo esc_html($cookie_i18n['decline'][$lang]); ?>
				</button>
			</div>
		</div>
	</div>

	<?php wp_footer(); ?>
	<?php
	$lang = function_exists('pll_current_language') ? pll_current_language() : 'pl';

	$texts = [
		'pl' => 'Dzień dobry, interesuje mnie renowacja felg',
		'en' => 'Hello, I am interested in wheel refurbishment',
		'ru' => 'Здравствуйте, интересует ремонт дисков',
		'uk' => 'Добрий день, цікавить ремонт дисків',
	];

	$text = urlencode($texts[$lang] ?? $texts['pl']);
	?>
	<a href="https://wa.me/48514716916?text=<?php echo $text; ?>"
		class="whatsapp-button"
		target="_blank"
		rel="noopener nofollow"
		aria-label="Contact us on WhatsApp">

		<svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
			<path d="M20.52 3.48A11.8 11.8 0 0 0 12.02 0C5.38 0 .02 5.36.02 12c0 2.12.56 4.2 1.63 6.04L0 24l6.18-1.6A11.96 11.96 0 0 0 12.02 24c6.64 0 12-5.36 12-12 0-3.2-1.25-6.22-3.5-8.52zM12.02 21.82c-1.8 0-3.56-.48-5.1-1.4l-.36-.22-3.66.95.98-3.56-.24-.37a9.8 9.8 0 0 1-1.5-5.22c0-5.44 4.44-9.88 9.88-9.88 2.64 0 5.12 1.03 6.98 2.9a9.8 9.8 0 0 1 2.9 6.98c0 5.44-4.44 9.88-9.88 9.88zm5.44-7.36c-.3-.15-1.76-.87-2.04-.96-.27-.1-.47-.15-.67.15-.2.3-.77.96-.95 1.16-.17.2-.35.22-.65.07-.3-.15-1.28-.47-2.44-1.5-.9-.8-1.5-1.8-1.68-2.1-.17-.3-.02-.46.13-.6.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.6-.92-2.2-.24-.58-.48-.5-.67-.5h-.57c-.2 0-.52.07-.8.37-.27.3-1.05 1.02-1.05 2.5s1.08 2.9 1.23 3.1c.15.2 2.13 3.25 5.16 4.55.72.3 1.28.48 1.72.62.72.23 1.38.2 1.9.12.58-.1 1.76-.72 2.02-1.42.25-.7.25-1.3.17-1.42-.07-.12-.27-.2-.57-.35z" />
		</svg>
	</a>
	</body>

	</html>