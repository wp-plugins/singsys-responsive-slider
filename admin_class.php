<?php

    class singsys_slider{
        var $slider_id = -1;

        function __construct($id=-1) {
            $this->slider_id = $id;
        }

        function get_items() {
            global $wpdb;
            $tb_pre = $wpdb->prefix;
            $sql = "select * from {$tb_pre}singsys_items where slider_id={$this->slider_id}";
            return $wpdb->get_results($sql);
        }

        function get_slider() {
            global $wpdb;
            $tb_pre = $wpdb->prefix;
            $sql = "select * from {$tb_pre}singsys_slider where id={$this->slider_id}";
            return $wpdb->get_row($sql);

            //return $this->slider_id;
        }

        function get_slider_list() {
            global $wpdb;
            $tb_pre = $wpdb->prefix;
            $sql = "select * from {$tb_pre}singsys_slider";
            return $wpdb->get_results($sql);
        }

        function count_items($id=-1) {
            global $wpdb;
            $tb_pre = $wpdb->prefix;
            $sql = "select count(id) as total from {$tb_pre}singsys_items where slider_id={$id}";
            $result = $wpdb->get_row($sql);
            return $result->total;
        }

    }
