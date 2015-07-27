<?php

    /*
     * Plugin Name: Singsys Responsive Slider
     * Plugin URI: http://www.plugin.singsys.com/singsys-responsive-slider/
     * Description: Responsive Slider
     * Version: 1.0
     * Author: Singsys Software Services Pte Ltd
     * Author URI: http://www.singsys.com
     * License: License: GPLv2 or later
     * License URI: http://www.gnu.org/licenses/gpl-2.0.html
     */



    global $singsys_slide_version;
    $singsys_slide_version = '1.0';

    add_action('admin_menu', 'singsys_slider_admin_menu');
    
    /*
     * Add singsys to menu
     */
    function singsys_slider_admin_menu() {
        add_menu_page('Singsys Responsive Slider', 'Singsys Slider', 'manage_options', 'singsys_slider', 'singsys_slider_dashboard', 'dashicons-camera', 10);
        add_submenu_page('singsys_slider', 'Add Or Update Slider', 'Add Slider', 'manage_options', 'singsys_new_slider', 'singsys_add_new_slider');
    }

    function singsys_dlt_sldr() {
        if (isset($_REQUEST['id'])) {
            // delete Here..
        } else {
            wp_redirect(admin_url() . 'admin.php?page=singsys_slider');
        }
    }

    /*
     * Save slider form hooks
     */
    add_action('admin_post_singsys_save_slider', 'singsys_save_slider');

    function singsys_save_slider() {
        global $wpdb;
        $tb_pre = $wpdb->prefix;

        // Check Slider is Exists
        $slider_id = $_POST['singsys_slider_id'];
        //$slider_id = 1;
        $sql_check = "select id from {$tb_pre}singsys_slider where id={$slider_id}";
        $exist_result = $wpdb->get_row($sql_check);

        // Slider Data
        $slider_name = ($_POST['sys_slider_name'] == '') ? 'Sings slider' : $_POST['sys_slider_name'];
        $slider_option = (is_array($_POST['sys_slider'])) ? serialize($_POST['sys_slider']) : $_POST['sys_slider'];

        $slider_data = array('title' => $slider_name, 'option' => $slider_option);
        $db_slider_id = -1;



        if ($exist_result) {
            // Here You can Update
            $db_slider_id = $slider_id;
            $wpdb->update("{$tb_pre}singsys_slider", $slider_data, array('id' => $db_slider_id));
        } else {

            $wpdb->insert("{$tb_pre}singsys_slider", $slider_data);
            $db_slider_id = $wpdb->insert_id;

            // Here You can insert
        }

        // Add Slider Items
        if (isset($_POST['sys_slider_items_id'])) {
            $items = $_POST['sys_slider_items_id'];
            foreach ($items as $k => $v) {

                $item_data = array(
                    'slider_id' => $db_slider_id,
                    'media_id' => isset($_POST['sys_media_id'][$k]) ? $_POST['sys_media_id'][$k] : 0,
                    'title' => isset($_POST['sys_slider_title'][$k]) ? $_POST['sys_slider_title'][$k] : '',
                    'link' => isset($_POST['sys_slider_links'][$k]) ? $_POST['sys_slider_links'][$k] : '',
                    'description' => isset($_POST['sys_slider_desc'][$k]) ? $_POST['sys_slider_desc'][$k] : ''
                );
                $sql_check = "select id from {$tb_pre}singsys_items where id={$v}";

                $exist_result = $wpdb->get_row($sql_check);
                if ($exist_result) {
                    /*
                     * updating slider
                     */
                    $item_id = $exist_result->id;
                    $wpdb->update("{$tb_pre}singsys_items", $item_data, array('id' => $item_id));
                } else {
                    /*
                     * inserting new item
                     */
                    $wpdb->insert("{$tb_pre}singsys_items", $item_data);
                }
            }
        }

        wp_redirect(admin_url() . 'admin.php?page=singsys_new_slider&id=' . $db_slider_id);
    }

    function singsys_add_new_slider() {
        wp_enqueue_media();
        include(dirname(__file__).'/page/new.php');
    }

    function singsys_slider_dashboard() {
        // Delete  slider 
        if (isset($_REQUEST['dltId'])) {
            global $wpdb;
            $prefix = $wpdb->prefix;
            $slider_id = $_REQUEST['dltId'];
            $sql = "delete from {$prefix}singsys_slider where id={$slider_id}";
            $sql2 = "delete from {$prefix}singsys_items where slider_id ={$slider_id}";
            $wpdb->query($sql);
            $wpdb->query($sql2);
        }

        include(dirname(__file__) . '/page/index.php');
        //echo 'Test';
    }

    // On Active Slider
    register_activation_hook(__FILE__, 'singsys_slider_install');

    // Deactive Slider
    register_deactivation_hook(__FILE__, 'singsys_slider_deactivation');

    function singsys_slider_deactivation() {
        // Clear the permalinks to remove our post type's rules
        flush_rewrite_rules();
    }

    function singsys_slider_install() {
        global $wpdb;
        global $singsys_slide_version;

        $slider_table = $wpdb->prefix . 'singsys_slider';
        $slider_item_table = $wpdb->prefix . 'singsys_items';

        $charset_collate = $wpdb->get_charset_collate();



        $t1 = "CREATE TABLE IF NOT EXISTS `" . $slider_table . "` (
            `id` bigint(20) NOT NULL AUTO_INCREMENT,
            `title` varchar(100) NOT NULL,
            `option` longtext NOT NULL,
            `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

        $t2 = "CREATE TABLE IF NOT EXISTS `" . $slider_item_table . "` (
            `id` bigint(20) NOT NULL AUTO_INCREMENT,
            `slider_id` bigint(20) NOT NULL,
            `media_id` bigint(20) NOT NULL,
            `title` varchar(200) NOT NULL,
            `link` varchar(200) NOT NULL,
            `description` text NOT NULL,
            `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
        //$sql = $t1.$t2;

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($t1);
        dbDelta($t2);

        add_option('singsys_slide_version', $singsys_slide_version);
    }
    
    // Delete Slider Item Using Ajax Hooks
    add_action('wp_ajax_delete_singsys_slider_item', 'remove_singsys_slider_items');

    function remove_singsys_slider_items() {
        $id = $_POST['id'];
        //exit($id);
        global $wpdb;
        $sql = "delete from  {$wpdb->prefix}singsys_items where id ={$id}";
        if ($wpdb->query($sql)) {

            exit('true');
        } else {

            exit("Database Error." . $id);
        }
    }

    // Add Shortcode File
    include_once('slider_short_code.php');
    $singsys_slider_shortcodes = new singsys_slider_code;
