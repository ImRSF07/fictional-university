<?php

/*
    Plugin Name: Words Filter Plugin
    Description: This is my word filter plugin
    Version: 1.0.0
    Author: Roswaldo
    Author URI: https://github.com/ImRSF07
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class WordsFilterPlugin
{
    const SVG_CODE = 'PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik0xMCAyMEMxNS41MjI5IDIwIDIwIDE1LjUyMjkgMjAgMTBDMjAgNC40NzcxNCAxNS41MjI5IDAgMTAgMEM0LjQ3NzE0IDAgMCA0LjQ3NzE0IDAgMTBDMCAxNS41MjI5IDQuNDc3MTQgMjAgMTAgMjBaTTExLjk5IDcuNDQ2NjZMMTAuMDc4MSAxLjU2MjVMOC4xNjYyNiA3LjQ0NjY2SDEuOTc5MjhMNi45ODQ2NSAxMS4wODMzTDUuMDcyNzUgMTYuOTY3NEwxMC4wNzgxIDEzLjMzMDhMMTUuMDgzNSAxNi45Njc0TDEzLjE3MTYgMTEuMDgzM0wxOC4xNzcgNy40NDY2NkgxMS45OVoiIGZpbGw9IiNGRkRGOEQiLz4KPC9zdmc+Cg==';
    public function __construct()
    {
        add_action('admin_menu', array($this, 'menu'));
        add_action('admin_init', array($this, 'settings'));
        if (get_option('plugin_words_to_filter')) add_filter('the_content', array($this, 'filterLogic'));
    }

    function settings()
    {
        add_settings_section('replacement-text-section', null, null, 'word-filter-options');
        register_setting('replacementFields', 'replacementText');
        add_settings_field('replacement-text', 'Filtered Text', array($this, 'replacementFieldHTML'), 'word-filter-options', 'replacement-text-section');
    }

    function replacementFieldHTML()
    { ?>
        <input type="text" name="replacementText" id="replacementText" value="<?php echo esc_attr(get_option('replacementText', '****')) ?>" />
        <p class="description">Leave blank to simply remove the filtered words.</p>
        <?php }

    function filterLogic($content)
    {
        $filteredWords = explode(',', get_option('plugin_words_to_filter'));
        $trimmedFilteredWords = array_map('trim', $filteredWords);
        return str_ireplace($trimmedFilteredWords, esc_html(get_option('replacementText', '****')), $content);
    }

    function menu()
    {
        $mainPageHook = add_menu_page('Word Filter', 'Words Filter', 'manage_options', 'wordfilter', array($this, 'wordFilterPage'), 'data:image/svg+xml;base64,' . self::SVG_CODE, 100);
        add_submenu_page('wordfilter', 'Words To Filter', 'Words List', 'manage_options', 'wordfilter', array($this, 'wordFilterPage'));
        add_submenu_page('wordfilter', 'Words Filter Options', 'Options', 'manage_options', 'word-filter-options', array($this, 'optionsSubPage'));
        add_action("load-{$mainPageHook}", array($this, 'mainPageAssets'));
    }

    function mainPageAssets()
    {
        wp_enqueue_style('filterAdminCss', plugin_dir_url(__FILE__) . 'styles.css');
    }

    function handleForm()
    {
        if (isset($_POST['ourNonce']) == true and wp_verify_nonce($_POST['ourNonce'], 'saveFilterWords') and current_user_can('manage_options')) {
            update_option('plugin_words_to_filter', sanitize_text_field($_POST['plugin_words_to_filter'])); ?>
            <div class="updated">
                <p>Your filtered words were saved.</p>
            </div>
        <?php } else { ?>
            <div class="error">
                <p>Sorry, you do not have sufficient permissions to save.</p>
            </div>
        <?php }
    }

    public function wordFilterPage()
    { ?>
        <div class="wrap">
            <h1>Word Filter</h1>
            <?php if (isset($_POST['justsubmitted']) == true) $this->handleForm(); ?>
            <form action="" method="post">
                <input type="hidden" name="justsubmitted" value="true">
                <?php wp_nonce_field('saveFilterWords', 'ourNonce'); ?>
                <label for="plugin_words_to_filter">
                    <p>Enter <strong>comma-separated</strong> words to filter</p>
                    <div class="word-filter__flex-container">
                        <textarea name="plugin_words_to_filter" id="" placeholder="bad, mean, awful"><?php echo esc_textarea(get_option('plugin_words_to_filter')) ?></textarea>
                    </div>
                    <input type="submit" value="Save Changes" name="submit" class="button button-primary" id="submit">
                </label>
            </form>
        </div>
    <?php }

    public function optionsSubPage()
    { ?>
        <div class="wrap">
            <h1>Word Filter Options</h1>
            <form action="options.php" method="post">
                <?php
                settings_errors();
                settings_fields('replacementFields');
                do_settings_sections('word-filter-options');
                submit_button()
                ?>
            </form>
        </div>
<?php }
}

$wordFilterPlugin = new WordsFilterPlugin();
