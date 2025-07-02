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
// In __construct or init:
add_shortcode('qa_landing_page', [$this, 'landing_page']);