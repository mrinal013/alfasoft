<?php
namespace Contact_Management\Admin;

trait CPT {

	public function person_post_type_init() {

		$labels = array(
			'name'                  => _x( 'Person', 'Post type general name', 'contact-management' ),
			'singular_name'         => _x( 'Person', 'Post type singular name', 'contact-management' ),
			'menu_name'             => _x( 'Persons', 'Admin Menu text', 'contact-management' ),
			'name_admin_bar'        => _x( 'Person', 'Add New on Toolbar', 'contact-management' ),
			'add_new'               => __( 'Add New Person', 'contact-management' ),
			'add_new_item'          => __( 'Add New Person', 'contact-management' ),
			'new_item'              => __( 'New Person', 'contact-management' ),
			'edit_item'             => __( 'Edit Person', 'contact-management' ),
			'view_item'             => __( 'View Person', 'contact-management' ),
			'all_items'             => __( 'All Person', 'contact-management' ),
			'search_items'          => __( 'Search Persons', 'contact-management' ),
			'parent_item_colon'     => __( 'Parent Persons:', 'contact-management' ),
			'not_found'             => __( 'No Person found.', 'contact-management' ),
			'not_found_in_trash'    => __( 'No Person found in Trash.', 'contact-management' ),
			'featured_image'        => _x( 'Person Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'contact-management' ),
			'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'contact-management' ),
			'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'contact-management' ),
			'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'contact-management' ),
			'archives'              => _x( 'Person archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'contact-management' ),
			'insert_into_item'      => _x( 'Insert into Person', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'contact-management' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this Person', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'contact-management' ),
			'filter_items_list'     => _x( 'Filter Persons list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'contact-management' ),
			'items_list_navigation' => _x( 'Persons list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'contact-management' ),
			'items_list'            => _x( 'Persons list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'contact-management' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => false,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'person' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title' ),
			'taxonomies'          => array(),
		);

		register_post_type( 'person', $args );
	}

	public function modify_list_row_actions( $actions, $post ) {
		add_thickbox();

		$response = file_get_contents('https://restcountries.com/v2/all');
		$response = json_decode($response);
		// echo '<pre>';
		// print_r($response);
		// echo '</pre>';
		$country_codes = [];
		if ( ! empty( $response ) ) {
			foreach ( $response as $key => $value ) {
				$name = $value->name;
				$calling_code = $value->callingCodes[0];
				$country_codes[] = $name . '(' . $calling_code . ')';
			}
		}
		?>
		<div id="my-content-id" style="display:none;">
		<select class="js-example-basic-single">
			<?php
			if ( ! empty( $country_codes ) ) {
				foreach ( $country_codes as $key => $country_code ) {
					?>
					<option value="AL"><?php echo $country_code; ?></option>
					<?php
				}
			}
			?>
		</select>
			
		</div>
		<?php
		// Check for your post type.
		if ( $post->post_type == "person" ) {
			$copy_link = '#TB_inline?&width=600&height=550&inlineId=my-content-id';
			// Add the new contact quick link.
			$actions = array_merge( $actions, array(
				'add-contact' => sprintf( '<a href="%1$s" class="thickbox">%2$s</a>',
				esc_url( $copy_link ), 
				'Add Contact'
			)
		   ) );
		   unset( $actions['inline hide-if-no-js'] );
		   unset( $actions[ 'view' ] );
		}

		return $actions;
	}
}
