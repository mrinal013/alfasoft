<?php
namespace Contact_Management\Admin;

trait Metabox {
	public function person_metabox_init() {
		add_action( 'add_meta_boxes', [ $this, 'person_rapater_meta_boxes' ] );
		add_action( 'save_post', [ $this, 'save' ] );
	}

	public function person_rapater_meta_boxes() {
		add_meta_box( 'single-person-data', __( 'Contact', 'contact-management' ), [ $this, 'contact_management_meta_box_callback'], 'person', 'normal', 'default' );
	}

	function contact_management_meta_box_callback($post) {
		add_thickbox();
		wp_nonce_field( 'repeterBox', 'formType' );

		$response = file_get_contents('https://restcountries.com/v2/all');
		$response = json_decode($response);
		$country_codes = [];
		if ( ! empty( $response ) ) {
			foreach ( $response as $key => $value ) {
				$name = $value->name;
				$calling_code = $value->callingCodes[0];
				$country_codes[] = $name . '(' . $calling_code . ')';
			}
		}

		$contacts = get_post_custom( $post->ID );
		$contacts = array_intersect_key($contacts, array_flip(preg_grep("/^contact-/", array_keys($contacts))));
		// echo '<pre>';
		// print_r( $contacts );
		// echo '</pre>';
		?>
		
		
		<div id="my-content-id" style="display:none;">
			<div id="wrapper-<?php echo $post->ID; ?>">
				<label for="">Country code</label>
				<select class="js-example-basic-single"  width="75%">
					<?php
					if ( ! empty( $country_codes ) ) {
						foreach ( $country_codes as $key => $country_code ) {
							?>
							<option value="<?php echo $key; ?>"><?php echo $country_code; ?></option>
							<?php
						}
					}
					?>
				</select>
				<p>
				<label>Number</label>	
				<input type="tel" class="number" >
				</p>
				<a class="button add-button" data-id=<?php echo $post->ID; ?>>Add/Edit</a>
			</div>
		</div>

		<table class="contact-management-table">
			<tbody>
			<?php
			if ( ! empty( $contacts ) ) :
				foreach ( $contacts as $key => $contact ) {
					// print_r($contact);
					?>
					<tr>
						<td>
							<?php
							// $array = $contact[0];
							// echo '<pre>';
							// print_r( $contact );
							// echo '</pre>';
							?>
						</td>
						<td>Number</td>
						<td><a href="#TB_inline?&width=600&height=550&inlineId=my-content-id" class="thickbox"><?php echo __( 'Edit', 'contact-managment' ); ?></a></td>
						<td><a class="button remove-row" href="#1"><?php echo __( 'Remove', 'mcq' ); ?></a></td>
					</tr>
					<?php
				}
			endif;
				?>
			</tbody>
		</table>
		<p><a href="#TB_inline?&width=600&height=550&inlineId=my-content-id" class="thickbox button"><?php echo __( 'Add another', 'contact-managment' ); ?></a></p>
		
		<?php
	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save( $post_id ) {

		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */
		if ( isset( $_POST['formType'] ) ) {
			if ( ! wp_verify_nonce( $_POST['formType'], 'repeterBox' ) ) {
				return;
			}

			if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
				return;
			}

			// Check the user's permissions.
			if ( 'person' == $_POST['post_type'] ) {
				if ( ! current_user_can( 'edit_page', $post_id ) ) {
					return $post_id;
				}
			} else {
				if ( ! current_user_can( 'edit_post', $post_id ) ) {
					return $post_id;
				}
			}

			/* OK, it's safe for us to save the data now. */

			if ( isset( $_POST['answer'] ) ) {
				update_post_meta( $post_id, 'mcq_answers', array_filter( $_POST['answer'] ) );
			} else {
				delete_post_meta( $post_id, 'mcq_answers' );
			}
		}
	}
}
