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
	<?php wp_footer(); ?>
	</body>

	</html>