<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class QAMS_Post_Type {

    public function __construct() {
        add_action( 'init', array( $this, 'register_post_type' ) );
        add_action( 'init', array( $this, 'register_taxonomy' ) );
    }

    public function register_post_type() {
        $labels = array(
            'name'               => __( 'Questions', 'qa-management-system' ),
            'singular_name'      => __( 'Question', 'qa-management-system' ),
            'add_new'            => __( 'Add New', 'qa-management-system' ),
            'add_new_item'       => __( 'Add New Question', 'qa-management-system' ),
            'edit_item'          => __( 'Edit Question', 'qa-management-system' ),
            'new_item'           => __( 'New Question', 'qa-management-system' ),
            'view_item'          => __( 'View Question', 'qa-management-system' ),
            'search_items'       => __( 'Search Questions', 'qa-management-system' ),
            'not_found'          => __( 'No questions found.', 'qa-management-system' ),
            'not_found_in_trash' => __( 'No questions found in Trash.', 'qa-management-system' ),
        );
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'show_ui'            => true,
            'has_archive'        => true,
            'rewrite'            => array( 'slug' => 'questions' ),
            'supports'           => array( 'title', 'editor', 'thumbnail' ),
            'menu_icon'          => 'dashicons-format-chat',
            'show_in_rest'       => true,
        );
        register_post_type( 'qa_question', $args );
    }

    public function register_taxonomy() {
        $labels = array(
            'name'              => __( 'Question Categories', 'qa-management-system' ),
            'singular_name'     => __( 'Question Category', 'qa-management-system' ),
            'add_new_item'      => __( 'Add New Category', 'qa-management-system' ),
            'edit_item'         => __( 'Edit Category', 'qa-management-system' ),
            'update_item'       => __( 'Update Category', 'qa-management-system' ),
            'search_items'      => __( 'Search Categories', 'qa-management-system' ),
        );
        $args = array(
            'labels'            => $labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud'     => true,
            'show_in_rest'      => true,
        );
        register_taxonomy( 'qa_category', 'qa_question', $args );
    }

    public static function activate() {
        $self = new self();
        $self->register_post_type();
        $self->register_taxonomy();
        flush_rewrite_rules();

        // Add default categories
        $defaults = array( 'General', 'Technical', 'Support' );
        foreach ( $defaults as $cat ) {
            if ( ! term_exists( $cat, 'qa_category' ) ) {
                wp_insert_term( $cat, 'qa_category' );
            }
        }
    }
    public static function deactivate() {
        flush_rewrite_rules();
    }
}