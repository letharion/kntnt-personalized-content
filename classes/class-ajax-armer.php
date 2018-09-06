<?php

namespace Kntnt\Personalized_Content;

class Ajax_Armer {

	private $ns;

	public function __construct() {
		$this->ns = Plugin::ns();
	}

	public function run() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_script' ] );
	}

	public function enqueue_script() {

		$cip_url = Plugin::option( 'cip_url' );

		if ( ! $cip_url ) return;

		/**
		 * Filters the selector that is used by jQuery to find the container(s)
		 * that will be replaced with the personalized content. Default is
		 * '.kntnt-personalized-content'.
		 *
		 * @param string selector The selector to be filtered.
		 *
		 * @return string The filtered selector.
		 */
		$selector = apply_filters( 'kntnt_personalized_content_selector', '.kntnt-personalized-content' );

		if ( ! $selector ) return;

		wp_enqueue_script( "{$this->ns}.js", Plugin::rel_plugin_dir( "js/{$this->ns}.js" ), [ 'jquery' ] );
		wp_localize_script( "{$this->ns}.js", 'kntnt_personalized_content', [
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'cip_url' => $cip_url,
			'selector' => $selector,
			'action' => $this->ns,
			'nonce' => wp_create_nonce( 'kntnt-personalized-content-nonce' ),
			'debug' => defined( 'WP_DEBUG' ) && 'WP_DEBUG',
		] );

	}

}