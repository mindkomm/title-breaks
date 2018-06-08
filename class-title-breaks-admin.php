<?php

defined( 'ABSPATH' ) or exit;

/**
 * Class Title_Breaks_Admin
 */
class Title_Breaks_Admin {
	/**
	 * The nonce name.
	 *
	 * @var string A nonce name.
	 */
	private static $nonce_name = 'title_breaks_nonce';

	/**
	 * Init hooks.
	 */
	public function init() {
		add_filter( 'pre_post_title', array( $this, 'filter_post_title' ) );

		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save_meta_box' ) );
	}

	/**
	 * Whenever a post is saved, removed all placeholders from post_title.
	 *
	 * The post_title is not the place to put in placeholders, because it can lead to comaptibility
	 * issues. There a custom field to enter a post title instead.
	 *
	 * @param $title
	 *
	 * @return string
	 */
	public function filter_post_title( $title ) {
		$title_breaks = new Title_Breaks();

		return $title_breaks->remove_placeholders( $title );
	}

	/**
	 * Add meta box.
	 *
	 * Add an informational meta box to the side with a low priority.
	 */
	public function add_meta_box() {
		/**
		 * Filters the context to use for the meta box.
		 *
		 * Can be a value of `normal`, `side` or `advanced`.
		 */
		$context = apply_filters( 'title_breaks/meta_box/context', 'normal' );

		/**
		 * Filters the priority to use for the meta box.
		 *
		 * Can be a value of `default`, `low` or `high`.
		 */
		$priority = apply_filters( 'title_breaks/meta_box/priority', 'high' );

		add_meta_box(
			'title_breaks_info',
			__( 'Title Breaks', 'title-breaks' ),
			array( $this, 'render_meta_box' ),
			null,
			$context,
			$priority
		);
	}

	/**
	 * Display meta box content.
	 *
	 * @param WP_Post $post The post.
	 */
	public function render_meta_box( $post ) {
		wp_nonce_field( basename( __FILE__ ), self::$nonce_name );

		$label = __( 'Control how your titles break by including one of the following placeholders in your post title:', 'title-breaks' );

		$breaks = array(
			'%-%' => __( 'Soft Hyphen', 'title-breaks' ),
			'%%%' => __( 'Hard Break', 'title-breaks' ),
		);

		?>

		<p><?php echo esc_textarea( $label ); ?> <?php foreach ( $breaks as $code => $break ) : ?><code><?php esc_attr_e( $code ); ?></code>&nbsp;<?php esc_attr_e( $break ); ?><?php if ( array_keys($breaks )[ count($breaks ) - 1 ] !== $code ) : ?>, <?php endif; ?><?php endforeach; ?></p>

		<p>
			<label for="title-breaks-input" class="post-attributes-label"><?php _e( 'Title for display', 'title-breaks' ); ?></label><br>
			<input class="widefat" type="text" id="title-breaks-input" name="title-breaks-input" value="<?php echo esc_attr( get_post_meta( $post->ID, Title_Breaks::$meta_key, true ) ); ?>">
		</p>

		<?php
	}

	/**
	 * Save post meta.
	 *
	 * @param int $post_id The post ID.
	 */
	public function save_meta_box( $post_id ) {
		if ( ! isset( $_POST[ self::$nonce_name ] )
			|| ! wp_verify_nonce( $_POST[ self::$nonce_name ], basename( __FILE__ ) )
		) {
			return;
		}

		$new_meta_value = isset( $_POST['title-breaks-input'] )
			? sanitize_text_field( $_POST['title-breaks-input'] )
			: null;

		$meta_value = get_post_meta( $post_id, Title_Breaks::$meta_key, true );

		if ( $new_meta_value && $meta_value !== $new_meta_value ) {
			update_post_meta( $post_id, Title_Breaks::$meta_key, $new_meta_value );
		} elseif ( '' === $new_meta_value && $meta_value ) {
			delete_post_meta( $post_id, Title_Breaks::$meta_key, $meta_value );
		}
	}
}
