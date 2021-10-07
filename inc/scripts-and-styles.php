<?php





add_action('wp_enqueue_scripts', function () {
  if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) :


  endif;


  wp_register_script('mind-bootstrap',  MAPI_URL . '/inc/js/bootstrap/bootstrap.bundle.min.js', array('jquery'), MAPI_PLUGIN_VERSION, true);
  wp_enqueue_script('mind-bootstrap');


  wp_register_script('mind-modal-init',  MAPI_URL . '/inc/js/modal-init.js', array('jquery', 'mind-bootstrap'), MAPI_PLUGIN_VERSION, true);

  if(get_field('enable_modal', 'options')) :
    wp_enqueue_script('mind-modal-init');
    wp_localize_script( 'mind-modal-init', 'mindModalSettings', array(
      'postID' => get_the_id(),
      'show' => mind_check_page_modal(get_the_id(), get_field('location_settings', 'options'))
    ));
  endif;


}, 100);
