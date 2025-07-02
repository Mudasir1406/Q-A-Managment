<?php
wp_nonce_field( 'qa_question_meta_nonce', 'qa_question_meta_nonce' );
$sub_questions = get_post_meta( $post->ID, '_qa_sub_questions', true );
$answers       = get_post_meta( $post->ID, '_qa_answers', true );
$related_urls  = get_post_meta( $post->ID, '_qa_related_urls', true );
if ( ! is_array( $sub_questions ) ) $sub_questions = array();
if ( ! is_array( $answers ) ) $answers = array();
if ( ! $related_urls ) $related_urls = '';
?>
<div class="qa-meta-section">
    <h3><?php _e( 'Sub-Questions', 'qa-management-system' ); ?></h3>
    <div id="qa-sub-questions">
        <?php foreach ( $sub_questions as $index => $sub ) : ?>
            <div class="qa-sub-question-item">
                <label><?php printf( __( 'Sub-Question %d', 'qa-management-system' ), $index + 1 ); ?></label>
                <textarea name="qa_sub_questions[<?php echo esc_attr( $index ); ?>][content]" class="widefat"><?php echo esc_textarea( $sub['content'] ); ?></textarea>
                <button type="button" class="button qa-remove-item"><?php _e( 'Remove', 'qa-management-system' ); ?></button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" id="qa-add-sub-question" class="button"><?php _e( 'Add Sub-Question', 'qa-management-system' ); ?></button>
</div>
<div class="qa-meta-section">
    <h3><?php _e( 'Answers', 'qa-management-system' ); ?></h3>
    <div id="qa-answers">
        <?php foreach ( $answers as $index => $ans ) : ?>
            <div class="qa-answer-item">
                <label><?php printf( __( 'Answer %d', 'qa-management-system' ), $index + 1 ); ?></label>
                <textarea name="qa_answers[<?php echo esc_attr( $index ); ?>][content]" class="widefat"><?php echo esc_textarea( $ans['content'] ); ?></textarea>
                <button type="button" class="button qa-remove-item"><?php _e( 'Remove', 'qa-management-system' ); ?></button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" id="qa-add-answer" class="button"><?php _e( 'Add Answer', 'qa-management-system' ); ?></button>
</div>
<div class="qa-meta-section">
    <h3><?php _e( 'Related Question URLs', 'qa-management-system' ); ?></h3>
    <label for="qa_related_urls"><?php _e( 'Enter related question URLs (one per line):', 'qa-management-system' ); ?></label>
    <textarea id="qa_related_urls" name="qa_related_urls" class="widefat" rows="5"><?php echo esc_textarea( $related_urls ); ?></textarea>
    <p class="description"><?php _e( 'Add URLs to related questions, one per line.', 'qa-management-system' ); ?></p>
</div>
<script>
jQuery(document).ready(function($) {
    $('#qa-add-sub-question').on('click', function() {
        var index = $('#qa-sub-questions .qa-sub-question-item').length;
        var html = '<div class="qa-sub-question-item">';
        html += '<label><?php _e( 'Sub-Question', 'qa-management-system' ); ?> ' + (index+1) + '</label>';
        html += '<textarea name="qa_sub_questions[' + index + '][content]" class="widefat"></textarea>';
        html += '<button type="button" class="button qa-remove-item"><?php _e( 'Remove', 'qa-management-system' ); ?></button>';
        html += '</div>';
        $('#qa-sub-questions').append(html);
    });
    $('#qa-add-answer').on('click', function() {
        var index = $('#qa-answers .qa-answer-item').length;
        var html = '<div class="qa-answer-item">';
        html += '<label><?php _e( 'Answer', 'qa-management-system' ); ?> ' + (index+1) + '</label>';
        html += '<textarea name="qa_answers[' + index + '][content]" class="widefat"></textarea>';
        html += '<button type="button" class="button qa-remove-item"><?php _e( 'Remove', 'qa-management-system' ); ?></button>';
        html += '</div>';
        $('#qa-answers').append(html);
    });
    $(document).on('click', '.qa-remove-item', function() {
        $(this).parent().remove();
    });
});
</script>