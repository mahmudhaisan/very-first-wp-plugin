<?php

/**
 * Plugin Name:       Simple-Plugin
 * Plugin URI:        https://mahmudhaisan.com
 * Description:       I am newbie in plugin development field. Now i am trying to concentrate on wordpress plugin development and trying to build up a startup it firm.
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Mahmud Haisan
 * Author URI:        https://mahmudhaisan.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       Simple-Plugin
 * Domain Path:       /languages
 */

// create a constant using define
define("PLUGIN_PATH", plugin_dir_path(__FILE__)); // constants name is in capital letter and its the convention
define("PLUGIN_URL", plugins_url());

// Add Menu Page to set the plugin in admin backend dashboard
function adding_in_menu()
{
    add_menu_page(
        "new-plugin",
        "custom-plugin",
        "manage_options",
        "custom",
        "custom_plugin_func"
    );

    add_submenu_page(
        "custom",
        "submenu",
        "new sub page",
        "manage_options",
        "sub-menu",
        "sub_menu_func"
    );
};

// Custom Plugin function
function custom_plugin_func()
{
    include_once PLUGIN_PATH . '/views/add-new.php';
}

// submenu callback function
function sub_menu_func()
{
    include_once PLUGIN_PATH . '/views/all-pages.php';
}

add_action('admin_menu', 'adding_in_menu');

//action hook
add_action('wp_head', 'head_input');

//head_input function
function head_input()
{
    echo "i am creating new simple plugin";
};

// adding enqueue styles and scripts

function enqueue_scripts_styles_add()
{
    wp_enqueue_style("styles", PLUGIN_URL . '/simple-plugin/assets/css/styles.css');
    wp_enqueue_script("scripts", PLUGIN_URL . '/simple-plugin/assets/js/scripts.js');

}
add_action('admin_enqueue_scripts', 'enqueue_scripts_styles_add');

// creating database
function create_db_table_on_activation()
{
    global $wpdb;
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    $sql = 'CREATE TABLE `wp_custom_table` (
        `name` text NOT NULL,
        `age` text NOT NULL,
        `address` text NOT NULL,
        `nationality` text NOT NULL,
        `status` text NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4';

    dbDelta($sql);

}

register_activation_hook(__FILE__, 'create_db_table_on_activation');

// delete table on uninstall plugin
function delete_db_table_on_deactivation()
{
    global $wpdb;
    $wpdb->query("DROP table IF Exists wp_custom_table");

}
register_deactivation_hook(__FILE__, 'delete_db_table_on_deactivation');
