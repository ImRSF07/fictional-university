<?php

/*
    Plugin Name: First Plugin
    Description: This is my first plugin
    Version: 1.0.0
    Author: Roswaldo
    Author URI: https://github.com/Roswaldo
    Text Domain: wcpdomain
    Domain Path: /languages 
*/

class WordCountAndTimePlugin
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'adminPage']);
        add_action('admin_init', [$this, 'settings']);
        add_filter('the_content', [$this, 'ifWrap']);
        add_action('init', [$this, 'languages']);
    }

    function languages()
    {
        load_plugin_textdomain('wcpdomain', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    function ifWrap($content)
    {
        if (is_main_query() and is_single() and (get_option('wcp_wordcount') == '1' or get_option('wcp_charactercount') == '1' or get_option('wcp_time') == '1')) {
            return $this->createHTML($content);
        }
        return $content;
    }

    function createHTML($content)
    {
        $html = '<h3>' . esc_html(get_option('wcp_headline', 'Post Info')) . '</h3><p>';

        if (get_option('wcp_wordcount', '1') or get_option('readtime', '1')) {
            $wordCount = str_word_count(strip_tags($content));
        }

        if (get_option('wcp_wordcount', '1')) {
            $html .= esc_html__('This post has', 'wcpdomain') . ' ' . $wordCount . ' ' . __('words.', 'wcpdomain') . '<br>';
        }

        if (get_option('wcp_charactercount', '1')) {
            $html .= esc_html__('This post has', 'wcpdomain') . ' ' . strlen(strip_tags($content)) . ' ' . __('characters', 'wcpdomain') . '<br>';
        }

        if (get_option('wcp_readtime', '1')) {
            $html .= esc_html__('This post will take about', 'wcpdomain') . ' ' . round($wordCount / 225) . ' ' . __('minutes to read.', 'wcpdomain') . '.<br>';
        }

        $html .= '</p>';

        if (get_option('wcp_location', '0') == '0') {
            return $html . $content;
        }

        return $content . $html;
    }

    function settings()
    {
        add_settings_section('wcp_first_section', null, null, 'word-count-settings-page');

        add_settings_field('wcp_location', 'Display Location', [$this, 'locationHTML'], 'word-count-settings-page', 'wcp_first_section');
        register_setting('wordcountplugin', 'wcp_location', ['sanitize_callback' => [$this, 'sanitizeLocation'], 'default' => '0']);

        add_settings_field('wcp_headline', 'Headline', [$this, 'headlineHTML'], 'word-count-settings-page', 'wcp_first_section');
        register_setting('wordcountplugin', 'wcp_headline', ['sanitize_callback' => 'sanitize_text_field', 'default' => 'Post Statistics']);

        add_settings_field('wcp_wordcount', 'Word Count', [$this, 'checkboxHTML'], 'word-count-settings-page', 'wcp_first_section', ['theName' => 'wcp_wordcount']);
        register_setting('wordcountplugin', 'wcp_wordcount', ['sanitize_callback' => 'sanitize_text_field', 'default' => '1']);

        add_settings_field('wcp_charactercount', 'Character Count', [$this, 'checkboxHTML'], 'word-count-settings-page', 'wcp_first_section', ['theName' => 'wcp_charactercount']);
        register_setting('wordcountplugin', 'wcp_charactercount', ['sanitize_callback' => 'sanitize_text_field', 'default' => '1']);

        add_settings_field('wcp_readtime', 'Read Time', [$this, 'checkboxHTML'], 'word-count-settings-page', 'wcp_first_section', ['theName' => 'wcp_readtime']);
        register_setting('wordcountplugin', 'wcp_readtime', ['sanitize_callback' => 'sanitize_text_field', 'default' => '1']);
    }

    function sanitizeLocation($input)
    {
        if ($input != '1' and $input != '0') {
            add_settings_error('wcp_location', 'wcp_location_error', 'Display location must be either beginning or end');
            return get_option('wcp_location');
        }
        return $input;
    }

    function checkboxHTML($args)
    { ?>
        <input type="checkbox" name="<?php echo $args['theName']; ?>" value="1" <?php checked(get_option($args['theName']), '1'); ?>>
    <?php }

    function headlineHTML()
    { ?>
        <input type="text" name="wcp_headline" value="<?php echo esc_attr(get_option('wcp_headline')); ?>">
    <?php }

    function locationHTML()
    { ?>
        <select name="wcp_location">
            <option value="0" <?php selected(get_option('wcp_location'), '0'); ?>>Beginning of post</option>
            <option value="1" <?php selected(get_option('wcp_location'), '1'); ?>>End of post</option>
        </select>
    <?php }

    function adminPage()
    {
        add_options_page('Word Count Settings', __('Word Count', 'wcpdomain'), 'manage_options', 'word-count-settings-page', [$this, 'ourHTML']);
    }

    function ourHTML()
    { ?>
        <div class="wrap">
            <h1>Word Count Settings</h1>
            <form action="options.php" method="post">
                <?php
                settings_fields('wordcountplugin');
                do_settings_sections('word-count-settings-page');
                submit_button();
                ?>
            </form>
        </div>
<?php }
}

$wordCountAndTimePlugin = new WordCountAndTimePlugin();
