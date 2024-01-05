<?php

/*
    Plugin Name: Are You Paying Attention Quiz
    Description: Gives your users a quiz to see if they are paying attention
    Version: 1.0.0
    Author: Roswaldo
    Author URI: https://github.com/ImRSF07
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class AreYouPayingAttention
{
    function __construct()
    {
        add_action('init', array($this, 'adminAssets'));
    }

    function adminAssets()
    {
        wp_register_script('ournewblocktype', plugin_dir_url(__FILE__) . 'build/index.js', array('wp-blocks', 'wp-element'));
        register_block_type('ourplugin/are-you-paying-attention', [
            'editor_script' => 'ournewblocktype',
            'render_callback' => [$this, 'theHTML']
        ]);
    }

    function theHTML($attr)
    {
        ob_start(); ?>
        <h1>Today the sky is <?php echo esc_html($attr['skyColor']) ?> and the grass is <?php echo esc_html($attr['grassColor']) ?></h1>;
<?php return ob_get_clean();
    }
}

$areYouPayingAttention = new AreYouPayingAttention();
