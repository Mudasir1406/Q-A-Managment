<?php
if (!defined('ABSPATH')) exit;

class QAMS_Frontend {

    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'frontend_assets'));
        add_filter('template_include', array($this, 'template_include'));
    }

    public function frontend_assets() {
        wp_enqueue_style('qams-frontend', QAMS_URL . 'assets/frontend.css', array(), QAMS_VER);
        wp_enqueue_script('qams-frontend', QAMS_URL . 'assets/frontend.js', array('jquery'), QAMS_VER, true);
        wp_localize_script('qams-frontend', 'qams_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('qams_ajax_nonce'),
        ));
    }

    // Load plugin template for single questions if the theme doesn't have one
    public function template_include($template) {
        if (is_singular('qa_question')) {
            $plugin_template = QAMS_PATH . 'views/single-qa_question.php';
            if (file_exists($plugin_template)) {
                return $plugin_template;
            }
        }
        return $template;
    }
}