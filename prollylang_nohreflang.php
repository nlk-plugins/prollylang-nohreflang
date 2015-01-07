<?php
/*
Plugin Name: Prollylang No HREFLANG
Description: The Polylang plugin automatically prints <em>&lt;link rel="alternate" hreflang="...</em> meta tags for translated Pages. This plugin just disables that, in case you are manually adding that elsewhere or just don't want that output.
Version: 0.1
Author: Alex Chousmith
Author URI: http://www.ninthlink.com/
*/


function prollylang_nohreflang_wp_head() {
  /*
   * the issue : polylang/frontend/frontend-links.php
   * doesn't use a named function to add_action to wp_head
   * it uses the $this", so we need to be sneaky to find it
   * and overwrite
   */
  global $wp_filter;
  foreach ( $wp_filter['wp_head'][10] as $k => $v ) {
    if ( is_array( $v ) ) {
      if ( isset( $v['function'] ) ) {
        if ( is_array( $v['function'] ) ) {
          $wp_filter['wp_head'][10][$k]['function'] = 'prollylang_nohreflang';
        }
      }
    }
  }
}

function prollylang_nohreflang() {
  // DO NOTHING : we got it
}

function prollylang_nohreflang_hook() {
  /*
   * this gets triggered AFTER other 'pll_language_defined' hooks
   * so since those trigger from wp_head priority 10,
   * make ours go before that, like priority 1
   */
  add_action('wp_head', 'prollylang_nohreflang_wp_head', 1);
}

add_action( 'pll_language_defined', 'prollylang_nohreflang_hook', 99 );

