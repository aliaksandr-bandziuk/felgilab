<?php

/**
 * FLS functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package FLS
 */

//------------------------------------
// Підключення матеріалів
// не видаляти
//------------------------------------
require_once 'inc/assets-include.php';
//------------------------------------

if (! defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function fls_setup()
{
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on FLS, use a find and replace
		* to change 'fls' to the name of your theme in all the template files.
		*/
	load_theme_textdomain('fls', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support('title-tag');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'fls'),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'fls_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	add_theme_support('wp-block-styles'); // Поддержка стилей блоков
	add_theme_support('align-wide'); // Поддержка широкого выравнивания блоков
	add_theme_support('editor-styles'); // Подключение стилей редактора блоков
	add_editor_style(); // Подключение стилей для редактора
	add_image_size('hero-main', 1600, 0, false); // Размер для главного изображения в блоке Hero
	add_image_size('hero-mobile', 768, 0, false); // Размер для главного изображения в блоке Hero на мобильных устройствах
	add_image_size('portfolio-card', 600, 400, true); // Размер для изображений в карточках портфолио
	add_image_size('gallery-grid', 800, 600, true); // Размер для изображений в галерее
	add_image_size('gallery-grid-home', 520, 390, true); // Размер для изображений в галерее на главной странице
	add_image_size('before-after-main', 1400, 0, false); // Размер для изображений в блоке "До и После"
	add_image_size('service-card', 700, 460, true); // Размер для изображений в карточках услуг
	add_image_size('service-card-small', 420, 276, true); // Размер для изображений в карточках услуг на мобильных устройствах
	add_image_size('review-gallery', 720, 540, true); // Размер для изображений в галерее отзывов
	add_image_size('main-logo', 300, 0, false); // Размер для главного логотипа в шапке
}
add_action('after_setup_theme', 'fls_setup');

add_action('wp_head', function () {
?>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link
		rel="preload"
		as="style"
		href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;500;600;700;800&display=swap"
		onload="this.onload=null;this.rel='stylesheet'">
	<noscript>
		<link
			rel="stylesheet"
			href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;500;600;700;800&display=swap">
	</noscript>
<?php
}, 1);

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function fls_content_width()
{
	$GLOBALS['content_width'] = apply_filters('fls_content_width', 640);
}
add_action('after_setup_theme', 'fls_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function fls_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'fls'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'fls'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'fls_widgets_init');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if (class_exists('WooCommerce')) {
	require get_template_directory() . '/inc/woocommerce.php';
}

// Можливість завантажувати SVG
function my_own_mime_types($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'my_own_mime_types');

// Перевірка на наявність плагіну
if (!function_exists('get_fls_field')) {
	function get_fls_field($field_name, $post_id = false, $default = null)
	{
		if (!function_exists('get_field')) {
			return $default;
		}
		$value = get_field($field_name, $post_id);
		return $value !== null ? $value : $default;
	}
}
if (!function_exists('get_fls_fields')) {
	function get_fls_fields($post_id = false, $default = null)
	{
		if (!function_exists('get_fields')) {
			return $default;
		}
		$value = get_fields($post_id);
		return $value !== null ? $value : $default;
	}
}

/**
 * Enqueue scripts and styles for admin.
 */
function fls_admin_scripts()
{
	wp_enqueue_style('fls-admin-styles', get_template_directory_uri() . '/style-admin.css', array(), _S_VERSION);
}
add_action('admin_enqueue_scripts', 'fls_admin_scripts');

// Advanced Custom Fields Start
// Advanced Custom Fields: multilingual footer options
add_action('acf/init', 'felgilab_register_footer_options');

function felgilab_register_footer_options()
{
	if (!function_exists('acf_add_options_page') || !function_exists('pll_languages_list')) {
		return;
	}

	$parent = acf_add_options_page([
		'page_title' => 'Footer',
		'menu_title' => 'Footer',
		'menu_slug'  => 'footer-settings',
		'capability' => 'manage_options',
		'redirect'   => true,
		'position'   => 30,
		'icon_url'   => 'dashicons-editor-kitchensink',
	]);

	$languages = pll_languages_list();

	foreach ($languages as $lang) {
		acf_add_options_sub_page([
			'page_title'  => sprintf('Footer (%s)', strtoupper($lang)),
			'menu_title'  => strtoupper($lang),
			'menu_slug'   => 'footer-' . $lang,
			'parent_slug' => 'footer-settings',
			'capability'  => 'manage_options',
			'post_id'     => 'footer_' . $lang,
		]);
	}
}

add_action('acf/init', 'felgilab_register_acf_blocks');
function felgilab_register_acf_blocks()
{
	if (function_exists('register_block_type')) {
		register_block_type(get_template_directory() . "/template-parts/blocks/mainHeroBlock/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/sliderStandardBlock/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/galleryCustomBlock/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/ctaLiteBlock/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/priceListBlock/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/aboutCompanyBlock/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/workingProcess/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/reviewsBlock/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/finalContactBlock/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/faqBlock/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/brandsMarqueeBlock/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/comparisonBlock/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/beforeAfterBlock/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/sliderFullBlock/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/shortContactBlock/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/teamBlock/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/digitsBlock/block.json");
	}
}
// Advanced Custom Fields End

// cpt portfolio
add_action('init', 'felgilab_register_portfolio_cpt', 0);

function felgilab_register_portfolio_cpt()
{
	$labels = array(
		'name'                  => __('Portfolio', 'fls'),
		'singular_name'         => __('Portfolio Item', 'fls'),
		'menu_name'             => __('Portfolio', 'fls'),
		'name_admin_bar'        => __('Portfolio Item', 'fls'),
		'archives'              => __('Portfolio Archives', 'fls'),
		'attributes'            => __('Portfolio Attributes', 'fls'),
		'all_items'             => __('All Portfolio Items', 'fls'),
		'add_new_item'          => __('Add New Portfolio Item', 'fls'),
		'add_new'               => __('Add New', 'fls'),
		'new_item'              => __('New Portfolio Item', 'fls'),
		'edit_item'             => __('Edit Portfolio Item', 'fls'),
		'update_item'           => __('Update Portfolio Item', 'fls'),
		'view_item'             => __('View Portfolio Item', 'fls'),
		'view_items'            => __('View Portfolio Items', 'fls'),
		'search_items'          => __('Search Portfolio Items', 'fls'),
		'not_found'             => __('Not found', 'fls'),
		'not_found_in_trash'    => __('Not found in Trash', 'fls'),
		'featured_image'        => __('Featured Image', 'fls'),
		'set_featured_image'    => __('Set featured image', 'fls'),
		'remove_featured_image' => __('Remove featured image', 'fls'),
		'use_featured_image'    => __('Use as featured image', 'fls'),
		'items_list'            => __('Portfolio list', 'fls'),
		'items_list_navigation' => __('Portfolio list navigation', 'fls'),
		'filter_items_list'     => __('Filter portfolio list', 'fls'),
	);

	$args = array(
		'label'               => __('Portfolio', 'fls'),
		'description'         => __('Custom post type for portfolio items', 'fls'),
		'labels'              => $labels,
		'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions'),
		'hierarchical'        => false,
		'public'              => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'capability_type'     => 'post',
		'show_in_rest'        => true,
		'menu_icon'           => 'dashicons-portfolio',
		'menu_position'       => 22,
		'rewrite'             => array(
			'slug'       => 'portfolio',
			'with_front' => false,
		),
	);

	register_post_type('portfolio', $args);
}
// cpt portfolio end

// add portfolio to polylang
function felgilab_add_portfolio_to_polylang($types)
{
	$types[] = 'portfolio';
	return $types;
}
add_filter('pll_get_post_types', 'felgilab_add_portfolio_to_polylang');
// add portfolio to polylang end

// portfolio metabox
add_action('add_meta_boxes', 'felgilab_add_portfolio_metabox');

function felgilab_add_portfolio_metabox()
{
	add_meta_box(
		'felgilab_portfolio_data_metabox',
		'Portfolio Data',
		'felgilab_render_portfolio_data_metabox',
		'portfolio',
		'side',
		'default'
	);
}

function felgilab_render_portfolio_data_metabox($post)
{
	wp_nonce_field('felgilab_save_portfolio_data', 'felgilab_portfolio_nonce');

	$car_name      = get_post_meta($post->ID, '_portfolio_car_name', true);
	$rim_diameter  = get_post_meta($post->ID, '_portfolio_rim_diameter', true);
	$service_name  = get_post_meta($post->ID, '_portfolio_service_name', true);
?>
	<p>
		<label for="portfolio_car_name"><strong>Samochód:</strong></label><br>
		<input type="text" name="portfolio_car_name" id="portfolio_car_name" value="<?php echo esc_attr($car_name); ?>" style="width:100%;" placeholder="np. Bentley Continental GT">
	</p>

	<p>
		<label for="portfolio_rim_diameter"><strong>Średnica felgi:</strong></label><br>
		<input type="text" name="portfolio_rim_diameter" id="portfolio_rim_diameter" value="<?php echo esc_attr($rim_diameter); ?>" style="width:100%;" placeholder='np. 22"'>
	</p>

	<p>
		<label for="portfolio_service_name"><strong>Usługa:</strong></label><br>
		<input type="text" name="portfolio_service_name" id="portfolio_service_name" value="<?php echo esc_attr($service_name); ?>" style="width:100%;" placeholder="np. Renowacja">
	</p>
	<?php
}

add_action('save_post_portfolio', 'felgilab_save_portfolio_metabox');

function felgilab_save_portfolio_metabox($post_id)
{
	if (!isset($_POST['felgilab_portfolio_nonce'])) {
		return;
	}

	if (!wp_verify_nonce($_POST['felgilab_portfolio_nonce'], 'felgilab_save_portfolio_data')) {
		return;
	}

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	if (isset($_POST['portfolio_car_name'])) {
		update_post_meta($post_id, '_portfolio_car_name', sanitize_text_field($_POST['portfolio_car_name']));
	}

	if (isset($_POST['portfolio_rim_diameter'])) {
		update_post_meta($post_id, '_portfolio_rim_diameter', sanitize_text_field($_POST['portfolio_rim_diameter']));
	}

	if (isset($_POST['portfolio_service_name'])) {
		update_post_meta($post_id, '_portfolio_service_name', sanitize_text_field($_POST['portfolio_service_name']));
	}
}
// portfolio metabox end

if (!function_exists('felgilab_get_single_term_name')) {
	function felgilab_get_single_term_name($post_id, $taxonomy)
	{
		$terms = get_the_terms($post_id, $taxonomy);

		if (empty($terms) || is_wp_error($terms)) {
			return '';
		}

		$first_term = reset($terms);

		return $first_term ? $first_term->name : '';
	}
}

// ajax portfolio filter/load more
function felgilab_filter_portfolio_callback()
{
	$portfolio_brand = isset($_POST['portfolio_brand']) ? sanitize_text_field($_POST['portfolio_brand']) : 'all';
	$paged           = isset($_POST['paged']) ? absint($_POST['paged']) : 1;
	$lang            = isset($_POST['lang']) ? sanitize_text_field($_POST['lang']) : '';

	$args = array(
		'post_type'        => 'portfolio',
		'posts_per_page'   => 8,
		'paged'            => $paged,
		'post_status'      => 'publish',
		'suppress_filters' => false,
	);

	if (!empty($lang)) {
		$args['lang'] = $lang;
	}

	if ('all' !== $portfolio_brand) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'car_brand',
				'field'    => 'slug',
				'terms'    => $portfolio_brand,
			),
		);
	}

	$query = new WP_Query($args);

	if ($query->have_posts()) {
		ob_start();

		while ($query->have_posts()) {
			$query->the_post();

			$car_name     = get_post_meta(get_the_ID(), '_portfolio_car_name', true);
			$rim_diameter = get_post_meta(get_the_ID(), '_portfolio_rim_diameter', true);
			$service_name = get_post_meta(get_the_ID(), '_portfolio_service_name', true);

			$rim_color = '';

			$rim_terms = get_the_terms(get_the_ID(), 'rim_color');
			if (!empty($rim_terms) && !is_wp_error($rim_terms)) {
				$rim_term = reset($rim_terms);

				if ($rim_term) {
					$rim_term_id = (int) $rim_term->term_id;

					if (!empty($lang) && function_exists('felgilab_translate_term_id')) {
						$rim_term_id = felgilab_translate_term_id($rim_term_id, 'rim_color', $lang);
					}

					$translated_rim_term = get_term($rim_term_id, 'rim_color');
					if ($translated_rim_term && !is_wp_error($translated_rim_term)) {
						$rim_color = $translated_rim_term->name;
					}
				}
			}
	?>
			<a href="<?php the_permalink(); ?>" class="portfolio-card">
				<div class="portfolio-card__wrapper">
					<div class="portfolio-inner">
						<div class="portfolio-inner__item">
							<p class="portfolio-card__title"><?php the_title(); ?></p>

							<div class="portfolio-card__metas">
								<?php if ($car_name) : ?>
									<div class="portfolio-card__meta"><?php echo esc_html($car_name); ?></div>
								<?php endif; ?>

								<?php if ($service_name) : ?>
									<div class="portfolio-card__meta"><?php echo esc_html($service_name); ?></div>
								<?php endif; ?>

								<?php if ($rim_diameter || $rim_color) : ?>
									<div class="portfolio-card__meta">
										<?php echo esc_html(trim($rim_diameter . ' ' . $rim_color)); ?>
									</div>
								<?php endif; ?>
							</div>
						</div>

						<div class="portfolio-inner__item">
							<p class="portfolio-card__excerpt">
								<?php echo esc_html(wp_trim_words(get_the_excerpt(), 20, '...')); ?>
							</p>
						</div>
					</div>

					<div class="portfolio-card__image">
						<?php
						if (has_post_thumbnail()) {
							the_post_thumbnail('portfolio-card', [
								'loading' => 'lazy',
								'decoding' => 'async',
							]);
						} else {
							echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/img/no-image.webp') . '" alt="No image" loading="lazy" decoding="async">';
						}
						?>
					</div>
				</div>
			</a>
<?php
		}

		wp_reset_postdata();
		echo ob_get_clean();
	} else {
		echo '';
	}

	wp_die();
}
add_action('wp_ajax_filter_portfolio', 'felgilab_filter_portfolio_callback');
add_action('wp_ajax_nopriv_filter_portfolio', 'felgilab_filter_portfolio_callback');
// ajax portfolio filter/load more end

// meta box for gallery_item cpt
add_action('add_meta_boxes', function () {

	global $post;

	if (!$post) return;

	$template = get_page_template_slug($post->ID);

	if ($template !== 'page-gallery.php') {
		return;
	}

	add_meta_box(
		'felgilab_pretitle',
		'Pretitle',
		'felgilab_pretitle_metabox_callback',
		'page',
		'normal',
		'high'
	);
});
// meta box for gallery_item cpt end

// field inside meta box for gallery_item cpt
function felgilab_pretitle_metabox_callback($post)
{

	$value = get_post_meta($post->ID, '_felgilab_pretitle', true);

	wp_nonce_field('felgilab_pretitle_nonce', 'felgilab_pretitle_nonce');

	echo '<input type="text" style="width:100%;" name="felgilab_pretitle" value="' . esc_attr($value) . '" placeholder="Galeria realizacji">';
}
// field inside meta box for gallery_item cpt end

// save meta box field for gallery_item cpt
add_action('save_post', function ($post_id) {

	if (!isset($_POST['felgilab_pretitle_nonce'])) {
		return;
	}

	if (!wp_verify_nonce($_POST['felgilab_pretitle_nonce'], 'felgilab_pretitle_nonce')) {
		return;
	}

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	if (isset($_POST['felgilab_pretitle'])) {

		update_post_meta(
			$post_id,
			'_felgilab_pretitle',
			sanitize_text_field($_POST['felgilab_pretitle'])
		);
	}
});
// save meta box field for gallery_item cpt end

// cpt gallery_item
add_action('init', function () {
	register_post_type('gallery_item', [
		'labels' => [
			'name'          => 'Gallery Items',
			'singular_name' => 'Gallery Item',
		],
		'public'       => true,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-format-gallery',
		'supports'     => ['title', 'thumbnail', 'excerpt'],
		'has_archive'  => false,
		'rewrite'      => false,
	]);
});
// cpt gallery_item end

// car_brand taxonomy
add_action('init', function () {
	register_taxonomy('car_brand', ['gallery_item', 'portfolio'], [
		'labels' => [
			'name'          => 'Car Brands',
			'singular_name' => 'Car Brand',
		],
		'public'       => true,
		'hierarchical' => true,
		'show_in_rest' => true,
		'rewrite'      => ['slug' => 'car-brand'],
		'meta_box_cb'  => 'felgilab_car_brand_radio_metabox',
	]);
});
// car_brand taxonomy end

// rim_color taxonomy
add_action('init', function () {
	register_taxonomy('rim_color', ['gallery_item', 'portfolio'], [
		'labels' => [
			'name'          => 'Rim Colors',
			'singular_name' => 'Rim Color',
		],
		'public'       => true,
		'hierarchical' => false,
		'show_in_rest' => true,
		'rewrite'      => ['slug' => 'rim-color'],
		'meta_box_cb'  => 'felgilab_rim_color_radio_metabox',
	]);
});
// rim_color taxonomy end

function felgilab_single_term_radio_metabox($post, $box)
{
	$taxonomy = $box['args']['taxonomy'];

	$terms_args = [
		'taxonomy'   => $taxonomy,
		'hide_empty' => false,
		'orderby'    => 'name',
		'order'      => 'ASC',
	];

	// Для цветов в админке всегда показываем польские термины
	if ($taxonomy === 'rim_color' && function_exists('pll_default_language')) {
		$terms_args['lang'] = pll_default_language();
	}

	$terms = get_terms($terms_args);

	if (is_wp_error($terms) || empty($terms)) {
		echo '<p>No terms found.</p>';
		return;
	}

	$current_terms = wp_get_object_terms($post->ID, $taxonomy, ['fields' => 'ids']);
	$current_term  = !empty($current_terms) ? (int) $current_terms[0] : 0;

	// Если это цвет, а у поста выбран переводной термин,
	// приводим его обратно к польскому, чтобы radio корректно подсветился
	if ($taxonomy === 'rim_color' && $current_term > 0 && function_exists('pll_default_language') && function_exists('pll_get_term')) {
		$default_lang = pll_default_language();
		$default_term = pll_get_term($current_term, $default_lang);

		if (!empty($default_term)) {
			$current_term = (int) $default_term;
		}
	}

	wp_nonce_field('felgilab_save_single_term_' . $taxonomy, 'felgilab_single_term_nonce_' . $taxonomy);

	echo '<div class="categorydiv">';
	echo '<ul style="margin:0;">';

	foreach ($terms as $term) {
		echo '<li style="margin-bottom:8px;">';
		echo '<label>';
		echo '<input type="radio" name="felgilab_single_term_' . esc_attr($taxonomy) . '" value="' . esc_attr($term->term_id) . '" ' . checked($current_term, $term->term_id, false) . '> ';
		echo esc_html($term->name);
		echo '</label>';
		echo '</li>';
	}

	echo '<li style="margin-top:10px;">';
	echo '<label>';
	echo '<input type="radio" name="felgilab_single_term_' . esc_attr($taxonomy) . '" value="0" ' . checked($current_term, 0, false) . '> ';
	echo esc_html__('No term', 'fls');
	echo '</label>';
	echo '</li>';

	echo '</ul>';
	echo '</div>';
}

function felgilab_car_brand_radio_metabox($post, $box)
{
	felgilab_single_term_radio_metabox($post, $box);
}
function felgilab_rim_color_radio_metabox($post, $box)
{
	felgilab_single_term_radio_metabox($post, $box);
}

function felgilab_save_single_taxonomy_term($post_id, $taxonomy)
{
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	$nonce_key = 'felgilab_single_term_nonce_' . $taxonomy;

	if (!isset($_POST[$nonce_key])) {
		return;
	}

	if (!wp_verify_nonce($_POST[$nonce_key], 'felgilab_save_single_term_' . $taxonomy)) {
		return;
	}

	$field_name = 'felgilab_single_term_' . $taxonomy;
	$term_id    = isset($_POST[$field_name]) ? (int) $_POST[$field_name] : 0;

	if ($term_id <= 0) {
		wp_set_object_terms($post_id, [], $taxonomy, false);
		return;
	}

	// Для цветов сохраняем перевод термина под язык текущего поста
	if ($taxonomy === 'rim_color' && function_exists('pll_get_post_language')) {
		$post_lang = pll_get_post_language($post_id);

		if (!empty($post_lang)) {
			$term_id = felgilab_translate_term_id($term_id, $taxonomy, $post_lang);
		}
	}

	wp_set_object_terms($post_id, [$term_id], $taxonomy, false);
}

function felgilab_save_gallery_item_single_terms($post_id)
{
	felgilab_save_single_taxonomy_term($post_id, 'car_brand');
	felgilab_save_single_taxonomy_term($post_id, 'rim_color');
}

function felgilab_save_portfolio_single_terms($post_id)
{
	felgilab_save_single_taxonomy_term($post_id, 'car_brand');
	felgilab_save_single_taxonomy_term($post_id, 'rim_color');
}

add_action('save_post_gallery_item', 'felgilab_save_gallery_item_single_terms');
add_action('save_post_portfolio', 'felgilab_save_portfolio_single_terms');

function felgilab_add_gallery_taxonomies_to_polylang($taxonomies)
{
	$taxonomies[] = 'rim_color';
	return $taxonomies;
}
add_filter('pll_get_taxonomies', 'felgilab_add_gallery_taxonomies_to_polylang');


// services helpers
if (!function_exists('felgilab_get_services_base_slug')) {
	function felgilab_get_services_base_slug($lang = '')
	{
		if (empty($lang) && function_exists('pll_current_language')) {
			$lang = pll_current_language();
		}

		$slugs = array(
			'en' => 'services',
			'pl' => 'uslugi',
			'ru' => 'uslugi',
			'uk' => 'uslugi',
		);

		return isset($slugs[$lang]) ? $slugs[$lang] : 'services';
	}
}

if (!function_exists('felgilab_get_services_archive_url')) {
	function felgilab_get_services_archive_url($lang = '')
	{
		if (empty($lang) && function_exists('pll_current_language')) {
			$lang = pll_current_language();
		}

		$default_lang = function_exists('pll_default_language') ? pll_default_language() : '';
		$base_slug    = felgilab_get_services_base_slug($lang);

		if (!empty($lang) && $lang !== $default_lang) {
			return home_url('/' . $lang . '/' . $base_slug . '/');
		}

		return home_url('/' . $base_slug . '/');
	}
}

if (!function_exists('felgilab_translate_term_id')) {
	function felgilab_translate_term_id($term_id, $taxonomy, $lang = '')
	{
		$term_id = (int) $term_id;

		if ($term_id <= 0) {
			return 0;
		}

		// Только цвета переводим через Polylang
		if ($taxonomy !== 'rim_color') {
			return $term_id;
		}

		if (!function_exists('pll_get_term')) {
			return $term_id;
		}

		if (empty($lang) && function_exists('pll_current_language')) {
			$lang = pll_current_language();
		}

		if (empty($lang)) {
			return $term_id;
		}

		$translated_term_id = pll_get_term($term_id, $lang);

		return !empty($translated_term_id) ? (int) $translated_term_id : $term_id;
	}
}

if (!function_exists('felgilab_get_services_breadcrumb_title')) {
	function felgilab_get_services_breadcrumb_title($lang = '')
	{
		if (empty($lang) && function_exists('pll_current_language')) {
			$lang = pll_current_language();
		}

		$titles = array(
			'en' => 'Services',
			'pl' => 'Usługi',
			'ru' => 'Услуги',
			'uk' => 'Послуги',
		);

		return isset($titles[$lang]) ? $titles[$lang] : 'Services';
	}
}
// services helpers end

// cpt services
add_action('init', 'felgilab_register_services_cpt', 0);

function felgilab_register_services_cpt()
{
	$labels = array(
		'name'                  => __('Services', 'fls'),
		'singular_name'         => __('Service', 'fls'),
		'menu_name'             => __('Services', 'fls'),
		'name_admin_bar'        => __('Service', 'fls'),
		'archives'              => __('Service Archives', 'fls'),
		'attributes'            => __('Service Attributes', 'fls'),
		'parent_item_colon'     => __('Parent Service:', 'fls'),
		'all_items'             => __('All Services', 'fls'),
		'add_new_item'          => __('Add New Service', 'fls'),
		'add_new'               => __('Add New', 'fls'),
		'new_item'              => __('New Service', 'fls'),
		'edit_item'             => __('Edit Service', 'fls'),
		'update_item'           => __('Update Service', 'fls'),
		'view_item'             => __('View Service', 'fls'),
		'view_items'            => __('View Services', 'fls'),
		'search_items'          => __('Search Service', 'fls'),
		'not_found'             => __('Not found', 'fls'),
		'not_found_in_trash'    => __('Not found in Trash', 'fls'),
		'featured_image'        => __('Featured Image', 'fls'),
		'set_featured_image'    => __('Set featured image', 'fls'),
		'remove_featured_image' => __('Remove featured image', 'fls'),
		'use_featured_image'    => __('Use as featured image', 'fls'),
		'insert_into_item'      => __('Insert into service', 'fls'),
		'uploaded_to_this_item' => __('Uploaded to this service', 'fls'),
		'items_list'            => __('Services list', 'fls'),
		'items_list_navigation' => __('Services list navigation', 'fls'),
		'filter_items_list'     => __('Filter services list', 'fls'),
	);

	$args = array(
		'label'               => __('Services', 'fls'),
		'description'         => __('Custom post type for services', 'fls'),
		'labels'              => $labels,
		'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes'),
		'taxonomies'          => array('services_category'),
		'hierarchical'        => true,
		'public'              => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'capability_type'     => 'page',
		'map_meta_cap'        => true,
		'show_in_rest'        => true,
		'menu_icon'           => 'dashicons-admin-tools',
		'menu_position'       => 23,
		'rewrite'             => false,
	);

	register_post_type('services', $args);
}
// cpt services end

// services taxonomy
add_action('init', 'felgilab_register_services_taxonomy', 0);

function felgilab_register_services_taxonomy()
{
	$labels = array(
		'name'              => __('Service Categories', 'fls'),
		'singular_name'     => __('Service Category', 'fls'),
		'search_items'      => __('Search Service Categories', 'fls'),
		'all_items'         => __('All Service Categories', 'fls'),
		'parent_item'       => __('Parent Service Category', 'fls'),
		'parent_item_colon' => __('Parent Service Category:', 'fls'),
		'edit_item'         => __('Edit Service Category', 'fls'),
		'update_item'       => __('Update Service Category', 'fls'),
		'add_new_item'      => __('Add New Service Category', 'fls'),
		'new_item_name'     => __('New Service Category Name', 'fls'),
		'menu_name'         => __('Service Categories', 'fls'),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array(
			'slug'       => 'services-category',
			'with_front' => false,
		),
		'show_in_rest'      => true,
	);

	register_taxonomy('services_category', array('services'), $args);
}
// services taxonomy end

// add services to polylang
function felgilab_add_services_to_polylang($types)
{
	$types[] = 'services';
	return $types;
}
add_filter('pll_get_post_types', 'felgilab_add_services_to_polylang');

function felgilab_add_services_taxonomy_to_polylang($taxonomies)
{
	$taxonomies[] = 'services_category';
	return $taxonomies;
}
add_filter('pll_get_taxonomies', 'felgilab_add_services_taxonomy_to_polylang');
// add services to polylang end

// services permalink with parents + language
function felgilab_services_post_type_link($post_link, $post, $leavename, $sample)
{
	if ($post->post_type !== 'services') {
		return $post_link;
	}

	$lang         = function_exists('pll_get_post_language') ? pll_get_post_language($post->ID) : '';
	$default_lang = function_exists('pll_default_language') ? pll_default_language() : '';
	$base_slug    = felgilab_get_services_base_slug($lang);

	$ancestors = get_post_ancestors($post->ID);
	$slug_path = '';

	if (!empty($ancestors)) {
		$ancestors = array_reverse($ancestors);

		foreach ($ancestors as $ancestor_id) {
			$ancestor = get_post($ancestor_id);

			if ($ancestor && $ancestor->post_type === 'services') {
				$slug_path .= $ancestor->post_name . '/';
			}
		}
	}

	if (!empty($lang) && $lang !== $default_lang) {
		return home_url('/' . $lang . '/' . $base_slug . '/' . $slug_path . $post->post_name . '/');
	}

	return home_url('/' . $base_slug . '/' . $slug_path . $post->post_name . '/');
}
add_filter('post_type_link', 'felgilab_services_post_type_link', 10, 4);
// services permalink with parents + language end

function felgilab_gallery_item_permalink($post_link, $post)
{
	if ($post->post_type !== 'gallery_item') {
		return $post_link;
	}

	$brand_slug = 'no-brand';
	$color_slug = 'no-color';

	$brand_terms = get_the_terms($post->ID, 'car_brand');
	if (!empty($brand_terms) && !is_wp_error($brand_terms)) {
		$brand_term = reset($brand_terms);
		if ($brand_term && !empty($brand_term->slug)) {
			$brand_slug = $brand_term->slug;
		}
	}

	$color_terms = get_the_terms($post->ID, 'rim_color');
	if (!empty($color_terms) && !is_wp_error($color_terms)) {
		$color_term = reset($color_terms);
		if ($color_term && !empty($color_term->slug)) {
			$color_slug = $color_term->slug;
		}
	}

	return home_url('/gallery-item/' . $brand_slug . '/' . $color_slug . '/' . $post->post_name . '/');
}
add_filter('post_type_link', 'felgilab_gallery_item_permalink', 10, 2);

function felgilab_gallery_item_rewrite_rules()
{
	add_rewrite_rule(
		'^gallery-item/([^/]+)/([^/]+)/([^/]+)/?$',
		'index.php?post_type=gallery_item&name=$matches[3]',
		'top'
	);
}
add_action('init', 'felgilab_gallery_item_rewrite_rules', 20);

// services rewrite rules
function felgilab_services_rewrite_rules()
{
	if (function_exists('pll_languages_list') && function_exists('pll_default_language')) {
		$langs        = pll_languages_list();
		$default_lang = pll_default_language();

		foreach ($langs as $lang) {
			$base_slug = felgilab_get_services_base_slug($lang);

			if ($lang === $default_lang) {
				add_rewrite_rule(
					'^' . $base_slug . '/(.+?)/?$',
					'index.php?services=$matches[1]',
					'top'
				);
			} else {
				add_rewrite_rule(
					'^' . $lang . '/' . $base_slug . '/(.+?)/?$',
					'index.php?lang=' . $lang . '&services=$matches[1]',
					'top'
				);
			}
		}
	} else {
		add_rewrite_rule(
			'^services/(.+?)/?$',
			'index.php?services=$matches[1]',
			'top'
		);
	}
}
add_action('init', 'felgilab_services_rewrite_rules', 20);
// services rewrite rules end

// services canonical redirect
function felgilab_services_template_redirect_canonical()
{
	if (!is_singular('services')) {
		return;
	}

	global $post, $wp;

	$canonical   = get_permalink($post);
	$current_url = home_url(add_query_arg(array(), $wp->request)) . '/';

	if (trailingslashit($current_url) !== trailingslashit($canonical)) {
		wp_redirect($canonical, 301);
		exit;
	}
}
add_action('template_redirect', 'felgilab_services_template_redirect_canonical');
// services canonical redirect end

// output FAQ schema in JSON-LD format in the footer
add_action('wp_footer', 'felgilab_output_faq_schema', 100);

function felgilab_add_faq_schema_item($question, $answer)
{
	global $felgilab_faq_schema_items;

	if (!is_array($felgilab_faq_schema_items)) {
		$felgilab_faq_schema_items = [];
	}

	$question = trim((string) $question);
	$answer   = trim((string) $answer);

	if ($question === '' || $answer === '') {
		return;
	}

	$answer_text = wp_strip_all_tags($answer, true);
	$answer_text = preg_replace('/\s+/', ' ', $answer_text);
	$answer_text = trim($answer_text);

	if ($answer_text === '') {
		return;
	}

	$felgilab_faq_schema_items[] = [
		'@type' => 'Question',
		'name'  => $question,
		'acceptedAnswer' => [
			'@type' => 'Answer',
			'text'  => $answer_text,
		],
	];
}

function felgilab_output_faq_schema()
{
	if (is_admin()) {
		return;
	}

	global $felgilab_faq_schema_items;

	if (empty($felgilab_faq_schema_items) || !is_array($felgilab_faq_schema_items)) {
		return;
	}

	$unique_items = [];
	$seen_items = [];

	foreach ($felgilab_faq_schema_items as $item) {
		$question = $item['name'] ?? '';
		$answer   = $item['acceptedAnswer']['text'] ?? '';

		if ($question === '' || $answer === '') {
			continue;
		}

		$hash = md5($question . '|' . $answer);

		if (isset($seen_items[$hash])) {
			continue;
		}

		$seen_items[$hash] = true;
		$unique_items[] = $item;
	}

	if (empty($unique_items)) {
		return;
	}

	$schema = [
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => array_values($unique_items),
	];

	echo '<script type="application/ld+json">' .
		wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) .
		'</script>';
}

if (!function_exists('felgilab_get_blog_page_slug')) {
	function felgilab_get_blog_page_slug($lang = '')
	{
		if (empty($lang) && function_exists('pll_current_language')) {
			$lang = pll_current_language();
		}

		$slugs = array(
			'pl' => 'blog',
			'en' => 'blog-en',
			'ru' => 'blog-ru',
			'uk' => 'blog-uk',
		);

		return isset($slugs[$lang]) ? $slugs[$lang] : 'blog';
	}
}

if (!function_exists('felgilab_get_blog_virtual_slug')) {
	function felgilab_get_blog_virtual_slug()
	{
		return 'blog';
	}
}

if (!function_exists('felgilab_get_blog_page_id_by_lang')) {
	function felgilab_get_blog_page_id_by_lang($lang = '')
	{
		if (empty($lang) && function_exists('pll_current_language')) {
			$lang = pll_current_language();
		}

		$page_slug = felgilab_get_blog_page_slug($lang);

		$pages = get_posts([
			'post_type'        => 'page',
			'name'             => $page_slug,
			'post_status'      => 'publish',
			'posts_per_page'   => 1,
			'suppress_filters' => false,
			'lang'             => $lang,
			'fields'           => 'ids',
		]);

		if (!empty($pages)) {
			return (int) $pages[0];
		}

		return 0;
	}
}

if (!function_exists('felgilab_get_blog_archive_url')) {
	function felgilab_get_blog_archive_url($lang = '')
	{
		if (empty($lang) && function_exists('pll_current_language')) {
			$lang = pll_current_language();
		}

		$default_lang = function_exists('pll_default_language') ? pll_default_language() : '';
		$virtual_slug = felgilab_get_blog_virtual_slug();

		if (!empty($lang) && $lang !== $default_lang) {
			return home_url('/' . $lang . '/' . $virtual_slug . '/');
		}

		return home_url('/' . $virtual_slug . '/');
	}
}

function felgilab_blog_rewrite_rules()
{
	$virtual_slug = felgilab_get_blog_virtual_slug();

	if (function_exists('pll_languages_list') && function_exists('pll_default_language')) {
		$langs        = pll_languages_list();
		$default_lang = pll_default_language();

		foreach ($langs as $lang) {
			if ($lang === $default_lang) {
				add_rewrite_rule(
					'^' . $virtual_slug . '/?$',
					'index.php?felgilab_blog_lang=' . $lang,
					'top'
				);

				add_rewrite_rule(
					'^' . $virtual_slug . '/page/([0-9]{1,})/?$',
					'index.php?felgilab_blog_lang=' . $lang . '&paged=$matches[1]',
					'top'
				);
			} else {
				add_rewrite_rule(
					'^' . $lang . '/' . $virtual_slug . '/?$',
					'index.php?felgilab_blog_lang=' . $lang,
					'top'
				);

				add_rewrite_rule(
					'^' . $lang . '/' . $virtual_slug . '/page/([0-9]{1,})/?$',
					'index.php?felgilab_blog_lang=' . $lang . '&paged=$matches[1]',
					'top'
				);
			}
		}
	}
}
add_action('init', 'felgilab_blog_rewrite_rules', 20);

function felgilab_blog_query_vars($vars)
{
	$vars[] = 'felgilab_blog_lang';
	return $vars;
}
add_filter('query_vars', 'felgilab_blog_query_vars');

function felgilab_blog_request_to_page($query)
{
	if (is_admin() || !$query->is_main_query()) {
		return;
	}

	$blog_lang = $query->get('felgilab_blog_lang');

	if (empty($blog_lang)) {
		return;
	}

	$page_id = felgilab_get_blog_page_id_by_lang($blog_lang);

	if (!$page_id) {
		return;
	}

	$query->set('page_id', $page_id);
	$query->set('post_type', 'page');
	$query->set('pagename', '');
	$query->set('name', '');
	$query->set('lang', $blog_lang);

	$query->is_page = true;
	$query->is_singular = true;
	$query->is_single = false;
	$query->is_home = false;
	$query->is_archive = false;
	$query->is_post_type_archive = false;
	$query->is_posts_page = false;
	$query->is_404 = false;
}
add_action('pre_get_posts', 'felgilab_blog_request_to_page');

function felgilab_blog_template_redirect_canonical()
{
	if (!is_page()) {
		return;
	}

	$current_lang = function_exists('pll_current_language') ? pll_current_language() : '';
	$page_id      = get_queried_object_id();
	$blog_page_id = felgilab_get_blog_page_id_by_lang($current_lang);

	if (!$page_id || !$blog_page_id || (int) $page_id !== (int) $blog_page_id) {
		return;
	}

	global $wp;

	$current_url = home_url(add_query_arg([], $wp->request));
	$canonical   = felgilab_get_blog_archive_url($current_lang);

	$current_paged = max(1, get_query_var('paged'));

	if ($current_paged > 1) {
		$canonical = trailingslashit($canonical) . 'page/' . $current_paged . '/';
	}

	if (trailingslashit($current_url) !== trailingslashit($canonical)) {
		wp_redirect($canonical, 301);
		exit;
	}
}
add_action('template_redirect', 'felgilab_blog_template_redirect_canonical', 1);

add_filter('wpseo_canonical', function ($canonical) {
	if (!is_page()) {
		return $canonical;
	}

	$current_lang = function_exists('pll_current_language') ? pll_current_language() : '';
	$page_id      = get_queried_object_id();
	$blog_page_id = felgilab_get_blog_page_id_by_lang($current_lang);

	if (!$page_id || !$blog_page_id || (int) $page_id !== (int) $blog_page_id) {
		return $canonical;
	}

	$url = felgilab_get_blog_archive_url($current_lang);
	$current_paged = max(1, get_query_var('paged'));

	if ($current_paged > 1) {
		$url = trailingslashit($url) . 'page/' . $current_paged . '/';
	}

	return $url;
});


// custom breadcrumbs
function custom_breadcrumbs()
{
	$separator = ' / '; // не используется, если разделители не нужны
	$list_class = 'breadcrumbs__list';
	$current_lang = pll_current_language();
	$default_lang = pll_default_language(); // основной язык

	$home_titles = array(
		'en' => 'Homepage',
		'pl' => 'Strona główna',
		'ru' => 'Главная',
		'uk' => 'Головна',
	);
	$home_title = isset($home_titles[$current_lang]) ? $home_titles[$current_lang] : $home_titles['en'];

	$posts_titles = array(
		'en' => 'Blog',
		'pl' => 'Blog',
		'ru' => 'Блог',
		'uk' => 'Блог'
	);

	$portfolio_slugs = array(
		'en' => 'portfolio',
		'pl' => 'portfolio',
		'ru' => 'portfolio',
		'uk' => 'portfolio'
	);
	$landings_slugs = array(
		'en' => 'landings',
		'pl' => 'landings',
		'ru' => 'landings',
		'uk' => 'landings'
	);
	$portfolio_title = 'Portfolio';
	$landings_title = 'Landings';

	global $post;
	$home_url = get_home_url();

	// Начало JSON‑LD разметки
	$breadcrumbs_data = array(
		"@context" => "https://schema.org",
		"@type"    => "BreadcrumbList",
		"itemListElement" => array()
	);

	if (!is_front_page()) {
		echo '<ul class="' . $list_class . '" itemscope itemtype="https://schema.org/BreadcrumbList">';
		$position = 1;

		// Главная страница
		echo '<li class="breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
		echo '<a href="' . $home_url . '" class="breadcrumbs__link" itemprop="item">';
		echo '<span itemprop="name">' . $home_title . '</span>';
		echo '</a>';
		echo '<meta itemprop="position" content="' . $position . '" />';
		echo '</li>';
		$breadcrumbs_data["itemListElement"][] = array(
			"@type"    => "ListItem",
			"position" => $position,
			"name"     => $home_title,
			"item"     => $home_url
		);
		$position++;

		// Для записей типа "services"
		if (is_singular('services')) {
			$services_title    = felgilab_get_services_breadcrumb_title($current_lang);
			$services_page_url = felgilab_get_services_archive_url($current_lang);

			echo '<li class="breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
			echo '<a href="' . esc_url($services_page_url) . '" class="breadcrumbs__link" itemprop="item">';
			echo '<span itemprop="name">' . esc_html($services_title) . '</span>';
			echo '</a>';
			echo '<meta itemprop="position" content="' . $position . '" />';
			echo '</li>';

			$breadcrumbs_data["itemListElement"][] = array(
				"@type"    => "ListItem",
				"position" => $position,
				"name"     => $services_title,
				"item"     => $services_page_url
			);

			$position++;

			$ancestors = get_post_ancestors(get_the_ID());

			if (!empty($ancestors)) {
				$ancestors = array_reverse($ancestors);

				foreach ($ancestors as $ancestor_id) {
					$ancestor = get_post($ancestor_id);

					if (!$ancestor || $ancestor->post_type !== 'services') {
						continue;
					}

					echo '<li class="breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
					echo '<a href="' . esc_url(get_permalink($ancestor_id)) . '" class="breadcrumbs__link" itemprop="item">';
					echo '<span itemprop="name">' . esc_html(get_the_title($ancestor_id)) . '</span>';
					echo '</a>';
					echo '<meta itemprop="position" content="' . $position . '" />';
					echo '</li>';

					$breadcrumbs_data["itemListElement"][] = array(
						"@type"    => "ListItem",
						"position" => $position,
						"name"     => get_the_title($ancestor_id),
						"item"     => get_permalink($ancestor_id)
					);

					$position++;
				}
			}

			echo '<li class="breadcrumbs__item breadcrumbs__item--active" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
			echo '<span itemprop="name">' . esc_html(get_the_title()) . '</span>';
			echo '<meta itemprop="position" content="' . $position . '" />';
			echo '</li>';

			$breadcrumbs_data["itemListElement"][] = array(
				"@type"    => "ListItem",
				"position" => $position,
				"name"     => get_the_title(),
				"item"     => get_permalink()
			);

			// Для записей типа "post"
		} elseif (is_singular('post')) {
			$posts_title    = isset($posts_titles[$current_lang]) ? $posts_titles[$current_lang] : 'Blog';
			$posts_page_url = felgilab_get_blog_archive_url($current_lang);

			echo '<li class="breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
			echo '<a href="' . $posts_page_url . '" class="breadcrumbs__link" itemprop="item">';
			echo '<span itemprop="name">' . ucfirst($posts_title) . '</span>';
			echo '</a>';
			echo '<meta itemprop="position" content="' . $position . '" />';
			echo '</li>';
			$breadcrumbs_data["itemListElement"][] = array(
				"@type"    => "ListItem",
				"position" => $position,
				"name"     => ucfirst($posts_title),
				"item"     => $posts_page_url
			);
			$position++;

			echo '<li class="breadcrumbs__item breadcrumbs__item--active" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
			echo '<span itemprop="name">' . get_the_title() . '</span>';
			echo '<meta itemprop="position" content="' . $position . '" />';
			echo '</li>';
			$breadcrumbs_data["itemListElement"][] = array(
				"@type"    => "ListItem",
				"position" => $position,
				"name"     => get_the_title(),
				"item"     => get_permalink()
			);

			// Для записей типа "portfolio"
		} elseif (is_singular('portfolio')) {
			$portfolio_slug = 'portfolio';
			$portfolio_page_url = ($current_lang == $default_lang) ? home_url('/' . $portfolio_slug . '/') : home_url('/' . $current_lang . '/' . $portfolio_slug . '/');

			echo '<li class="breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
			echo '<a href="' . $portfolio_page_url . '" class="breadcrumbs__link" itemprop="item">';
			echo '<span itemprop="name">' . $portfolio_title . '</span>';
			echo '</a>';
			echo '<meta itemprop="position" content="' . $position . '" />';
			echo '</li>';
			$breadcrumbs_data["itemListElement"][] = array(
				"@type"    => "ListItem",
				"position" => $position,
				"name"     => $portfolio_title,
				"item"     => $portfolio_page_url
			);
			$position++;

			echo '<li class="breadcrumbs__item breadcrumbs__item--active" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
			echo '<span itemprop="name">' . get_the_title() . '</span>';
			echo '<meta itemprop="position" content="' . $position . '" />';
			echo '</li>';
			$breadcrumbs_data["itemListElement"][] = array(
				"@type"    => "ListItem",
				"position" => $position,
				"name"     => get_the_title(),
				"item"     => get_permalink()
			);

			// Для записей типа "landings"
		} elseif (is_singular('landings')) {
			$landings_slug = isset($landings_slugs[$current_lang]) ? $landings_slugs[$current_lang] : 'landings';
			$landings_page_url = ($current_lang == $default_lang) ? home_url('/' . $landings_slug . '/') : home_url('/' . $current_lang . '/' . $landings_slug . '/');

			echo '<li class="breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
			echo '<a href="' . $landings_page_url . '" class="breadcrumbs__link" itemprop="item">';
			echo '<span itemprop="name">' . $landings_title . '</span>';
			echo '</a>';
			echo '<meta itemprop="position" content="' . $position . '" />';
			echo '</li>';
			$breadcrumbs_data["itemListElement"][] = array(
				"@type"    => "ListItem",
				"position" => $position,
				"name"     => $landings_title,
				"item"     => $landings_page_url
			);
			$position++;

			echo '<li class="breadcrumbs__item breadcrumbs__item--active" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
			echo '<span itemprop="name">' . get_the_title() . '</span>';
			echo '<meta itemprop="position" content="' . $position . '" />';
			echo '</li>';
			$breadcrumbs_data["itemListElement"][] = array(
				"@type"    => "ListItem",
				"position" => $position,
				"name"     => get_the_title(),
				"item"     => get_permalink()
			);

			// Если это обычная страница
		} elseif (is_page()) {
			echo '<li class="breadcrumbs__item breadcrumbs__item--active" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
			echo '<span itemprop="name">' . get_the_title() . '</span>';
			echo '<meta itemprop="position" content="' . $position . '" />';
			echo '</li>';
			$breadcrumbs_data["itemListElement"][] = array(
				"@type"    => "ListItem",
				"position" => $position,
				"name"     => get_the_title(),
				"item"     => get_permalink()
			);
		}

		echo '</ul>';
		echo '<script type="application/ld+json">' . json_encode($breadcrumbs_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
	}
}
// custom breadcrumbs

// functions for menu item active state
if (!function_exists('felgilab_normalize_url_path')) {
	function felgilab_normalize_url_path($url)
	{
		if (empty($url)) {
			return '/';
		}

		$path = wp_parse_url($url, PHP_URL_PATH);

		if (!$path) {
			$path = '/';
		}

		$path = trailingslashit($path);

		return $path;
	}
}

if (!function_exists('felgilab_is_menu_item_active')) {
	function felgilab_is_menu_item_active($menu_item_url)
	{
		if (empty($menu_item_url)) {
			return false;
		}

		// Для якорей не считаем активность по URL
		if (strpos($menu_item_url, '#') !== false) {
			return false;
		}

		$current_url = home_url(add_query_arg([], $GLOBALS['wp']->request));
		$current_path = felgilab_normalize_url_path($current_url);
		$item_path    = felgilab_normalize_url_path($menu_item_url);

		return $current_path === $item_path;
	}
}

if (!function_exists('felgilab_menu_item_has_active_child')) {
	function felgilab_menu_item_has_active_child($item_id, $menu_items_by_parent)
	{
		if (empty($menu_items_by_parent[$item_id])) {
			return false;
		}

		foreach ($menu_items_by_parent[$item_id] as $child_item) {
			if (felgilab_is_menu_item_active($child_item->url)) {
				return true;
			}

			if (felgilab_menu_item_has_active_child($child_item->ID, $menu_items_by_parent)) {
				return true;
			}
		}

		return false;
	}
}
// functions for menu item active state end

// add noindex for gallery_item cpt
add_filter('wpseo_robots', function ($robots) {
	if (is_singular('gallery_item')) {
		return 'noindex, follow';
	}
	return $robots;
});
// add noindex for gallery_item cpt end

// add async loading for specific styles
add_filter('style_loader_tag', function ($html, $handle, $href, $media) {

	$async_styles = ['vite-custom-css'];

	if (in_array($handle, $async_styles, true)) {
		return "<link rel='preload' href='{$href}' as='style' onload=\"this.onload=null;this.rel='stylesheet'\">\n<noscript><link rel='stylesheet' href='{$href}' media='{$media}'></noscript>";
	}

	return $html;
}, 10, 4);
// add async loading for specific styles end