<?php

namespace Tarosky\ConversionSlots;

use Tarosky\ConversionSlots\Pattern\SingletonPattern;

/**
 * Script renderer.
 *
 * @package taro-cs
 */
class Renderer extends SingletonPattern {

	/**
	 * {@inheritdoc}
	 */
	protected function init() {
		add_action( 'wp_head', [ $this, 'render_head' ], 11 );
		add_action( 'wp_footer', [ $this, 'render_footer' ], 1 );
	}

	/**
	 * Render head tag.
	 *
	 * @return void
	 */
	public function render_head() {
		$this->render( 'head' );
	}

	/**
	 * $ender footer
	 *
	 * @return void
	 */
	public function render_footer() {
		$this->render( 'footer' );
	}

	/**
	 * Render at the position.
	 *
	 * @param string $position Position name.
	 * @return void
	 */
	public function render( $position ) {
		$query = new \WP_Query( [
			'post_type'      => PostType::POST_TYPE,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => [
				'menu_order' => 'DESC',
			],
			'meta_query'     => [
				[
					'key'   => PostType::META_KEY_POSITION,
					'value' => $position,
				],
			],
		] );
		if ( ! $query->have_posts() ) {
			// No tag.
			return;
		}
		$tags = [];
		foreach ( $query->posts as $post ) {
			$condition = Conditions::instance( get_post_meta( $post->ID, PostType::META_KEY_CONDITION, true ) );
			if ( ! $condition ) {
				// Condition not found.
				continue;
			}
			$arg = get_post_meta( $post->ID, PostType::META_KEY_CONDITION_ARG, true );
			if ( ! $condition->is_available( $arg ) ) {
				// Not satisfy condition.
				continue;
			}
			$tag = get_post_meta( $post->ID, PostType::META_KEY_TAG, true );
			if ( empty( $tag ) ) {
				// No tag.
				continue;
			}
			$tag = $condition->render( $tag, $post, $arg );
			if ( get_post_meta( $post->ID, PostType::META_KEY_WTIH_SCRIPT, true ) ) {
				$tag = sprintf( "<script>\n%s\n</script>", $tag );
			}
			$tags[] = $tag;
		}
		if ( empty( $tags ) ) {
			// No tags.
			return;
		}
		// Render all tags.
		echo '<!-- Conversion Tags // -->' . "\n";
		echo implode( "\n", $tags );
		echo '<!-- // Conversion Tags -->' . "\n";
	}
}
