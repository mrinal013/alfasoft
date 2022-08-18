<?php
namespace MCQ\Admin;

trait CPT {

	public function mcq_post_type_init() {

		$labels = array(
			'name'                  => _x( 'MCQ', 'Post type general name', 'textdomain' ),
			'singular_name'         => _x( 'MCQ', 'Post type singular name', 'textdomain' ),
			'menu_name'             => _x( 'MCQs', 'Admin Menu text', 'textdomain' ),
			'name_admin_bar'        => _x( 'MCQ', 'Add New on Toolbar', 'textdomain' ),
			'add_new'               => __( 'Add New', 'textdomain' ),
			'add_new_item'          => __( 'Add New MCQ', 'textdomain' ),
			'new_item'              => __( 'New MCQ', 'textdomain' ),
			'edit_item'             => __( 'Edit MCQ', 'textdomain' ),
			'view_item'             => __( 'View MCQ', 'textdomain' ),
			'all_items'             => __( 'All MCQ', 'textdomain' ),
			'search_items'          => __( 'Search MCQs', 'textdomain' ),
			'parent_item_colon'     => __( 'Parent MCQs:', 'textdomain' ),
			'not_found'             => __( 'No MCQs found.', 'textdomain' ),
			'not_found_in_trash'    => __( 'No MCQs found in Trash.', 'textdomain' ),
			'featured_image'        => _x( 'MCQ Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
			'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
			'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
			'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
			'archives'              => _x( 'MCQ archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
			'insert_into_item'      => _x( 'Insert into MCQ', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this MCQ', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
			'filter_items_list'     => _x( 'Filter MCQs list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
			'items_list_navigation' => _x( 'MCQs list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
			'items_list'            => _x( 'MCQs list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => false,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'mcq' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title' ),
		);

		register_post_type( 'mcq', $args );
	}
}
