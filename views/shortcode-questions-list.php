<?php
// Handle search term from GET
$search_term = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';

// By default show only 6 questions, unless search is active
$posts_per_page = $search_term ? -1 : 6;

$args = array(
    'post_type' => 'qa_question',
    'post_status' => 'publish',
    'posts_per_page' => $posts_per_page,
    'orderby' => 'date',
    'order' => 'DESC',
);

if ($search_term) {
    $args['s'] = $search_term;
}

$questions = get_posts($args);
?>

<form method="get" class="qa-question-search-form" action="">
    <input
        type="text"
        name="q"
        placeholder="Search questions..."
        value="<?php echo esc_attr($search_term); ?>"
        style="padding:8px 12px; border:1px solid #ccc; border-radius:6px; width:220px; margin-right:8px;"
    />
    <button type="submit" class="qa-search-button" style="padding:8px 16px;">Search</button>
    <?php if ($search_term): ?>
        <a href="<?php echo esc_url( remove_query_arg('q') ); ?>" style="margin-left:10px;">Clear</a>
    <?php endif; ?>
</form>

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