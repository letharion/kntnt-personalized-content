<?php

namespace Kntnt\CIP;

class Ajax_Handler {

	private $ns;

	public function __construct() {
		$this->ns = Plugin::ns();
	}

	public function run() {
		add_action( "wp_ajax_{$this->ns}", [ $this, 'ajax_action' ] );
		add_action( "wp_ajax_nopriv_{$this->ns}", [ $this, 'ajax_action' ] );
	}

	public function ajax_action() {

		// Check that nonce is valid. Die if not.
		check_ajax_referer( 'kntnt-cip-nonce', 'nonce' );

		// Get the profile.
		$profile = $_POST['profile'] ? $_POST['profile'] : [];

		/**
		 * Filters the HTML-code of the personalized content before it is
		 * echoed back to the calling JavaScript.
		 *
		 * @param string $html The HTML-code to be filtered. Default is an empty
		 *                     string.
		 * @param array $attr  An associated array with the container element's
		 *                     attributes.
		 */
		echo apply_filters( 'kntnt_cip_output', '', $profile, $_POST['attributes'] );

		// That's it.
		wp_die();

	}

}