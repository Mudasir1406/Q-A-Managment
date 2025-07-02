<?php
// Handle search and filters
$search = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';
$subject = isset($_GET['subject']) ? sanitize_text_field($_GET['subject']) : '';
$class = isset($_GET['class']) ? sanitize_text_field($_GET['class']) : '';
$topic = isset($_GET['topic']) ? sanitize_text_field($_GET['topic']) : '';
$difficulty = isset($_GET['difficulty']) ? sanitize_text_field($_GET['difficulty']) : '';

// Build query args for search/filters
$args = [
    'post_type' => 'qa_question',
    'post_status' => 'publish',
    's' => $search,
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC',
    'tax_query' => [],
    'meta_query' => [],
];

// Example: assuming taxonomy 'qa_subject', 'qa_class', 'qa_topic', and meta 'difficulty'
if ($subject)     $args['tax_query'][] = ['taxonomy'=>'qa_subject','field'=>'slug','terms'=>$subject];
if ($class)       $args['tax_query'][] = ['taxonomy'=>'qa_class','field'=>'slug','terms'=>$class];
if ($topic)       $args['tax_query'][] = ['taxonomy'=>'qa_topic','field'=>'slug','terms'=>$topic];
if ($difficulty)  $args['meta_query'][] = ['key'=>'difficulty','value'=>$difficulty];

// Fetch matching questions
$questions = get_posts($args);

// Fetch random question for the random display section
$random_args = [
    'post_type' => 'qa_question',
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'orderby' => 'rand',
];
$random_question = get_posts($random_args);
$random_question = $random_question ? $random_question[0] : null;

// Helper: get taxonomy options
function qams_get_tax_options($taxonomy) {
    $terms = get_terms(['taxonomy'=>$taxonomy,'hide_empty'=>false]);
    $opts = ['' => ucfirst(str_replace('qa_', '', $taxonomy))];
    foreach($terms as $term) $opts[$term->slug] = $term->name;
    return $opts;
}

// Helper: get unique meta values for difficulty (or you can hardcode)
function qams_get_difficulty_options() {
    return [
        '' => 'Difficulty',
        'easy' => 'Easy',
        'medium' => 'Medium',
        'hard' => 'Hard'
    ];
}
?>
<div class="qams-landing-page">
    <form method="get" class="qams-search-section">
        <div class="qams-search-bar">
            <input type="text" name="q" placeholder="Search questions..." value="<?php echo esc_attr($search); ?>" />
            <button type="submit">Search</button>
        </div>
        <div class="qams-filters">
            <?php foreach(['qa_subject','qa_class','qa_topic'] as $tax): ?>
                <select name="<?php echo esc_attr(str_replace('qa_','',$tax)); ?>">
                <?php foreach(qams_get_tax_options($tax) as $slug => $label): ?>
                    <option value="<?php echo esc_attr($slug); ?>"<?php selected($$tax, $slug); ?>><?php echo esc_html($label); ?></option>
                <?php endforeach; ?>
                </select>
            <?php endforeach; ?>
            <select name="difficulty">
                <?php foreach(qams_get_difficulty_options() as $value => $label): ?>
                    <option value="<?php echo esc_attr($value); ?>"<?php selected($difficulty, $value); ?>><?php echo esc_html($label); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <div class="qams-random-question-section">
        <h2>Random Question</h2>
        <?php if ($random_question): ?>
            <div class="qams-random-question-card">
                <h3><a href="<?php echo get_permalink($random_question->ID); ?>">
                    <?php echo esc_html($random_question->post_title); ?>
                </a></h3>
                <div><?php echo wp_trim_words($random_question->post_content, 30); ?></div>
            </div>
        <?php else: ?>
            <p>No questions available.</p>
        <?php endif; ?>
    </div>

    <div class="qams-search-results">
        <h2>Search Results</h2>
        <?php if ($questions): ?>
            <div class="qams-questions-list">
            <?php foreach ($questions as $question): ?>
                <div class="qa-question-card">
                    <h3><a href="<?php echo get_permalink($question->ID); ?>">
                        <?php echo esc_html($question->post_title); ?>
                    </a></h3>
                    <div><?php echo wp_trim_words($question->post_content, 24); ?></div>
                </div>
            <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No questions found for your search/filter.</p>
        <?php endif; ?>
    </div>
</div>