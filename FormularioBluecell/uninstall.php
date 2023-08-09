<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

function formulario_bluecell_uninstall() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'formularios';
    $wpdb->query("DROP TABLE IF EXISTS $table_name");
}

formulario_bluecell_uninstall();