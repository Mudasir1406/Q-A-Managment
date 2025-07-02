<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class QAMS_Ajax {
    public function __construct() {
        add_action( 'wp_ajax_qams_search', array( $this, 'ajax_search' ) );
        add_action( 'wp_ajax_nopriv_qams_search', array( $this, 'ajax_search' ) );
    }

    public function ajax_search() {
        check_ajax_referer( 'qams_ajax_nonce', 'nonce' );

        $search_term = isset( $_POST['search_term'] ) ? sanitize_text_field( $_POST['search_term'] ) : '';
        $category    = isset( $_POST['category'] ) ? sanitize_text_field( $_POST['category'] ) : '';

        $args = array(
            'post_type'      => 'qa_question',
            'posts_per_page' => 20,
            'post_status'    => 'publish',
            's'              => $search_term,
        );
        if ( ! empty( $category ) ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'qa_category',
                    'field'    => 'slug',
                    'terms'    => $category,
                )
            );
        }
        $questions = get_posts( $args );
        ob_start();
        foreach ( $questions as $question ) {
            echo '<div class="qa-search-result">';
            echo '<h4><a href="' . esc_url( get_permalink( $question->ID ) ) . '">' . esc_html( $question->post_title ) . '</a></h4>';
            echo '<p>' . esc_html( wp_trim_words( $question->post_content, 20 ) ) . '</p>';
            echo '</div>';
        }
        $results = ob_get_clean();
        wp_send_json_success( $results );
    }
}