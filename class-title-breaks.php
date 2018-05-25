<?php

/**
 * Class Title_Breaks
 */
class Title_Breaks {
	/**
	 * Shy character.
	 */
	const SHY = '&#173;';

	/**
	 * Init hooks.
	 */
	public function init() {
		// Filter the title that is used in the frontend.
		add_filter( 'the_title', array( $this, 'filter_title' ) );
		add_filter( 'get_wp_title_rss', array( $this, 'filter_title' ) );

		// Do not filter titles used in <title> tags in the head of the document.
		add_filter( 'single_post_title', array( $this, 'remove_placeholders' ) );
	}

	/**
	 * Filter post title.
	 *
	 * @param string $title A post title.
	 *
	 * @return string The filtered title.
	 */
	public function filter_title( $title ) {
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
