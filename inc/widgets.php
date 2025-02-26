<?php
// Creating the widget
class mind_widget extends WP_Widget {

  function __construct() {
    parent::__construct(

      // Base ID of your widget
      'mind_widget',

      // Widget name will appear in UI
      __('Social Media Icons', 'wpb_widget_domain'),

      // Widget description
      array( 'description' => __( 'Simple width to display social media icons.', 'wpb_widget_domain' ), )
    );
  }

  // Creating widget front-end

  public function widget( $args, $instance ) {

    $icons = get_field('social_media_icons', 'widget_' . $args['widget_id']);

    $title = apply_filters( 'widget_title', $instance['title'] );

    // before and after widget arguments are defined by themes
    echo $args['before_widget'];
    if ( ! empty( $title ) )
    echo $args['before_title'] . $title . $args['after_title'];

    // This is where you run the code and display the output
    if($icons) :
      echo '<div class="d-flex flex-row flex-wrap">';
      foreach ($icons as $key => $icon) :
        echo '<a class="d-block me-2" rel="noreferrer" href="' . $icon['link']['url'] . '" title="' . $icon['link']['title'] .'" target="' . $icon['link']['target'] . '"><i class="fa-2x ' . $icon['icon'] . '"></i></a>';
      endforeach;
      echo '</div>';
    endif;



    echo $args['after_widget'];
  }

  // Widget Backend
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    }
    else {
      $title = __( 'New title', 'wpb_widget_domain' );
    }
    // Widget admin form
    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php
  }

  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    return $instance;
  }

  // Class wpb_widget ends here
}


// Register and load the widget
function mind_load_widget() {
  register_widget( 'mind_widget' );
}
add_action( 'widgets_init', 'mind_load_widget' );




add_action('acf/init', function() {

  if( function_exists('acf_add_local_field_group') ):


    acf_add_local_field_group(array(
    	'key' => 'group_607dcd229570e',
    	'title' => 'Widget: Social Media Icons',
    	'fields' => array(
    		array(
    			'key' => 'field_607dcd2fd3795',
    			'label' => 'Social Media Icons',
    			'name' => 'social_media_icons',
    			'type' => 'repeater',
    			'instructions' => '',
    			'required' => 0,
    			'conditional_logic' => 0,
    			'wrapper' => array(
    				'width' => '',
    				'class' => '',
    				'id' => '',
    			),
    			'collapsed' => '',
    			'min' => 0,
    			'max' => 0,
    			'layout' => 'table',
    			'button_label' => '',
    			'sub_fields' => array(
    				array(
    					'key' => 'field_607dcd4dd3796',
    					'label' => 'Icon',
    					'name' => 'icon',
    					'type' => 'text',
    					'instructions' => '<a href="fontawesome.com/icons">fontawesome.com/icons</a>',
    					'required' => 0,
    					'conditional_logic' => 0,
    					'wrapper' => array(
    						'width' => '',
    						'class' => '',
    						'id' => '',
    					),
    					'default_value' => '',
    					'placeholder' => '',
    					'prepend' => '',
    					'append' => '',
    					'maxlength' => '',
    				),
    				array(
    					'key' => 'field_607dcd51d3797',
    					'label' => 'Link',
    					'name' => 'link',
    					'type' => 'link',
    					'instructions' => '',
    					'required' => 0,
    					'conditional_logic' => 0,
    					'wrapper' => array(
    						'width' => '',
    						'class' => '',
    						'id' => '',
    					),
    					'return_format' => 'array',
    				),
    			),
    		),
    	),
    	'location' => array(
    		array(
    			array(
    				'param' => 'widget',
    				'operator' => '==',
    				'value' => 'mind_widget',
    			),
    		),
    	),
    	'menu_order' => 0,
    	'position' => 'normal',
    	'style' => 'default',
    	'label_placement' => 'top',
    	'instruction_placement' => 'label',
    	'hide_on_screen' => '',
    	'active' => true,
    	'description' => '',
    ));

  endif;

});
