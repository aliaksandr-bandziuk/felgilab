<?php

get_header();

// Текущий язык
$current_lang = function_exists('pll_current_language') ? pll_current_language() : 'pl';

// Разрешённые языки
$allowed_langs = ['pl', 'en', 'ru', 'uk'];
if (!in_array($current_lang, $allowed_langs, true)) {
	$current_lang = 'pl';
}

// Переводы
$t = [
	'pretitle' => [
		'pl' => 'Błąd 404',
		'en' => 'Error 404',
		'ru' => 'Ошибка 404',
		'uk' => 'Помилка 404',
	],
	'title' => [
		'pl' => 'Przepraszamy,',
		'en' => 'We apologize,',
		'ru' => 'Извините,',
		'uk' => 'Вибачте,',
	],
	'text' => [
		'pl' => 'ale ta strona zniknęła w czarnej dziurze.',
		'en' => 'but this page has vanished into a black hole.',
		'ru' => 'но эта страница исчезла в чёрной дыре.',
		'uk' => 'але ця сторінка зникла у чорній дірі.',
	],
	'back' => [
		'pl' => 'Wróć',
		'en' => 'Go Back',
		'ru' => 'Назад',
		'uk' => 'Назад',
	],
	'home' => [
		'pl' => 'Strona główna',
		'en' => 'Home',
		'ru' => 'Главная',
		'uk' => 'Головна',
	],
];
?>

<main class="page">
	<section class="not-found">
		<div class="not-found__container">
			<div class="not-found__wrapper">
				<div class="not-found__content">

					<p class="not-found__pretitle">
						<?php echo esc_html($t['pretitle'][$current_lang]); ?>
					</p>

					<h1 class="not-found__title">
						<?php echo esc_html($t['title'][$current_lang]); ?>
					</h1>

					<p class="not-found__text">
						<?php echo esc_html($t['text'][$current_lang]); ?>
					</p>

					<div class="not-found__buttons mt60">
						<a href="#" onclick="history.back(); return false;" class="button-primary link-404">
							<span><?php echo esc_html($t['back'][$current_lang]); ?></span>
						</a>

						<a href="<?php echo esc_url(home_url('/')); ?>" class="button-primary link-404">
							<span><?php echo esc_html($t['home'][$current_lang]); ?></span>
						</a>
					</div>

				</div>

				<div class="not-found__image">
					<div class="lost-image">
						<div class="lost-image__base">
							<svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80" fill="none">
								<path d="M80 40C80 62.092 62.092 80 40 80C17.908 80 0 62.092 0 40C0 17.908 17.908 0 40 0C62.092 0 80 17.908 80 40Z" fill="none" />
							</svg>
						</div>
						<div class="lost-image__above">
							<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
								<path opacity="0.3" d="M27.4517 27.4517C35.6833 19.2201 39.0183 9.21172 34.9033 5.09672C30.7883 0.980054 20.78 4.31672 12.5483 12.5467C4.31668 20.7801 0.981681 30.7884 5.09668 34.9034C9.21335 39.0201 19.2217 35.6817 27.4517 27.4517Z" fill="black" />
								<path opacity="0.3" d="M12.5483 27.4517C4.31668 19.2217 0.981681 9.21172 5.09668 5.09672C9.21168 0.980054 19.22 4.31672 27.4517 12.5467C35.6833 20.7801 39.0183 30.7884 34.9033 34.9034C30.7867 39.0201 20.7783 35.6817 12.5483 27.4517Z" fill="black" />
								<path d="M24.1666 19.9999C24.1666 21.105 23.7276 22.1648 22.9462 22.9462C22.1648 23.7276 21.105 24.1666 19.9999 24.1666C18.8948 24.1666 17.835 23.7276 17.0536 22.9462C16.2722 22.1648 15.8333 21.105 15.8333 19.9999C15.8333 18.8948 16.2722 17.835 17.0536 17.0536C17.835 16.2722 18.8948 15.8333 19.9999 15.8333C21.105 15.8333 22.1648 16.2722 22.9462 17.0536C23.7276 17.835 24.1666 18.8948 24.1666 19.9999Z" fill="black" />
							</svg>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>