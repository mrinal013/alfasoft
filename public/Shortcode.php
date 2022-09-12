<?php
namespace MCQ\Frontend;

trait Shortcode {
    public function shortcode_init() {
        add_shortcode( 'mcq_shortcode', [ $this, 'mcq_shortcode_cb' ] );
    }

    public function mcq_shortcode_cb( $atts, $content = null ) {
        $atts = shortcode_atts( array(
            'category' => 'general',
        ), $atts );

        $category = $atts['category'];

        $args = [
            'post_type'         => 'mcq',
            'posts_per_page'    => -1,
            'fields'            => 'ids',
            'category_name'     => $category
        ];
        $posts = ( new \WP_Query( $args ) )->posts;
        ob_start();
        if ( ! empty( $posts ) ) {
        ?>
        <div id="<?php echo 'mcq-wrapper-' . $category; ?>">
        <?php
        foreach ( $posts as $post ) {
            $question   = get_the_title( $post );
            $answers    = get_post_meta( $post, 'mcq_answers', true );
            $correct    = get_post_meta( $post, 'mcq_correct', true );
            ?>
            <div id="<?php echo 'single-mcq-' . $post; ?>" data-correct="<?php echo $correct; ?>">
                <h3><?php echo $question; ?></h3>
                <?php
                if ( ! empty( $answers ) ) {
                    foreach ( $answers as $key => $answer ) {
                        ?>
                        <input type="radio" id="<?php echo $key; ?>" name="<?php echo 'mcq-answer-' . $post ?>" value="<?php echo $key; ?>" />
                        <label for="<?php echo $key; ?>"><?php echo $answer; ?></label><br>
                        <?php
                    }
                }
                ?>
            </div>
            <?php
        }
        ?>
            <button id="<?php echo 'mcq-submit-' . $category; ?>" class="mcq-submit"><?php echo __( 'Submit', 'mcq' ); ?></button>
        </div>
        <?php
        }
        return ob_get_clean();
    }
}