<?php
namespace MCQ\Admin;

trait Metabox {
	public function mcq_metabox_init() {
		add_action( 'add_meta_boxes', [ $this, 'mcq_rapater_meta_boxes'] );
		add_action( 'save_post', [ $this, 'save' ] );
	}

	public function mcq_rapater_meta_boxes() {
		add_meta_box( 'single-repeter-data', __( 'Answers', 'mcq' ), [ $this, 'mcq_meta_box_callback'], 'mcq', 'normal', 'default' );
	}

	function mcq_meta_box_callback($post) {
		wp_nonce_field( 'repeterBox', 'formType' );

		$mcq_answers 	= get_post_meta( $post->ID, 'mcq_answers', true );
		$correct_answer = get_post_meta( $post->ID, 'mcq_correct', true );
		?>
		<script type="text/javascript">
			jQuery(document).ready(function( $ ){
				$( '#add-row' ).on( 'click', function() {
					var row = $( '.empty-row.custom-repeter-text' ).clone(true);
					row.removeClass( 'empty-row custom-repeter-text' ).css('display','table-row');
					row.insertBefore( '#repeatable-fieldset-one tbody>tr:last' );
					return false;
				});

				$( '.remove-row' ).on( 'click', function() {
					$(this).parents( 'tr' ).remove();
					return false;
				});
				$( '.correct_answer' ).on( 'click', function (e) {
					let prev= $(this).prev();
					console.log( $( this ).val() )
					$(this).val( $( prev ).val() )
				})
			});
		</script>

		<table id="repeatable-fieldset-one" width="100%">
			<tbody>
			<?php
			if ( ! empty( $mcq_answers ) ) :
				foreach ( $mcq_answers as $key => $field ) {
					?>
					<tr>
						<td><input type="text"  style="width:98%;" name="answer[]" value="<?php if( isset( $field ) && ! empty( $field ) && ( '' !== $field ) ) echo esc_attr( $field ); ?>" placeholder="<?php echo __( 'Answer', 'mcq' ); ?>" /></td>
						<td><?php echo __( 'Correct?', 'mcq' ); ?><input type="radio" name="correct" value="<?php echo $key; ?>" <?php echo ( $key == $correct_answer ) ? ' checked' : ''; ?> /></td>
						<td><a class="button remove-row" href="#1"><?php echo __( 'Remove', 'mcq' ); ?></a></td>
					</tr>
					<?php
				}
			else :
				?>
				<tr>
					<td><input type="text"   style="width:98%;" name="answer[]" placeholder="<?php echo __( 'Answer', 'mcq' ); ?>"/></td>
					<td><?php echo __( 'Correct?', 'mcq' ); ?><input type="radio" name="correct" value="N" /></td>
					<td><a class="button  cmb-remove-row-button button-disabled" href="#"><?php echo __( 'Remove', 'mcq' ); ?></a></td>
				</tr>
			<?php endif; ?>
			<tr class="empty-row custom-repeter-text" style="display: none">
				<td><input type="text" style="width:98%;" name="answer[]" placeholder="<?php echo __( 'Answer', 'mcq' ); ?>"/></td>
				<td><?php echo __( 'Correct?', 'mcq' ); ?><input type="radio" class="correct_answer" name="correct" value=""/></td>
				<td><a class="button remove-row" href="#"><?php echo __( 'Remove', 'mcq' ); ?></a></td>
			</tr>

			</tbody>
		</table>
		<p><a id="add-row" class="button" href="#"><?php echo __( 'Add another', 'mcq' ); ?></a></p>
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

			if ( isset( $_POST['answer'] ) ) {
				update_post_meta( $post_id, 'mcq_answers', array_filter( $_POST['answer'] ) );
			} else {
				delete_post_meta( $post_id, 'mcq_answers' );
			}

			if ( isset( $_POST['correct'] ) ) {
				update_post_meta( $post_id, 'mcq_correct', $_POST['correct'] );
			} else {
				delete_post_meta( $post_id, 'mcq_correct' );
			}
		}
	}
}
