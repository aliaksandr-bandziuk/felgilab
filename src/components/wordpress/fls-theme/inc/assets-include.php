<?php
const VITE_HOST = 'http://localhost:1111';
function add_vite() {
$theme_dir = get_template_directory();
$theme_uri = get_template_directory_uri();
$app_css_path = $theme_dir . '/build/assets/css/app.min.css';
$app_js_path = $theme_dir . '/build/assets/js/app.min.js';
$custom_css_path = $theme_dir . '/build/assets/css/custom.css';
$custom_js_path = $theme_dir . '/build/assets/js/custom.js';
$app_css_ver = file_exists($app_css_path) ? filemtime($app_css_path) : null;
$app_js_ver = file_exists($app_js_path) ? filemtime($app_js_path) : null;
$custom_css_ver = file_exists($custom_css_path) ? filemtime($custom_css_path) : null;
$custom_js_ver = file_exists($custom_js_path) ? filemtime($custom_js_path) : null;
wp_enqueue_style('app.min.css', $theme_uri . '/build/assets/css/app.min.css', array(), $app_css_ver, 'all');
wp_enqueue_script('app.min.js', $theme_uri . '/build/assets/js/app.min.js', array(), $app_js_ver, true);
wp_enqueue_style('vite-custom-css', $theme_uri . '/build/assets/css/custom.css', array(), $custom_css_ver, 'all');
wp_enqueue_script('vite-custom-js', $theme_uri . '/build/assets/js/custom.js', array(), $custom_js_ver, true);
}
add_action('wp_enqueue_scripts', 'add_vite');
function add_type_module_attribute($tag, $handle) {
if ('app.min.js' === $handle) {
return str_replace('<script', '<script type="module"', $tag);
}
return $tag;
}
add_filter('script_loader_tag', 'add_type_module_attribute', 10, 2);
?>