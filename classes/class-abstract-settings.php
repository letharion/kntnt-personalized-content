<?php

namespace Kntnt\Personalized_Content;

abstract class Abstract_Settings {

	/**
	 * Bootstrap instance of this class.
	 */
	public function run() {
		add_action( 'admin_menu', [ $this, 'add_options_page' ] );
	}

	/**
	 * Add settings page to the option menu.
	 */
	public function add_options_page() {
		add_options_page( $this->page_title(), $this->menu_title(), $this->capability(), Plugin::ns(), [ $this, 'show_settings_page' ] );
	}

	/**
	 * Returns title used as menu item.
	 */
	abstract protected function menu_title();

	/**
	 * Returns title used as head of settings page.
	 */
	abstract protected function page_title();

	/**
	 * Returns all fields used on the settings page.
	 */
	abstract protected function fields();

	/**
	 * Returns necessary capability to access the settings page.
	 */
	protected function capability() {
		return 'manage_options';
	}

	/**
	 * Returns path to settings page.
	 */
	protected function settings_page_template() {
		return Plugin::plugin_dir( 'includes/settings-page.php' );
	}

	/**
	 * Show settings page and update options.
	 */
	public function show_settings_page() {

		// Abort if current user has not permission to access the settings page.
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'Unauthorized use.', 'kntnt-taxonomy-meta-tag' ) );
		}

		// Update options if the page is shown after a form post.
		if ( isset( $_POST[ Plugin::ns() ] ) ) {

			// Abort if the form's nonce is not correct or expired.
			if ( ! wp_verify_nonce( $_POST['_wpnonce'], Plugin::ns() ) ) {
				wp_die( __( 'Nonce failed.', 'kntnt-taxonomy-meta-tag' ) );
			}

			// Update options.
			$this->update_options( $_POST[ Plugin::ns() ] );

		}

		// Variables that will be visible for the settings-page template.
		$ns = Plugin::ns();
		$title = $this->page_title();
		$fields = $this->fields();
		$values = Plugin::option();

		// Default values that will be visible for the settings-page template.
		foreach ( $fields as $id => $field ) {

			// Set default if no value is saved.
			if ( ! isset( $values[ $id ] ) && isset( $field['default'] ) ) {
				$values[ $id ] = $field['default'];
			}

			// Filter saved value before outputting it.
			if ( isset( $field['filter-before'] ) ) {
				$filter = $field['filter-before'];
				$values[ $id ] = $filter( $values[ $id ] );
			}

		}

		// Render settings page; include the settings-page template.
		include $this->settings_page_template();

	}

	/**
	 * Validate, sanitize and save field values.
	 */
	private function update_options( $opt ) {

		$fields = $this->fields();

		$validates = true;

		// Validate inputted values.
		foreach ( $opt as $id => &$val ) {
			if ( isset( $fields[ $id ]['validate'] ) ) {
				$validator = $fields[ $id ]['validate'];
				if ( ! $validator( $val ) ) {
					if ( isset( $fields[ $id ]['validate-error-message'] ) ) {
						$message = $fields[ $id ]['validate-error-message'];
					}
					else if ( $fields[ $id ]['label'] ) {
						$message = sprintf( __( '<strong>ERROR:</strong> Invalid data in the field <em>%s</em>.', 'kntnt-personalized-content' ), $fields[ $id ]['label'] );
					}
					else {
						$message = __( '<strong>ERROR:</strong> Please review the settings and try again.', 'kntnt-personalized-content' );
					}
					$this->notify_admin( $message, 'error' );
					$validates = false;
				}
			}
		}

		if ( $validates ) {

			// Filter inputted values.
			foreach ( $opt as $id => &$val ) {
				if ( isset( $fields[ $id ]['filter-after'] ) ) {
					$filter = $fields[ $id ]['filter-after'];
					$opt[ $id ] = $filter( $val );
				}
			}

			update_option( Plugin::ns(), $opt );
			if ( isset( $fields[ $id ]['validate-success-message'] ) ) {
				$message = $fields[ $id ]['validate-success-message'];
			}
			else {
				$message = __( 'Successfully saved settings.', 'kntnt-personalized-content' );
			}
			$this->notify_admin( $message, 'success' );

		}

	}

	private function notify_admin($message, $type) {
		echo "<div class=\"notice notice-$type is-dismissible\"><p>$message</p></div>";
	}
	
}
