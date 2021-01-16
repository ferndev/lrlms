<?php
/*
Plugin Name: LRLMS
Plugin URI: LRLms.local
Description: A Wordpress Plugin as a tool for the creation and delivery of sophisticated courses and tutorials. Work in progress
Author: Fernando Martinez
Version: 0.1.1
*/

defined( 'ABSPATH' ) || exit();
if ( ! defined( 'LR_PLUGIN_FILE' ) ) {
    define( 'LR_PLUGIN_FILE', __FILE__ );
    define( 'LR_PLUGIN_DIR', dirname( __FILE__ ) );
}

if ( ! class_exists( 'LrLms' ) ) {
    include_once dirname( __FILE__ ) . '/classes/util/LrLmsConstants.php';
    include_once dirname( __FILE__ ) . '/classes/util/MetaFields.php';
    include_once dirname( __FILE__ ) . '/classes/util/html/HtmlBase.php';
    include_once dirname( __FILE__ ) . '/classes/util/html/HtmlCtrl.php';
    include_once dirname( __FILE__ ) . '/classes/util/html/web/HtmlInput.php';
    include_once dirname( __FILE__ ) . '/classes/util/html/web/HtmlDiv.php';
    include_once dirname( __FILE__ ) . '/classes/util/html/web/HtmlOption.php';
    include_once dirname( __FILE__ ) . '/classes/util/html/web/HtmlSelect.php';
    include_once dirname( __FILE__ ) . '/classes/LrLms.php';
}

function lr() {
    return LrLms::create();
}
if (!isset($GLOBALS['lrlms'])) {
    $GLOBALS['lrlms'] = lr();
}
