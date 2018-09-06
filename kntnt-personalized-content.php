<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Kntnt's Personalized Content
 * Plugin URI:        https://github.com/Kntnt/kntnt-bb-personalized-posts
 * Description:       Provides hooks that allows developers to inject personalized content.
 * Version:           1.0.0
 * Author:            Thomas Barregren
 * Author URI:        https://www.kntnt.com/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       kntnt-personalized-content
 * Domain Path:       /languages
 */

namespace Kntnt\Personalized_Content;

defined( 'WPINC' ) || die;

require_once __DIR__ . '/classes/class-plugin.php';

new Plugin( [
	'public' => [
		'init' => [
			'Ajax_Armer',
		],
	],
	'ajax' => [
		'admin_init' => [
			'Ajax_Handler',
		],
	],
	'admin' => [
		'init' => [
			'Settings',
		],
	],
] );