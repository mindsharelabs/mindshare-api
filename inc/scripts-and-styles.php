<?php


add_action('wp_enqueue_scripts', function () {
  if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) :


  endif;

  $mind_enable_bootstrap = get_field('mind_enable_bootstrap', 'options');
  if($mind_enable_bootstrap) :
    if(in_array('js', $mind_enable_bootstrap)) :
      wp_register_script('mind-bootstrap',  MAPI_URL . 'inc/js/bootstrap/bootstrap.bundle.min.js', array('jquery'), MAPI_PLUGIN_VERSION, true);
      wp_enqueue_script('mind-bootstrap');
    endif;

    if(in_array('css', $mind_enable_bootstrap)) :
      wp_register_style('mind-bootstrap-grid-css-min', MAPI_URL . 'inc/css/bootstrap-grid.min.css', array(), MAPI_PLUGIN_VERSION);
      wp_enqueue_style('mind-bootstrap-grid-css-min');
      wp_register_style('mind-bootstrap-utilities-css-min', MAPI_URL . 'inc/css/bootstrap-utilities.min.css', array(), MAPI_PLUGIN_VERSION);
      wp_enqueue_style('mind-bootstrap-utilities-css-min');
    endif;
  endif;



  wp_register_script('mind-modal-init',  MAPI_URL . '/inc/js/modal-init.js', array('jquery', 'mind-bootstrap'), MAPI_PLUGIN_VERSION, true);

  if(get_field('enable_modal', 'options')) :
    wp_enqueue_script('mind-modal-init');
    wp_localize_script( 'mind-modal-init', 'mindModalSettings', array(
      'postID' => get_the_id(),
      'show' => mind_check_page_modal(get_the_id(), get_field('location_settings', 'options'))
    ));

    wp_register_script('mind-notice-cookie-js', 'https://cdn.jsdelivr.net/npm/js-cookie@beta/dist/js.cookie.min.js', array(), MAPI_PLUGIN_VERSION);
    wp_enqueue_script('mind-notice-cookie-js');
  endif;


}, 100);
