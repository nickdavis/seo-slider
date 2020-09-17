<?php
/**
 * This file adds inline styles for the SEO Slider plugin.
 *
 * @package SEOSlider
 */

add_action( 'wp', 'nd_seo_slider_enqueue_inline_styles', 99 );
function nd_seo_slider_enqueue_inline_styles() {
	$slider_ids = nd_seo_slider_get_slider_ids();

	if ( empty( $slider_ids ) ) {
		return;
	}

	add_action( 'wp_head', 'nd_seo_slider_output_inline_text_width_styles', 99 );
	add_action( 'wp_head', 'nd_seo_slider_output_inline_per_slide_overlay_styles', 99 );
	add_action( 'wp_head', 'nd_seo_slider_output_inline_per_slide_text_color_styles', 99 );
	add_action( 'wp_head', 'nd_seo_slider_output_inline_per_slide_text_width_styles', 99 );
}

/**
 * Renders inline styles for the hero, if set.
 */
function nd_seo_slider_output_inline_text_width_styles(): void {
	$inline_css = '';
	$slider_ids = nd_seo_slider_get_slider_ids();

	foreach ( $slider_ids as $slider_id ) {
		$slides = nd_seo_slider_get_slides( $slider_id );

		if ( ! isset( $slides ) || empty( $slides ) ) {
			return;
		}

		$max_width = get_post_meta( $slider_id, 'seo_slider_text_width', true );

		/**
		 * Should not be possible as nd_seo_slider_get_slider_id() wouldn't return
		 * anything, but leave in for now.
		 */
		if ( ! isset( $max_width ) || empty( $max_width ) ) {
			return;
		}

		$max_width = (int) $max_width;

		$inline_css = "
			    .slick-slider-{$slider_id} .slick-content {
	                max-width: {$max_width}px;
                }";

	}

	wp_add_inline_style( seo_slider_get_slug(), $inline_css );
}

function nd_seo_slider_output_inline_per_slide_overlay_styles(): void {
	$inline_css = '';
	$slider_ids = nd_seo_slider_get_slider_ids();

	foreach ( $slider_ids as $slider_id ) {
		$slides = nd_seo_slider_get_slides( $slider_id );

		if ( ! isset( $slides ) || empty( $slides ) ) {
			return;
		}

		$slide_count = 0;

		foreach ( $slides as $slide ) {
			if ( empty( $slide['seo_slider_overlay'] ) ) {
				$slide_count ++;
				continue;
			}

			$bg_color            = esc_html( $slide['seo_slider_overlay'] );
			$slide_count_doubled = count( $slides ) + $slide_count; // To avoid FOUC on loop.

			$inline_css .= "
				.slick-slider-{$slider_id} [data-slick-index='{$slide_count}'] .slick-overlay,
				.slick-slider-{$slider_id} [data-slick-index='{$slide_count_doubled}'] .slick-overlay {
	                background-color: {$bg_color};
                }";

			$slide_count ++;
		}

	}

	wp_add_inline_style( seo_slider_get_slug(), $inline_css );
}

function nd_seo_slider_output_inline_per_slide_text_color_styles(): void {
	$inline_css = '';
	$slider_ids = nd_seo_slider_get_slider_ids();

	foreach ( $slider_ids as $slider_id ) {
		$slides = nd_seo_slider_get_slides( $slider_id );

		if ( ! isset( $slides ) || empty( $slides ) ) {
			return;
		}

		$slide_count = 0;

		foreach ( $slides as $slide ) {
			if ( empty( $slide['seo_slider_text_color'] ) ) {
				$slide_count ++;
				continue;
			}

			$text_color          = esc_html( $slide['seo_slider_text_color'] );
			$slide_count_doubled = count( $slides ) + $slide_count; // To avoid FOUC on loop.

			$inline_css .= "
				.slick-slider-{$slider_id} [data-slick-index='{$slide_count}'],
				.slick-slider-{$slider_id} [data-slick-index='{$slide_count}'] p,
				.slick-slider-{$slider_id} [data-slick-index='{$slide_count}'] h1,
				.slick-slider-{$slider_id} [data-slick-index='{$slide_count}'] h2,
				.slick-slider-{$slider_id} [data-slick-index='{$slide_count}'] h3,
				.slick-slider-{$slider_id} [data-slick-index='{$slide_count}'] h4,
				.slick-slider-{$slider_id} [data-slick-index='{$slide_count}'] h5,
				.slick-slider-{$slider_id} [data-slick-index='{$slide_count}'] h6,
				.slick-slider-{$slider_id} [data-slick-index='{$slide_count}'] li,
				.slick-slider-{$slider_id} [data-slick-index='{$slide_count_doubled}'],
				.slick-slider-{$slider_id} [data-slick-index='{$slide_count_doubled}'] p,
				.slick-slider-{$slider_id} [data-slick-index='{$slide_count_doubled}'] h1,
				.slick-slider-{$slider_id} [data-slick-index='{$slide_count_doubled}'] h2,
				.slick-slider-{$slider_id} [data-slick-index='{$slide_count_doubled}'] h3,
				.slick-slider-{$slider_id} [data-slick-index='{$slide_count_doubled}'] h4,
				.slick-slider-{$slider_id} [data-slick-index='{$slide_count_doubled}'] h5,
				.slick-slider-{$slider_id} [data-slick-index='{$slide_count_doubled}'] h6,
				.slick-slider-{$slider_id} [data-slick-index='{$slide_count_doubled}'] li {
	                color: {$text_color} !important;
                }";

			$slide_count ++;
		}

	}

	wp_add_inline_style( seo_slider_get_slug(), $inline_css );
}

function nd_seo_slider_output_inline_per_slide_text_width_styles(): void {
	$inline_css = '';
	$slider_ids = nd_seo_slider_get_slider_ids();

	foreach ( $slider_ids as $slider_id ) {
		$slides = nd_seo_slider_get_slides( $slider_id );

		if ( ! isset( $slides ) || empty( $slides ) ) {
			return;
		}

		$slide_count = 0;

		foreach ( $slides as $slide ) {
			if ( empty( $slide['seo_slider_text_width'] ) ) {
				$slide_count ++;
				continue;
			}

			$max_width           = (int) $slide['seo_slider_text_width'];
			$slide_count_doubled = count( $slides ) + $slide_count; // To avoid FOUC on loop.

			$inline_css .= "
			    .slick-slider-{$slider_id} [data-slick-index='{$slide_count}'] .slick-content,
			    .slick-slider-{$slider_id} [data-slick-index='{$slide_count_doubled}'] .slick-content {
	                max-width: {$max_width}px;
                }";

			$slide_count ++;
		}

	}

	wp_add_inline_style( seo_slider_get_slug(), $inline_css );
}

/**
 * Returns all the slider id (shortcodes) for the current page.
 *
 * @return array
 */
function nd_seo_slider_get_slider_ids(): array {
	/* @url https://wordpress.stackexchange.com/questions/340814/get-list-of-shortcodes-from-content */
	preg_match_all(
		'/' . get_shortcode_regex() . '/',
		get_the_content( null, false, get_the_ID() ),
		$matches,
		PREG_SET_ORDER
	);

	$shortcodes = [];
	foreach ( $matches as $shortcode ) {
		$shortcodes[] = $shortcode[0];
	}

	$slider_ids = [];
	foreach ( $shortcodes as $shortcode ) {
		// If string doesn't start with, bail...
		if ( strpos( $shortcode, '[slider' ) !== 0 ) {
			continue;
		}

		/* @url https://stackoverflow.com/a/24187909 */
		if ( preg_match( '/id="(.*?)"/', $shortcode, $match ) == 1 ) {
			$slider_ids[] = (int) $match[1];
		}
	}

	return apply_filters( 'nd_seo_slider_ids', $slider_ids );
}

/**
 * Gets the group of slides for the passed slider (post) id.
 *
 * @param int $slider_id
 * @return array
 */
function nd_seo_slider_get_slides( int $slider_id ): array {
	return get_post_meta( $slider_id, 'seo_slider_slides', true );
}
