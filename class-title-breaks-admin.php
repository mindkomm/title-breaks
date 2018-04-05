<?php

/**
 * Class Title_Breaks_Admin
 */
class Title_Breaks_Admin {
	/**
	 * Init hooks.
	 */
	public function init() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
	}

	/**
	 * Add meta box.
	 *
	 * Add an informational meta box to the side with a low priority.
	 */
	public function add_meta_box() {
		add_meta_box(
			'title_breaks_info',
			__( 'Title Breaks', 'title-breaks' ),
			array( $this, 'meta_box_content' ),
			null,
			'side',
			'low'
		);
	}

	/**
	 * Display meta box content.
	 */
	public function meta_box_content() {
		$label = __( 'Control how your titles break by including one of the following placeholders in your post title.', 'title-breaks' );

		$breaks = array(
			'%-%' => __( 'Soft Hyphen', 'title-breaks' ),
			'%%%' => __( 'Hard Break', 'title-breaks' ),
		);

		echo '<div>' . esc_textarea( $label ) . '</div>';

		echo '<ul>';

		foreach ( $breaks as $code => $break ) {
			echo '<li><code>' . esc_attr( $code ) . '</code>&nbsp;' . esc_attr( $break ) . '</li>';
		}

		echo '</ul>';
	}
}
