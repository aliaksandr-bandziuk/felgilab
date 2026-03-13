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
}
add_action('after_setup_theme', 'fls_setup');

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
	}
}
// Advanced Custom Fields End

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
		'supports' 		 => ['title', 'thumbnail', 'excerpt'],
		'has_archive'  => false,
		'rewrite'      => ['slug' => 'gallery-item'],
	]);
});
// cpt gallery_item end

// car_brand taxonomy
add_action('init', function () {
	register_taxonomy('car_brand', ['gallery_item'], [
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

// custom meta box for car_brand taxonomy
function felgilab_car_brand_radio_metabox($post, $box)
{
	$taxonomy = $box['args']['taxonomy'];
	$tax      = get_taxonomy($taxonomy);
	$terms    = get_terms([
		'taxonomy'   => $taxonomy,
		'hide_empty' => false,
	]);

	if (is_wp_error($terms) || empty($terms)) {
		echo '<p>No brands found.</p>';
		return;
	}

	$current_terms = wp_get_object_terms($post->ID, $taxonomy, ['fields' => 'ids']);
	$current_term  = !empty($current_terms) ? (int) $current_terms[0] : 0;

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
	echo esc_html__('No brand', 'felgilab');
	echo '</label>';
	echo '</li>';

	echo '</ul>';
	echo '</div>';
}
// custom meta box for car_brand taxonomy end

// save single term for car_brand taxonomy
add_action('save_post_gallery_item', function ($post_id) {
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	$taxonomy = 'car_brand';
	$nonce_key = 'felgilab_single_term_nonce_' . $taxonomy;

	if (!isset($_POST[$nonce_key])) {
		return;
	}

	if (!wp_verify_nonce($_POST[$nonce_key], 'felgilab_save_single_term_' . $taxonomy)) {
		return;
	}

	$field_name = 'felgilab_single_term_' . $taxonomy;
	$term_id    = isset($_POST[$field_name]) ? (int) $_POST[$field_name] : 0;

	if ($term_id > 0) {
		wp_set_object_terms($post_id, [$term_id], $taxonomy, false);
	} else {
		wp_set_object_terms($post_id, [], $taxonomy, false);
	}
});
// save single term for car_brand taxonomy end