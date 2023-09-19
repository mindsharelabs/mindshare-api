<?php


add_action('wp_enqueue_scripts', function () {
  if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) :


  endif;

  $mind_enable_bootstrap = get_field('mind_enable_bootstrap', 'options');
  if($mind_enable_bootstrap) :
    if(in_array('js', $mind_enable_bootstrap)) :
      wp_register_script('mind-bootstrap-js',  MAPI_URL . 'inc/js/bootstrap/bootstrap.bundle.min.js', array('jquery'), MAPI_PLUGIN_VERSION, true);
      wp_enqueue_script('mind-bootstrap-js');
    endif;

    if(in_array('js', $mind_enable_bootstrap)) :
      wp_register_style('mind-bootstrap-grid-css-min', MAPI_URL . 'inc/css/bootstrap-grid.min.css', array(), MAPI_PLUGIN_VERSION);
      wp_enqueue_style('mind-bootstrap-grid-css-min');
      wp_register_style('mind-bootstrap-utilities-css-min', MAPI_URL . 'inc/css/bootstrap-utilities.min.css', array(), MAPI_PLUGIN_VERSION);
      wp_enqueue_style('mind-bootstrap-utilities-css-min');
    endif;
  endif;





}, 100);
