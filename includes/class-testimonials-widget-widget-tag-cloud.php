<?php
/**
Aihrus Testimonials
Copyright (C) 2014  Michael Cannon

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

require_once AIHR_DIR_INC . 'class-aihrus-widget.php';

if ( class_exists( 'Testimonials_Widget_Widget_Tag_Cloud' ) )
	return;


class Testimonials_Widget_Widget_Tag_Cloud extends Aihrus_Widget {
	const ID = 'testimonials_widget_widget_tag_cloud';

	public function __construct() {
		$classname   = __CLASS__;
		$description = esc_html__( 'A cloud of your most used testimonials\' tags .', 'testimonials-widget' );
		$id_base     = self::ID;
		$title       = esc_html__( 'Testimonials Tag Cloud', 'testimonials-widget' );

		parent::__construct( $classname, $description, $id_base, $title );
	}


	/**
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 */
	public static function get_content( $instance, $widget_number ) {
		echo '<div class="tagcloud">';

		$args = array(
			'taxonomy' => $instance['taxonomy'],
		);
		wp_tag_cloud( apply_filters( 'testimonials_widget_widget_tag_cloud_args', $args ) );

		echo "</div>\n";
	}


	/**
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 */
	public static function form_parts( $instance = null, $number = null ) {
		$form_parts = array();

		$form_parts['title'] = array(
			'title' => esc_html__( 'Widget Title', 'testimonials-widget' ),
			'std' => esc_html__( 'Testimonials Tag Cloud', 'testimonials-widget' ),
			'validate' => 'wp_kses_post',
		);

		$form_parts['title_link'] = array(
			'title' => esc_html__( 'Title Link', 'testimonials-widget' ),
			'desc' => esc_html__( 'URL, path, or post ID to link widget title to. Ex: http://example.com/stuff, /testimonials, or 123', 'testimonials-widget' ),
			'validate' => 'wp_kses_data',
		);

		$use_cpt_taxonomy = tw_get_option( 'use_cpt_taxonomy', false );
		if ( ! $use_cpt_taxonomy ) {
			$options = array(
				'category' => esc_html__( 'Category', 'testimonials-widget' ),
				'post_tag' => esc_html__( 'Tags', 'testimonials-widget' ),
			);

			$std = 'post_tag';
		} else {
			$options = array(
				Testimonials_Widget::$cpt_category => esc_html__( 'Category', 'testimonials-widget' ),
				Testimonials_Widget::$cpt_tags => esc_html__( 'Tags', 'testimonials-widget' ),
			);

			$std = Testimonials_Widget::$cpt_tags;
		}

		$form_parts['taxonomy'] = array(
			'title' => esc_html__( 'Taxonomy', 'testimonials-widget' ),
			'type' => 'select',
			'choices' => $options,
			'std' => $std,
		);

		foreach ( $form_parts as $id => $parts ) {
			$form_parts[ $id ] = wp_parse_args( $parts, self::$default );
		}

		$form_parts = apply_filters( 'testimonials_widget_widget_tag_cloud_options', $form_parts );

		return $form_parts;
	}
}


?>
