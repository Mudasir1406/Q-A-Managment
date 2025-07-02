<?php
if (!defined('ABSPATH')) exit;

class QAMS_Shortcodes {

    public function __construct() {
        add_shortcode('qa_search_form', array($this, 'search_form'));
        add_shortcode('qa_questions_list', array($this, 'questions_list'));
        add_shortcode('qa_single_question', array($this, 'single_question'));
        add_shortcode('qa_categories', array($this, 'categories'));
        add_shortcode('qa_landing_page', [$this, 'landing_page']);

    }

    public function search_form($atts) {
        ob_start();
        $file = QAMS_PATH . 'views/shortcode-search-form.php';
        if (file_exists($file)) {
            include $file;
        } else {
            echo '<p>Search form template is missing.</p>';
        }
        return ob_get_clean();
    }

    public function questions_list($atts) {
        ob_start();
        $file = QAMS_PATH . 'views/shortcode-questions-list.php';
        if (file_exists($file)) {
            include $file;
        } else {
            echo '<p>Questions list template is missing.</p>';
        }
        return ob_get_clean();
    }

    public function single_question($atts) {
        ob_start();
        $file = QAMS_PATH . 'views/shortcode-single-question.php';
        if (file_exists($file)) {
            include $file;
        } else {
            echo '<p>Single question template is missing.</p>';
        }
        return ob_get_clean();
    }

    public function categories($atts) {
        ob_start();
        $file = QAMS_PATH . 'views/shortcode-categories.php';
        if (file_exists($file)) {
            include $file;
        } else {
            echo '<p>Categories template is missing.</p>';
        }
        return ob_get_clean();
    }
    public function landing_page($atts) {
    ob_start();
    $file = QAMS_PATH . 'views/landing-page.php';
    if (file_exists($file)) {
        include $file;
    } else {
        echo '<p>Landing page template is missing.</p>';
    }
    return ob_get_clean();
    }

}