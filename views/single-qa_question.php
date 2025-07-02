<?php
get_header();
if ( have_posts() ) : while ( have_posts() ) : the_post();
    $sub_questions = get_post_meta( get_the_ID(), '_qa_sub_questions', true );
    $answers       = get_post_meta( get_the_ID(), '_qa_answers', true );
    $related_urls  = get_post_meta( get_the_ID(), '_qa_related_urls', true );
    if ( ! is_array( $sub_questions ) ) $sub_questions = array();
    if ( ! is_array( $answers ) ) $answers = array();
?>
<div class="qa-single-question">
    <h1 class="qa-question-title"><?php the_title(); ?></h1>
    <div class="qa-question-content"><?php the_content(); ?></div>
    <?php if ( ! empty( $sub_questions ) ) : ?>
        <div class="qa-sub-questions">
            <h3><?php _e( 'Sub-Questions', 'qa-management-system' ); ?></h3>
            <?php foreach ( $sub_questions as $index => $sub ) : ?>
                <div class="qa-sub-question-item">
                    <details>
                        <summary><?php printf( __( 'Sub-Question %d', 'qa-management-system' ), $index + 1 ); ?></summary>
                        <div class="qa-sub-question-content">
                            <?php echo wpautop( esc_html( $sub['content'] ) ); ?>
                        </div>
                    </details>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php if ( ! empty( $answers ) ) : ?>
        <div class="qa-answers">
            <h3><?php _e( 'Answers', 'qa-management-system' ); ?></h3>
            <?php foreach ( $answers as $index => $ans ) : ?>
                <div class="qa-answer-item">
                    <h4><?php printf( __( 'Answer %d', 'qa-management-system' ), $index + 1 ); ?></h4>
                    <div class="qa-answer-content">
                        <?php echo wpautop( esc_html( $ans['content'] ) ); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php if ( ! empty( $related_urls ) ) : ?>
        <div class="qa-related-questions">
            <h3><?php _e( 'Related Questions', 'qa-management-system' ); ?></h3>
            <div class="qa-related-links">
                <?php 
                $urls = explode( "\n", $related_urls );
                foreach( $urls as $url ) :
                    $url = trim( $url );
                    if ( ! empty( $url ) ) : ?>
                        <a href="<?php echo esc_url( $url ); ?>" class="qa-related-link"><?php echo esc_url( $url ); ?></a>
                    <?php endif;
                endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php
endwhile; endif;
get_footer();