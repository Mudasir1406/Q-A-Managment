<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class QAMS_Admin {

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'save_question_meta' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_assets' ) );
    }

    public function add_admin_menu() {
        add_menu_page(
            __( 'Q&A Management', 'qa-management-system' ),
            __( 'Q&A System', 'qa-management-system' ),
            'manage_options',
            'qa-dashboard',
            array( $this, 'dashboard_page' ),
            'dashicons-format-chat',
            30
        );

        add_submenu_page(
            'qa-dashboard',
            __( 'All Questions', 'qa-management-system' ),
            __( 'All Questions', 'qa-management-system' ),
            'manage_options',
            'edit.php?post_type=qa_question'
        );

        add_submenu_page(
            'qa-dashboard',
            __( 'Categories', 'qa-management-system' ),
            __( 'Categories', 'qa-management-system' ),
            'manage_options',
            'edit-tags.php?taxonomy=qa_category&post_type=qa_question'
        );
    }

    public function dashboard_page() {
        include QAMS_PATH . 'views/admin-dashboard.php';
    }

    public function add_meta_boxes() {
        add_meta_box(
            'qa_question_details',
            __( 'Question Details', 'qa-management-system' ),
            array( $this, 'question_details_meta_box' ),
            'qa_question',
            'normal',
            'high'
        );
    }

    public function question_details_meta_box( $post ) {
        include QAMS_PATH . 'views/meta-box-question-details.php';
    }

    public function save_question_meta( $post_id ) {
        if ( ! isset( $_POST['qa_question_meta_nonce'] ) || ! wp_verify_nonce( $_POST['qa_question_meta_nonce'], 'qa_question_meta_nonce' ) ) {
            return;
        }
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }
        if ( isset( $_POST['qa_sub_questions'] ) ) {
            $clean = array();
            foreach ( $_POST['qa_sub_questions'] as $item ) {
                $clean[] = array( 'content' => sanitize_textarea_field( $item['content'] ) );
            }
            update_post_meta( $post_id, '_qa_sub_questions', $clean );
        }
        if ( isset( $_POST['qa_answers'] ) ) {
            $clean = array();
            foreach ( $_POST['qa_answers'] as $item ) {
                $clean[] = array( 'content' => sanitize_textarea_field( $item['content'] ) );
            }
            update_post_meta( $post_id, '_qa_answers', $clean );
        }
        if ( isset( $_POST['qa_related_urls'] ) ) {
            update_post_meta( $post_id, '_qa_related_urls', sanitize_textarea_field( $_POST['qa_related_urls'] ) );
        }
    }

    public function admin_assets( $hook ) {
        if ( strpos( $hook, 'qa-dashboard' ) !== false || $hook === 'post.php' || $hook === 'post-new.php' ) {
            wp_enqueue_style( 'qams-admin', QAMS_URL . 'assets/admin.css', array(), QAMS_VER );
            wp_enqueue_script( 'jquery' );
        }
    }
}