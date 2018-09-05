<?php

namespace Kntnt\CIP;

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
		 * '.kntnt-cip'.
		 *
		 * @param string selector The selector to be filtered.
		 *
		 * @return string The filtered selector.
		 */
		$selector = apply_filters( 'kntnt_cip_selector', '.kntnt-cip' );

		if ( ! $selector ) return;

		wp_enqueue_script( "{$this->ns}.js", Plugin::rel_plugin_dir( "js/{$this->ns}.js" ), [ 'jquery' ] );
		wp_localize_script( "{$this->ns}.js", 'kntnt_cip', [
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'cip_url' => $cip_url,
			'selector' => $selector,
			'action' => $this->ns,
			'nonce' => wp_create_nonce( 'kntnt-cip-nonce' ),
			'debug' => defined( 'WP_DEBUG' ) && 'WP_DEBUG',
		] );

	}

}