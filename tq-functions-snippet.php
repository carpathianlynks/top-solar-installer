<?php
/**
 * TechQuarter Solar Case Study — functions.php additions
 * 
 * Add this code to your child theme's functions.php
 * (do NOT replace the full functions.php — append this)
 */

// ── 1. REGISTER PAGE TEMPLATE ──────────────────────────────────────────
add_filter('theme_page_templates', function($templates) {
    $templates['solar-case-study-gutenberg'] = 'Solar: Case Study';
    return $templates;
});

// ── 2. LOAD TEMPLATE FILE ──────────────────────────────────────────────
add_filter('template_include', function($template) {
    if (is_page() && get_page_template_slug() === 'solar-case-study-gutenberg') {
        $custom = get_stylesheet_directory() . '/templates/solar-case-study-gutenberg.html';
        if (file_exists($custom)) return $custom;
    }
    return $template;
});

// ── 3. ENQUEUE FONTS + STYLES ──────────────────────────────────────────
add_action('wp_enqueue_scripts', function() {
    if (is_page() && get_page_template_slug() === 'solar-case-study-gutenberg') {
        // IBM Plex fonts
        wp_enqueue_style(
            'ibm-plex-fonts',
            'https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700&family=IBM+Plex+Mono:wght@400;500;600&display=swap',
            [], null
        );
        // Case study specific styles (create this file from the CSS block in the template)
        wp_enqueue_style(
            'tq-case-study',
            get_stylesheet_directory_uri() . '/css/tq-case-study.css',
            ['ibm-plex-fonts'], '1.0.0'
        );
    }
});

// ── 4. REMOVE DEFAULT THEME PADDING/MARGIN ON CASE STUDY PAGE ─────────
add_filter('body_class', function($classes) {
    if (is_page() && get_page_template_slug() === 'solar-case-study-gutenberg') {
        $classes[] = 'tq-case-study-page';
        $classes[] = 'no-padding-top'; // add to your theme's body styling
    }
    return $classes;
});

// ── 5. CONTACT FORM HANDLER ────────────────────────────────────────────
add_action('admin_post_tq_contact',        'tq_handle_contact_form');
add_action('admin_post_nopriv_tq_contact', 'tq_handle_contact_form');

function tq_handle_contact_form() {
    if (!isset($_POST['tq_nonce']) || !wp_verify_nonce($_POST['tq_nonce'], 'tq_contact_form')) {
        wp_die('Security check failed.');
    }

    $name      = sanitize_text_field($_POST['full_name'] ?? '');
    $email     = sanitize_email($_POST['email'] ?? '');
    $challenge = sanitize_textarea_field($_POST['challenge'] ?? '');

    if (empty($name) || !is_email($email)) {
        wp_redirect(add_query_arg('contact', 'error', wp_get_referer()));
        exit;
    }

    $to      = get_option('admin_email');
    $subject = "New Case Study Enquiry — {$name}";
    $body    = "Name: {$name}\nEmail: {$email}\nChallenge: {$challenge}";
    $headers = ["Reply-To: {$name} <{$email}>", 'Content-Type: text/plain; charset=UTF-8'];

    wp_mail($to, $subject, $body, $headers);

    wp_redirect(add_query_arg('contact', 'success', wp_get_referer()));
    exit;
}

// ── 6. SUCCESS / ERROR NOTICE (optional inline JS) ─────────────────────
add_action('wp_footer', function() {
    if (!is_page() || get_page_template_slug() !== 'solar-case-study-gutenberg') return;
    $status = $_GET['contact'] ?? '';
    if ($status === 'success') {
        echo '<script>document.addEventListener("DOMContentLoaded",function(){
            var f=document.querySelector(".cta-form");
            if(f){f.innerHTML="<p style=\"color:#28b473;font-size:16px;padding:24px 0;\">&#10003; Message sent! We\'ll be in touch shortly.</p>";}
        });</script>';
    }
});
