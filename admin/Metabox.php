<?php
namespace MCQ\Admin;

trait Metabox {
	public function mcq_metabox_init() {
		add_action( 'add_meta_boxes', [ $this, 'mcq_rapater_meta_boxes'] );
		add_action( 'save_post', [ $this, 'save' ] );
	}

	public function mcq_rapater_meta_boxes() {
		add_meta_box( 'single-repeter-data', 'Answers', [ $this, 'mcq_meta_box_callback'], 'mcq', 'normal', 'default' );
	}
	function mcq_meta_box_callback($post) {

		$mcq_answers = get_post_meta($post->ID, 'mcq_answers', true);
		$banner_img = get_post_meta($post->ID,'post_banner_img',true);
		wp_nonce_field( 'repeterBox', 'formType' );
		?>
		<script type="text/javascript">
			jQuery(document).ready(function( $ ){
				$( '#add-row' ).on('click', function() {
					var row = $( '.empty-row.custom-repeter-text' ).clone(true);
					row.removeClass( 'empty-row custom-repeter-text' ).css('display','table-row');
					row.insertBefore( '#repeatable-fieldset-one tbody>tr:last' );
					return false;
				});

				$( '.remove-row' ).on('click', function() {
					$(this).parents('tr').remove();
					return false;
				});
				$('.correct_answer').on('click', function (e) {
					let prev= $(this).prev();
					console.log( $( this ).val() )
					$(this).val( $( prev ).val() )
				})
			});



		</script>
<table>
	<tbody>
	<tr>
		<td>Correct? <input type="radio" name="correct" value="Y" /></td>
		<td>Correct? <input type="radio" name="correct" value="N" /></td>

	</tr>
	</tbody>
</table>
		<table id="repeatable-fieldset-one" width="100%">
			<tbody>
			<?php
			if ( $mcq_answers ) :
				foreach ( $mcq_answers as $field ) {
					?>
					<tr>
						<td><input type="text"  style="width:98%;" name="title[]" value="<?php if($field['title'] != '') echo esc_attr( $field['title'] ); ?>" placeholder="Answer" /></td>
						<td>Correct? <input type="radio" name="correct" value="<?php echo 'Y'; ?>" /></td>
						<td><a class="button remove-row" href="#1">Remove</a></td>
					</tr>
					<?php
				}
			else :
				?>
				<tr>
					<td><input type="text"   style="width:98%;" name="title[]" placeholder="Answer"/></td>
					<td>Correct? <input type="radio" name="correct" value="N" /></td>
					<td><a class="button  cmb-remove-row-button button-disabled" href="#">Remove</a></td>
				</tr>
			<?php endif; ?>
			<tr class="empty-row custom-repeter-text" style="display: none">
				<td><input type="text" style="width:98%;" name="title[]" placeholder="Answer"/></td>
				<td>Correct? <input type="radio" class="correct_answer" name="correct" value=""/></td>
				<td><a class="button remove-row" href="#">Remove</a></td>
			</tr>

			</tbody>
		</table>
		<p><a id="add-row" class="button" href="#">Add another</a></p>
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

		if ( ! isset( $_POST['formType'] ) && ! wp_verify_nonce( $_POST['formType'], 'repeterBox' ) ) {
			return;
		}

		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( 'mcq' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}

		/* OK, it's safe for us to save the data now. */
		error_log( print_r($_POST, true));

		$old = get_post_meta( $post_id, 'mcq_answers', true );

		$new = array();
		$titles = $_POST['title'];
		$tdescs = $_POST['tdesc'];
		$count = count( $titles );
		for ( $i = 0; $i < $count; $i++ ) {
			if ( $titles[$i] != '' ) {
				$new[$i]['title'] = stripslashes( strip_tags( $titles[$i] ) );
				$new[$i]['tdesc'] = $tdescs[$i];
			}
		}

		if ( !empty( $new ) && $new != $old ){
			update_post_meta( $post_id, 'mcq_answers', $new );
		} elseif ( empty($new) && $old ) {
			delete_post_meta( $post_id, 'mcq_answers', $old );
		}
	}
}
