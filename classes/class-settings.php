<?php

namespace Kntnt\CIP;

require_once Plugin::plugin_dir( 'classes/class-abstract-settings.php' );

class Settings extends Abstract_Settings {

	/**
	 * Returns the settings menu title.
	 */
	protected function menu_title() {
		return __( 'KNTNT CIP', 'kntnt-cip' );
	}

	/**
	 * Returns the settings page title.
	 */
	protected function page_title() {
		return __( "Kntnt's Content Intelligence Platform", 'kntnt-cip' );
	}

	/**
	 * Returns all fields used on the settings page.
	 */
	protected function fields() {

		$fields['cip_url'] = [
			'type' => 'url',
			'label' => __( 'CIP URL', 'kntnt-cip' ),
			'description' => __( 'URL to the front page of Content Intelligence Platform by Kntnt', 'kntnt-cip' ),
			'validate' => function ( $url ) { return (bool) filter_var( $url, FILTER_VALIDATE_URL ); },
			'filter-after' => 'trailingslashit',
		];

		return $fields;

	}

}
