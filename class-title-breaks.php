<?php

defined( 'ABSPATH' ) or exit;

/**
 * Class Title_Breaks
 */
class Title_Breaks {
	/**
	 * Meta key to use for custom title.
	 *
	 * @var string A meta key.
	 */
	public static $meta_key = 'post_title_display';

	/**
	 * Shy character.
	 */
	const SHY = '&#173;';

	/**
	 * Init hooks.
	 */
	public function init() {
		// Filter the title that is used in the frontend.
		add_filter( 'the_title', array( $this, 'filter_title' ), 10, 2 );
	}

	/**
	 * Filter post title.
	 *
	 * @param string $title A post title.
	 * @param null   $post_id The post ID.
	 *
	 * @return string The filtered title.
	 */
	public function filter_title( $title, $post_id = null ) {
		if ( $post_id ) {
			$title_display = get_post_meta( $post_id, self::$meta_key, true );

			// Bail out if no custom display title was set.
			if ( empty( $title_display ) ) {
				return $title;
			}

			$title = $title_display;
		}

		/**
		 * Filters the character to use for hard breaks.
		 *
		 * @api
		 * @param string $break_character The character to use for hard breaks.
		 */
		$break = apply_filters( 'title_breaks/character/hard_break', '<br>' );

		// Add shy character
		$title = str_replace( '%-%', self::SHY, $title );

		// Add line breaks
		$title = str_replace( '%%%', $break, $title );

		return $title;
	}

	/**
	 * Remove placeholders from a title.
	 *
	 * @param string $title The title to filter.
	 *
	 * @return string The filtered title.
	 */
	public function remove_placeholders( $title ) {
		$title = str_replace( [ '%-%', '%%%' ], '', $title );

		return $title;
	}
}
