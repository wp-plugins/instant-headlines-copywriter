<?php
/*
  Plugin Name: Instant Headlines Copywriter Lite
  Plugin URI: http://www.OptimalPlugins.com/
  Description: Instantly Write Grabbing Attention Headlines With Just One Click
  Version: 1.0
  Author: OptimalPlugins.com
  Author URI: http://www.OptimalPlugins.com/
  License: GPLv2 or later
*/

final class OptimalHeadline {
    public static function optimal_headline_init() {
        wp_register_style('optimal-headline-admin', plugins_url('/css/optimal-headline-admin.css', __FILE__));
        wp_enqueue_style('optimal-headline-admin');
        wp_register_script('optimal-headline-admin', plugins_url('/js/optimal-headline-admin.js', __FILE__));
        wp_enqueue_script('optimal-headline-admin');

        OptimalHeadline::set_headline_data();
    }

    public static function set_headline_data() {
        $file_path = plugins_url('/optimal-headline.txt', __FILE__);
        $headlines = explode( "\n", file_get_contents($file_path));
        wp_localize_script('optimal-headline-admin', 'optimal_headlines_data', array(
            'headlines' => $headlines
        ));
    }

    public static function optimal_headline_create_meta_box() {
        $post_type_list = array('post', 'page');

        foreach ($post_type_list as $post_type) {
            add_meta_box('optimal-headline-meta-box',
                'Instant Headlines Copywriter',
                'OptimalHeadline::optimal_headline_meta_box',
                $post_type,
                'advanced',
                'high');
        }
    }

    public static function optimal_headline_meta_box() {
        ob_start();
        ?>
        <table class="form-table">
            <tbody>
            <tr>
                <th class="optimal-headline-col1" scope="row"><label for="optimal-headline-topic">Headline about</label>
                </th>
                <td class="optimal-headline-col2"><input id="optimal-headline-topic"
                                                         placeholder="Type in your topic and click generate" value=""
                                                         name="optimal-headline" type="text"></td>
                <td class="optimal-headline-col3"><a id="optimal-headline-generate" href="#" class="button">Generate</a>
                </td>
            </tr>
            <tr>
                <th class="optimal-headline-col1" scope="row"></th>
                <td class="optimal-headline-col2" style="padding-top:0px">
                    <div id="optimal-headline-items-wrap">
                        <ul id="optimal-headline-items"></ul>
                    </div>
                </td>
                <td class="optimal-headline-col3">&nbsp;</td>
            </tr>
            </tbody>
        </table>
        <?php
        $html = ob_get_contents();
        ob_end_clean();

        echo $html;
    }
}

add_action('admin_enqueue_scripts', 'OptimalHeadline::optimal_headline_init');
add_action('admin_menu', 'OptimalHeadline::optimal_headline_create_meta_box');
?>