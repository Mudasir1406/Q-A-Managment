<?php
$args = array(
    'post_type' => 'qa_question',
    'post_status' => 'publish',
    'posts_per_page' => 10
);
$questions = get_posts($args);
?>
<div class="qa-questions-list">
    <?php if ($questions): foreach ($questions as $question): ?>
        <div class="qa-question-card">
            <h3 class="qa-question-title">
                <a href="<?php echo get_permalink($question->ID); ?>">
                    <?php echo esc_html($question->post_title); ?>
                </a>
            </h3>
            <div class="qa-question-excerpt"><?php echo wp_trim_words($question->post_content, 30); ?></div>
        </div>
    <?php endforeach; else: ?>
        <p>No questions found.</p>
    <?php endif; ?>
</div>