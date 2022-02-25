<?php

namespace Tarosky\ConversionSlots;


use Tarosky\ConversionSlots\Pattern\SingletonPattern;

/**
 * Register Post handler
 *
 *
 * @package taro-cs
 */
class PostType extends SingletonPattern {

	const POST_TYPE = 'conversion-tag';

	const META_KEY_POSITION = '_cs_position';

	const META_KEY_TAG = '_cs_tag';

	const META_KEY_WTIH_SCRIPT = '_cs_wrap_with_tag';

	const META_KEY_CONDITION = '_cs_condition';

	const META_KEY_CONDITION_ARG = '_cs_condition_arg';

	/**
	 * {@inheritdoc}
	 */
	protected function init() {
		add_action( 'init', [ $this, 'register_post_type' ] );
		add_action( 'add_meta_boxes', [ $this, 'register_meta_boxes' ] );
		add_action( 'save_post_' . self::POST_TYPE, [ $this, 'save_post' ], 10, 2 );
	}

	/**
	 * Register post type.
	 *
	 * @return void
	 */
	public function register_post_type() {
		register_post_type( self::POST_TYPE, [
			'label'            => __( 'Conversion Tag', 'taro-cs' ),
			'show_in_rest'     => false,
			'supports'         => [ 'title', 'author' ],
			'public'           => false,
			'show_ui'          => true,
			'show_in_nav_menu' => false,
			'menu_position'    => 99,
			'menu_icon'        => 'dashicons-editor-code',
			'capability_type'  => 'page',
		] );
	}

	/**
	 * Register meta box.
	 *
	 * @param string $post_type Post type.
	 * @return void
	 */
	public function register_meta_boxes( $post_type ) {
		if ( self::POST_TYPE !== $post_type ) {
			return;
		}
		add_meta_box( 'position', __( 'Position', 'taro-cs' ), [ $this, 'render_position_meta_box' ], self::POST_TYPE, 'side' );
		add_meta_box( 'priority', __( 'Priority', 'taro-cs' ), [ $this, 'render_priority_meta_box' ], self::POST_TYPE, 'side' );
		add_meta_box( 'conversion-tag', __( 'Conversion Tag', 'taro-cs' ), [ $this, 'render_tag_meta_box' ], self::POST_TYPE );
		add_meta_box( 'condition', __( 'Conditions', 'taro-cs' ), [ $this, 'render_condition_meta_box' ], self::POST_TYPE );
	}

	/**
	 * Save post.
	 *
	 * @param int      $post_id Post ID.
	 * @param \WP_Post $post    Post object.
	 * @return void
	 */
	public function save_post( $post_id, $post ) {
		if ( ! wp_verify_nonce( filter_input( INPUT_POST, '_tarocsnonce' ), 'update_taro_cs' ) ) {
			return;
		}
		// Save position.
		update_post_meta( $post_id, self::META_KEY_POSITION, filter_input( INPUT_POST, 'cs-position' ) );
		update_post_meta( $post_id, self::META_KEY_TAG, filter_input( INPUT_POST, 'cs-cvtag' ) );
		update_post_meta( $post_id, self::META_KEY_WTIH_SCRIPT, filter_input( INPUT_POST, 'cs-wrap-with-js' ) );
		update_post_meta( $post_id, self::META_KEY_CONDITION, filter_input( INPUT_POST, 'cs-condition' ) );
		update_post_meta( $post_id, self::META_KEY_CONDITION_ARG, filter_input( INPUT_POST, 'cs-condition-arg' ) );
	}

	/**
	 * Get set tag position.
	 *
	 * @param \WP_Post $post Post object
	 * @return void
	 */
	public function render_position_meta_box( $post ) {
		wp_nonce_field( 'update_taro_cs', '_tarocsnonce', false );
		?>
		<select name="cs-position">
			<?php foreach ( Positions::get() as $key => $position ) : ?>
			<option value="<?php echo esc_attr( $position['value'] ); ?>"<?php selected( $position['value'], get_post_meta( $post->ID, self::META_KEY_POSITION, true ) ); ?>>
				<?php echo esc_html( $position['label'] ); ?>
			</option>
			<?php endforeach; ?>
		</select>
		<?php
	}

	/**
	 * Render priority meta box
	 *
	 * @param \WP_Post $post Post object
	 *
	 * @return void
	 */
	public function render_priority_meta_box( $post ) {
		?>
		<input type="number" name="menu_order" value="<?php echo esc_attr( $post->menu_order ); ?>" />
		<p class="description">
			<?php esc_html_e( 'The higher proceeds.', 'taro-cs' ); ?>
		</p>
		<?php
	}

	/**
	 * Render conversion tag meta box.
	 *
	 * @param \WP_Post $post Post object.
	 * @return void
	 */
	public function render_tag_meta_box( $post ) {
		?>
		<p>
			<label>
				<?php esc_html_e( 'Conversion Tag', 'taro-cs' ); ?><br />
				<textarea name="cs-cvtag" rows="10" style="width:100%; box-sizing: border-box; font-family: monospace; background-color: #666; color: #fff;"><?php echo esc_textarea( get_post_meta( $post->ID, self::META_KEY_TAG, true ) ); ?></textarea>
			</label>
		</p>
		<p>
			<label>
				<input type="checkbox" name="cs-wrap-with-js" value="1"<?php checked( 1, get_post_meta( $post->ID, self::META_KEY_WTIH_SCRIPT, true ) ); ?> />
				<?php esc_html_e( 'Wrap with <script> tag.', 'taro-cs' ); ?>
			</label>
		</p>
		<?php
	}

	/**
	 * Register meta box.
	 *
	 * @param \WP_Post $post post type object.
	 * @return void
	 */
	public function render_condition_meta_box( $post ) {
		$conditions = Conditions::get();
		if ( empty( $conditions ) ) {
			printf(
				'<p class="description">%s</p>',
				esc_html__( 'No condition exists.', 'taro-cs' )
			);
			return;
		}
		?>
		<select name="cs-condition">
			<?php foreach ( $conditions as $value => $condition ) : ?>
				<option value="<?php echo esc_attr( $value ); ?>"<?php selected( $value, get_post_meta( $post->ID, self::META_KEY_CONDITION, true ) ); ?>>
					<?php echo esc_html( $condition->label() ); ?>
				</option>
			<?php endforeach; ?>
		</select>
		<p>
			<label>
				<?php esc_html_e( 'Option Argument', 'taro-cs' ); ?><br />
				<input type="text" name="cs-condition-arg" value="<?php echo esc_attr( get_post_meta( $post->ID, self::META_KEY_CONDITION_ARG, true ) ); ?>" />
			</label>
		</p>
		<?php
	}
}
