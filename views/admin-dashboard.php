<div class="wrap">
    <h1>Q&A Management Dashboard</h1>

    <!-- Other dashboard sections can go here -->

    <div class="qa-shortcodes-help">
        <h2><?php _e('Bricks Builder Shortcodes', 'qa-management-system'); ?></h2>

        <div class="qa-shortcode-item">
            <code>[qa_search_form]</code>
            <p><?php _e('Displays the search and filter form', 'qa-management-system'); ?></p>
            <div><?php echo do_shortcode('[qa_search_form]'); ?></div>
        </div>
        <div class="qa-shortcode-item">
            <code>[qa_questions_list category="general" limit="5"]</code>
            <p><?php _e('Displays list of questions with optional category filter', 'qa-management-system'); ?></p>
            <div><?php echo do_shortcode('[qa_questions_list category="general" limit="5"]'); ?></div>
        </div>
        <div class="qa-shortcode-item">
            <code>[qa_single_question id="1"]</code>
            <p><?php _e('Displays single question with all details', 'qa-management-system'); ?></p>
            <div><?php echo do_shortcode('[qa_single_question id="1"]'); ?></div>
        </div>
        <div class="qa-shortcode-item">
            <code>[qa_categories show_count="true"]</code>
            <p><?php _e('Displays all categories with question counts', 'qa-management-system'); ?></p>
            <div><?php echo do_shortcode('[qa_categories show_count="true"]'); ?></div>
        </div>
    </div>
</div>