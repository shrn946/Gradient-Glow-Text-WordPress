<?php
/*
Plugin Name: Gradient Glow Text
Description: Adds a gradient glow effect to Wordpress Content.[gradient_text_glow text="Custom Text" font_size="60" text_align="center"]


Version: 1.0
Author: Hassan Naqvi
*/
// Enqueue the stylesheet
function gradient_glow_text_enqueue_styles() {
    wp_enqueue_style('gradient-glow-text-style', plugin_dir_url(__FILE__) . 'style.css');
}

add_action('wp_enqueue_scripts', 'gradient_glow_text_enqueue_styles');

function gradient_text_glow_shortcode($atts, $content = null) {
    static $shortcode_count = 0;
    $shortcode_count++;

    // Extract shortcode attributes
    $atts = shortcode_atts(
        array(
            'text' => 'gradient text glow',
            'font_size' => '5em',
            'text_align' => 'left',
        ),
        $atts,
        'gradient_text_glow'
    );

    // Sanitize the text content, font size, and text align
    $text_content = sanitize_text_field($atts['text']);
    $font_size = esc_attr($atts['font_size']);
    $text_align = esc_attr($atts['text_align']);

    // Generate the unique class for each shortcode
    $unique_class = 'iftext_' . $shortcode_count;

    // Generate the SVG code with the provided text
    $svg_code = '<svg width="0" height="0">
                    <filter id="f" x="-50%" y="-200%" width="200%" height="500%">
                        <feGaussianBlur stdDeviation="35"></feGaussianBlur>
                        <feColorMatrix type="saturate" values="1.3"></feColorMatrix>
                        <feComposite in="SourceGraphic"></feComposite>
                    </filter>
                </svg>';

    // Generate the HTML code with the text, font size, text align, and inline CSS using a <div> element with a unique class
    $output = '<div class="iftext ' . esc_attr($unique_class) . '" style="filter: url(#f); font-size: ' . $font_size . 'px; text-align: ' . $text_align . ';">' . esc_html($text_content) . '</div>' . $svg_code;

    return $output;
}
add_shortcode('gradient_text_glow', 'gradient_text_glow_shortcode');
