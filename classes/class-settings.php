<?php

namespace Kntnt\Personalized_Content;

require_once Plugin::plugin_dir( 'classes/class-abstract-settings.php' );

class Settings extends Abstract_Settings {

	/**
	 * Returns the settings menu title.
	 */
	protected function menu_title() {
		return __( 'Personalized Content', 'kntnt-personalized-content' );
	}

	/**
	 * Returns the settings page title.
	 */
	protected function page_title() {
		return __( "Kntnt's Personalized Content", 'kntnt-personalized-content' );
	}

	/**
	 * Returns all fields used on the settings page.
	 */
	protected function fields() {

		$fields['cip_url'] = [
			'type' => 'url',
			'label' => __( 'CIP URL', 'kntnt-personalized-content' ),
			'description' => __( 'URL to the front page of Content Intelligence Platform by Kntnt', 'kntnt-personalized-content' ),
			'validate' => function ( $url ) { return (bool) filter_var( $url, FILTER_VALIDATE_URL ); },
			'filter-after' => 'trailingslashit',
		];

		return $fields;

	}

}
