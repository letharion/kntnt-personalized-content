<?php

namespace Kntnt\Personalized_Content;

class Ajax_Armer {

	private $ns;

	private $cip_url;

	public function __construct() {

		$this->ns = Plugin::ns();

		add_action( 'kntnt_cip_init', function ( $cip ) {
			$this->cip_url = $cip->url();
			Plugin::log( 'CIP URL: %s', $this->cip_url );
		} );

	}

	public function run() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_script' ] );
	}

	public function enqueue_script() {

		if ( ! $this->cip_url ) {
			Plugin::log( "No URL provided by CIP plugin." );
			return;
		}

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

		Plugin::log();

		wp_enqueue_script( "{$this->ns}.js", Plugin::rel_plugin_dir( "js/{$this->ns}.js" ), [ 'jquery' ] );
		wp_localize_script( "{$this->ns}.js", 'kntnt_personalized_content', [
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'cip_url' => $this->cip_url,
			'selector' => $selector,
			'action' => $this->ns,
			'nonce' => wp_create_nonce( 'kntnt-personalized-content-nonce' ),
			'debug' => defined( 'WP_DEBUG' ) && 'WP_DEBUG',
		] );

	}

}