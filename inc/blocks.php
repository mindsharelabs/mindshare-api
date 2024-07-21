<?php
/**
* Register custom Gutenberg blocks category
*
*/




add_filter('block_categories_all', function ($categories, $post) {
	$icon = '<svg xmlns="http://www.w3.org/2000/svg" width="2000" height="621.762" viewBox="0 0 2000 621.762">
				<g id="Layer_1" data-name="Layer 1">
					<polygon points="1961.538 466.322 1923.077 466.322 1923.077 466.321 1923.077 466.322 1884.615 466.322 1846.154 466.322 1846.154 488.527 1846.154 510.733 1846.154 532.939 1846.154 555.145 1846.154 577.35 1846.154 599.556 1846.154 621.762 1884.615 621.762 1923.077 621.762 1961.538 621.762 2000 621.762 2000 599.556 2000 577.35 2000 555.145 2000 532.939 2000 510.733 2000 488.527 2000 466.322 1961.538 466.322" style="fill: #495972"/>
					<g>
					<polygon points="692.308 0 692.308 0 692.307 0 653.846 0 615.385 0 576.923 0 538.462 0 538.462 0 538.461 0 500 0 461.538 0 423.077 0 384.615 0 384.615 0 384.615 0 346.154 0 307.692 0 269.231 0 230.769 0 230.769 0 230.769 0 192.308 0 153.846 0 115.385 0 76.923 0 76.923 0 76.923 0 38.462 0 0 0 0 22.206 0 44.412 0 66.617 0 88.823 0 111.029 0 133.235 0 155.44 0 177.647 0 199.852 0 222.058 0 244.264 0 266.47 0 288.675 0 310.881 0 333.087 0 355.293 0 377.499 0 399.704 0 421.91 0 444.116 0 466.322 0 488.527 0 510.733 0 532.939 0 555.145 0 577.351 0 599.556 0 621.762 38.462 621.762 76.923 621.762 115.385 621.762 153.846 621.762 153.846 599.556 153.846 577.351 153.846 555.145 153.846 532.939 153.846 510.733 153.846 488.527 153.846 466.322 153.846 444.116 153.846 421.91 153.846 399.704 153.846 377.499 153.846 355.293 153.846 333.087 153.846 310.881 153.846 288.675 153.846 266.47 153.846 244.264 153.846 222.058 153.846 199.852 153.846 177.647 153.846 155.44 192.308 155.44 230.769 155.44 269.231 155.44 307.692 155.44 307.692 177.647 307.692 199.852 307.692 222.058 307.692 244.264 307.692 266.47 307.692 288.675 307.692 310.881 307.692 333.087 307.692 355.293 307.692 377.499 307.692 399.704 307.692 421.91 307.692 444.116 307.692 466.322 307.692 488.527 307.692 510.733 307.692 532.939 307.692 555.145 307.692 577.351 307.692 599.556 307.692 621.762 346.154 621.762 384.615 621.762 423.077 621.762 461.538 621.762 461.538 599.556 461.538 577.351 461.538 555.145 461.538 532.939 461.538 510.733 461.538 488.527 461.538 466.322 461.538 444.116 461.538 421.91 461.538 399.704 461.538 377.499 461.538 355.293 461.538 333.087 461.538 310.881 461.538 288.675 461.538 266.47 461.538 244.264 461.538 222.058 461.538 199.852 461.538 177.647 461.538 155.44 500 155.44 538.462 155.44 576.923 155.44 615.385 155.44 615.385 177.647 615.385 199.852 615.385 222.058 615.385 244.264 615.385 266.47 615.385 288.675 615.385 310.881 615.385 333.087 615.385 355.293 615.385 377.499 615.385 399.704 615.385 421.91 615.385 444.116 615.385 466.322 615.385 488.527 615.385 510.733 615.385 532.939 615.385 555.145 615.385 577.351 615.385 599.556 615.385 621.762 653.846 621.762 692.308 621.762 730.769 621.762 769.231 621.762 769.231 599.556 769.231 577.351 769.231 555.145 769.231 532.939 769.231 510.733 769.231 488.527 769.231 466.322 769.231 444.116 769.231 421.91 769.231 399.704 769.231 377.499 769.231 355.293 769.231 333.087 769.231 310.881 769.231 288.675 769.231 266.47 769.231 244.264 769.231 222.058 769.231 199.852 769.231 177.647 769.231 155.44 769.231 133.235 769.231 111.029 769.231 88.823 769.231 66.617 769.231 44.412 769.231 22.206 769.231 0 730.769 0 692.308 0" style="fill: #d2a63b"/>
					<polygon points="1653.846 0 1615.385 0 1615.385 0 1615.385 0 1576.923 0 1538.462 0 1500 0 1461.539 0 1461.538 0 1461.538 0 1423.077 0 1384.615 0 1346.154 0 1307.693 0 1307.692 0 1307.692 0 1269.231 0 1230.769 0 1230.769 22.206 1230.769 44.412 1230.769 66.617 1230.769 88.823 1230.769 111.029 1230.769 133.235 1230.769 155.44 1230.769 177.647 1230.769 199.852 1230.769 222.058 1230.769 244.264 1230.769 266.47 1230.769 288.675 1230.769 310.881 1230.769 333.087 1230.769 355.293 1230.769 377.499 1230.769 399.704 1230.769 421.91 1230.769 444.116 1230.769 466.322 1192.308 466.322 1153.846 466.322 1153.846 466.321 1153.846 466.322 1115.385 466.322 1076.923 466.322 1076.923 444.116 1076.923 421.91 1076.923 399.704 1076.923 377.499 1076.923 355.293 1076.923 333.087 1076.923 310.881 1076.923 288.675 1076.923 266.47 1076.923 244.264 1076.923 222.058 1076.923 199.852 1076.923 177.647 1076.923 155.44 1076.923 133.235 1076.923 111.029 1076.923 88.823 1076.923 66.617 1076.923 44.412 1076.923 22.206 1076.923 0 1038.462 0 1000 0 1000 0 1000 0 961.538 0 923.077 0 923.077 22.206 923.077 44.412 923.077 66.617 923.077 88.823 923.077 111.029 923.077 133.235 923.077 155.44 923.077 177.647 923.077 199.852 923.077 222.058 923.077 244.264 923.077 266.47 923.077 288.675 923.077 310.881 923.077 333.087 923.077 355.293 923.077 377.499 923.077 399.704 923.077 421.91 923.077 444.116 923.077 466.322 923.077 488.527 923.077 510.733 923.077 532.939 923.077 555.145 923.077 577.351 923.077 599.556 923.077 621.762 961.538 621.762 1000 621.762 1038.462 621.762 1076.923 621.762 1115.385 621.762 1153.846 621.762 1192.308 621.762 1230.769 621.762 1269.231 621.762 1307.692 621.762 1346.154 621.762 1384.615 621.762 1384.615 599.556 1384.615 577.351 1384.615 555.145 1384.615 532.939 1384.615 510.733 1384.615 488.527 1384.615 466.322 1384.615 444.116 1384.615 421.91 1384.615 399.704 1384.615 377.499 1384.615 355.293 1384.615 333.087 1384.615 310.881 1384.615 288.675 1384.615 266.47 1384.615 244.264 1384.615 222.058 1384.615 199.852 1384.615 177.647 1384.615 155.44 1423.077 155.44 1461.538 155.44 1500 155.44 1538.462 155.44 1538.462 177.647 1538.462 199.852 1538.462 222.058 1538.462 244.264 1538.462 266.47 1538.462 288.675 1538.462 310.881 1538.462 333.087 1538.462 355.293 1538.462 377.499 1538.462 399.704 1538.462 421.91 1538.462 444.116 1538.462 466.322 1538.462 488.527 1538.462 510.733 1538.462 532.939 1538.462 555.145 1538.462 577.351 1538.462 599.556 1538.462 621.762 1576.923 621.762 1615.385 621.762 1653.846 621.762 1692.308 621.762 1692.308 599.556 1692.308 577.351 1692.308 555.145 1692.308 532.939 1692.308 510.733 1692.308 488.527 1692.308 466.322 1692.308 444.116 1692.308 421.91 1692.308 399.704 1692.308 377.499 1692.308 355.293 1692.308 333.087 1692.308 310.881 1692.308 288.675 1692.308 266.47 1692.308 244.264 1692.308 222.058 1692.308 199.852 1692.308 177.647 1692.308 155.44 1692.308 133.235 1692.308 111.029 1692.308 88.823 1692.308 66.617 1692.308 44.412 1692.308 22.206 1692.308 0 1653.846 0" style="fill: #d2a63b"/>
					</g>
				</g>
			</svg>';
	return array_merge(
		$categories,
		array(
			array(
				'slug' 	=> 'mind-blocks',
				'title' => __('Mindshare Blocks', 'mindshare'),
				'icon' 	=> $icon,
			),

		)
	);
}, 10, 2);

add_action('acf/init', function () {

	$icon = '<svg xmlns="http://www.w3.org/2000/svg" width="2000" height="621.762" viewBox="0 0 2000 621.762">
				<g id="Layer_1" data-name="Layer 1">
					<polygon points="1961.538 466.322 1923.077 466.322 1923.077 466.321 1923.077 466.322 1884.615 466.322 1846.154 466.322 1846.154 488.527 1846.154 510.733 1846.154 532.939 1846.154 555.145 1846.154 577.35 1846.154 599.556 1846.154 621.762 1884.615 621.762 1923.077 621.762 1961.538 621.762 2000 621.762 2000 599.556 2000 577.35 2000 555.145 2000 532.939 2000 510.733 2000 488.527 2000 466.322 1961.538 466.322" style="fill: #495972"/>
					<g>
					<polygon points="692.308 0 692.308 0 692.307 0 653.846 0 615.385 0 576.923 0 538.462 0 538.462 0 538.461 0 500 0 461.538 0 423.077 0 384.615 0 384.615 0 384.615 0 346.154 0 307.692 0 269.231 0 230.769 0 230.769 0 230.769 0 192.308 0 153.846 0 115.385 0 76.923 0 76.923 0 76.923 0 38.462 0 0 0 0 22.206 0 44.412 0 66.617 0 88.823 0 111.029 0 133.235 0 155.44 0 177.647 0 199.852 0 222.058 0 244.264 0 266.47 0 288.675 0 310.881 0 333.087 0 355.293 0 377.499 0 399.704 0 421.91 0 444.116 0 466.322 0 488.527 0 510.733 0 532.939 0 555.145 0 577.351 0 599.556 0 621.762 38.462 621.762 76.923 621.762 115.385 621.762 153.846 621.762 153.846 599.556 153.846 577.351 153.846 555.145 153.846 532.939 153.846 510.733 153.846 488.527 153.846 466.322 153.846 444.116 153.846 421.91 153.846 399.704 153.846 377.499 153.846 355.293 153.846 333.087 153.846 310.881 153.846 288.675 153.846 266.47 153.846 244.264 153.846 222.058 153.846 199.852 153.846 177.647 153.846 155.44 192.308 155.44 230.769 155.44 269.231 155.44 307.692 155.44 307.692 177.647 307.692 199.852 307.692 222.058 307.692 244.264 307.692 266.47 307.692 288.675 307.692 310.881 307.692 333.087 307.692 355.293 307.692 377.499 307.692 399.704 307.692 421.91 307.692 444.116 307.692 466.322 307.692 488.527 307.692 510.733 307.692 532.939 307.692 555.145 307.692 577.351 307.692 599.556 307.692 621.762 346.154 621.762 384.615 621.762 423.077 621.762 461.538 621.762 461.538 599.556 461.538 577.351 461.538 555.145 461.538 532.939 461.538 510.733 461.538 488.527 461.538 466.322 461.538 444.116 461.538 421.91 461.538 399.704 461.538 377.499 461.538 355.293 461.538 333.087 461.538 310.881 461.538 288.675 461.538 266.47 461.538 244.264 461.538 222.058 461.538 199.852 461.538 177.647 461.538 155.44 500 155.44 538.462 155.44 576.923 155.44 615.385 155.44 615.385 177.647 615.385 199.852 615.385 222.058 615.385 244.264 615.385 266.47 615.385 288.675 615.385 310.881 615.385 333.087 615.385 355.293 615.385 377.499 615.385 399.704 615.385 421.91 615.385 444.116 615.385 466.322 615.385 488.527 615.385 510.733 615.385 532.939 615.385 555.145 615.385 577.351 615.385 599.556 615.385 621.762 653.846 621.762 692.308 621.762 730.769 621.762 769.231 621.762 769.231 599.556 769.231 577.351 769.231 555.145 769.231 532.939 769.231 510.733 769.231 488.527 769.231 466.322 769.231 444.116 769.231 421.91 769.231 399.704 769.231 377.499 769.231 355.293 769.231 333.087 769.231 310.881 769.231 288.675 769.231 266.47 769.231 244.264 769.231 222.058 769.231 199.852 769.231 177.647 769.231 155.44 769.231 133.235 769.231 111.029 769.231 88.823 769.231 66.617 769.231 44.412 769.231 22.206 769.231 0 730.769 0 692.308 0" style="fill: #d2a63b"/>
					<polygon points="1653.846 0 1615.385 0 1615.385 0 1615.385 0 1576.923 0 1538.462 0 1500 0 1461.539 0 1461.538 0 1461.538 0 1423.077 0 1384.615 0 1346.154 0 1307.693 0 1307.692 0 1307.692 0 1269.231 0 1230.769 0 1230.769 22.206 1230.769 44.412 1230.769 66.617 1230.769 88.823 1230.769 111.029 1230.769 133.235 1230.769 155.44 1230.769 177.647 1230.769 199.852 1230.769 222.058 1230.769 244.264 1230.769 266.47 1230.769 288.675 1230.769 310.881 1230.769 333.087 1230.769 355.293 1230.769 377.499 1230.769 399.704 1230.769 421.91 1230.769 444.116 1230.769 466.322 1192.308 466.322 1153.846 466.322 1153.846 466.321 1153.846 466.322 1115.385 466.322 1076.923 466.322 1076.923 444.116 1076.923 421.91 1076.923 399.704 1076.923 377.499 1076.923 355.293 1076.923 333.087 1076.923 310.881 1076.923 288.675 1076.923 266.47 1076.923 244.264 1076.923 222.058 1076.923 199.852 1076.923 177.647 1076.923 155.44 1076.923 133.235 1076.923 111.029 1076.923 88.823 1076.923 66.617 1076.923 44.412 1076.923 22.206 1076.923 0 1038.462 0 1000 0 1000 0 1000 0 961.538 0 923.077 0 923.077 22.206 923.077 44.412 923.077 66.617 923.077 88.823 923.077 111.029 923.077 133.235 923.077 155.44 923.077 177.647 923.077 199.852 923.077 222.058 923.077 244.264 923.077 266.47 923.077 288.675 923.077 310.881 923.077 333.087 923.077 355.293 923.077 377.499 923.077 399.704 923.077 421.91 923.077 444.116 923.077 466.322 923.077 488.527 923.077 510.733 923.077 532.939 923.077 555.145 923.077 577.351 923.077 599.556 923.077 621.762 961.538 621.762 1000 621.762 1038.462 621.762 1076.923 621.762 1115.385 621.762 1153.846 621.762 1192.308 621.762 1230.769 621.762 1269.231 621.762 1307.692 621.762 1346.154 621.762 1384.615 621.762 1384.615 599.556 1384.615 577.351 1384.615 555.145 1384.615 532.939 1384.615 510.733 1384.615 488.527 1384.615 466.322 1384.615 444.116 1384.615 421.91 1384.615 399.704 1384.615 377.499 1384.615 355.293 1384.615 333.087 1384.615 310.881 1384.615 288.675 1384.615 266.47 1384.615 244.264 1384.615 222.058 1384.615 199.852 1384.615 177.647 1384.615 155.44 1423.077 155.44 1461.538 155.44 1500 155.44 1538.462 155.44 1538.462 177.647 1538.462 199.852 1538.462 222.058 1538.462 244.264 1538.462 266.47 1538.462 288.675 1538.462 310.881 1538.462 333.087 1538.462 355.293 1538.462 377.499 1538.462 399.704 1538.462 421.91 1538.462 444.116 1538.462 466.322 1538.462 488.527 1538.462 510.733 1538.462 532.939 1538.462 555.145 1538.462 577.351 1538.462 599.556 1538.462 621.762 1576.923 621.762 1615.385 621.762 1653.846 621.762 1692.308 621.762 1692.308 599.556 1692.308 577.351 1692.308 555.145 1692.308 532.939 1692.308 510.733 1692.308 488.527 1692.308 466.322 1692.308 444.116 1692.308 421.91 1692.308 399.704 1692.308 377.499 1692.308 355.293 1692.308 333.087 1692.308 310.881 1692.308 288.675 1692.308 266.47 1692.308 244.264 1692.308 222.058 1692.308 199.852 1692.308 177.647 1692.308 155.44 1692.308 133.235 1692.308 111.029 1692.308 88.823 1692.308 66.617 1692.308 44.412 1692.308 22.206 1692.308 0 1653.846 0" style="fill: #d2a63b"/>
					</g>
				</g>
			</svg>';
	// Check function exists.
	if( function_exists('acf_register_block_type') ) {

		acf_register_block_type(array(
			'name'              => 'mind-sub-page-list',
			'title'             => __('Sub Page List'),
			'description'       => __('A block that displays all of the sub pages in a navigation latout.'),
			'render_template'   => MAPI_ABSPATH . '/inc/block-templates/mind-sub-page-list.php',
			'category'          => 'mind-blocks',
			'icon'              => $icon,
			'keywords'          => array( 'navigation', 'sub', 'page', 'button', 'mind', 'Mindshare' ),
			'align'             => 'full',
			'mode'            	=> 'preview',
			'supports'					=> array(
				'align' => false,
				'mode' => false,
				'jsx' => false
			),
			'enqueue_assets' => function(){
				// We're just registering it here and then with the action get_footer we'll enqueue it.
				wp_register_style( 'mind-block-styles', MAPI_URL . 'inc/css/block-styles.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('mind-block-styles');});

			},
		));

		acf_register_block_type(array(
			'name'              => 'mind-notice-block',
			'title'             => __('Notice Block'),
			'description'       => __('A block that displays a simple notice as a gutenberg block.'),
			'render_template'   => MAPI_ABSPATH . '/inc/block-templates/mind-notice-block.php',
			'category'          => 'mind-blocks',
			'icon'              => $icon,
			'keywords'          => array( 'staff', 'cards', 'button', 'mind', 'Mindshare' ),
			'align'             => 'full',
			'mode'            	=> 'edit',
			'supports'					=> array(
				'align' => false,
				'mode' => false,
				'jsx' => false
			),
			'enqueue_assets' => function(){
				// We're just registering it here and then with the action get_footer we'll enqueue it.
				wp_register_style( 'mind-block-styles', MAPI_URL . 'inc/css/block-styles.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('mind-block-styles');});

			},
		));


		acf_register_block_type(array(
			'name'              => 'mind-staff-cards',
			'title'             => __('Staff Cards'),
			'description'       => __('A block that displays a list of staff cards.'),
			'render_template'   => MAPI_ABSPATH . '/inc/block-templates/mind-staff-cards.php',
			'category'          => 'mind-blocks',
			'icon'              => $icon,
			'keywords'          => array( 'staff', 'cards', 'button', 'mind', 'Mindshare' ),
			'align'             => 'full',
			'mode'            	=> 'edit',
			'supports'					=> array(
				'align' => false,
				'mode' => false,
				'jsx' => false
			),
			'enqueue_assets' => function(){
				// We're just registering it here and then with the action get_footer we'll enqueue it.
				wp_register_style( 'mind-block-styles', MAPI_URL . 'inc/css/block-styles.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('mind-block-styles');});

			},
		)
	);

		acf_register_block_type(array(
			'name'              => 'mind-button',
			'title'             => __('Theme Specific Button Group'),
			'description'       => __('One or more buttons that are theme specific and matche theme branding/colors.'),
			'render_template'   => MAPI_ABSPATH . '/inc/block-templates/mind-button.php',
			'category'          => 'mind-blocks',
			'icon'              => $icon,
			'keywords'          => array( 'button', 'mind', 'Mindshare' ),
			'align'             => 'full',
			'mode'            	=> 'edit',
			'supports'					=> array(
				'align' => false,
				'mode' => false,
				'jsx' => false
			),
			'enqueue_assets' => function(){
				// We're just registering it here and then with the action get_footer we'll enqueue it.
				wp_register_style( 'mind-block-styles', MAPI_URL . 'inc/css/block-styles.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('mind-block-styles');});

			},
		)
	);

		acf_register_block_type(array(
			'name'              => 'image-and-content',
			'title'             => __('Image and Content'),
			'description'       => __('A media and image block. The Image aligns to the edge of the screen.'),
			'render_template'   => MAPI_ABSPATH . '/inc/block-templates/media-and-image.php',
			'category'          => 'mind-blocks',
			'icon'              => $icon,
			'keywords'          => array( 'media', 'image', 'fill', 'full', 'width', 'mind', 'Mindshare' ),
			'align'             => 'full',
			'mode'            	=> 'preview',
			'supports'					=> array(
				'align' => true,
				'mode' => false,
				'jsx' => true
			),
			'enqueue_assets' => function(){
				// We're just registering it here and then with the action get_footer we'll enqueue it.
				wp_register_style( 'mapi-block-styles', MAPI_URL . '/inc/css/block-styles.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('mapi-block-styles');});

			},
		)
	);


		acf_register_block_type(array(
			'name'              => 'card-repeater-block',
			'title'             => __('Custom Card Repeater Block'),
			'description'       => __('A repeater block for a bootstrap card layout.'),
			'render_template'   => MAPI_ABSPATH . '/inc/block-templates/card-repeater-block.php',
			'category'          => 'mind-blocks',
			'icon'              => $icon,
			'keywords'          => array( 'cards', 'repeater','mind', 'Mindshare' ),
			'align'             => 'full',
			'mode'            	=> 'edit',
			'supports'					=> array(
				'align' => false,
			),
			'enqueue_assets' => function(){
				// We're just registering it here and then with the action get_footer we'll enqueue it.
				wp_register_style( 'mapi-block-styles', MAPI_URL . '/inc/css/block-styles.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('mapi-block-styles');});

			},
		)
	);


		acf_register_block_type(array(
			'name'              => 'post-list-block',
			'title'             => __('Post List Block'),
			'description'       => __('A gallery or list view for posts.'),
			'render_template'   => MAPI_ABSPATH . '/inc/block-templates/post-list-block.php',
			'category'          => 'mind-blocks',
			'icon'              => $icon,
			'keywords'          => array( 'posts', 'list', 'gallery', 'mapi', 'libraries', 'Mindshare' ),
			'align'             => 'full',
			'mode'            	=> 'edit',
			'supports'					=> array(
				'align' => false,
			),
			'enqueue_assets' => function(){
				// We're just registering it here and then with the action get_footer we'll enqueue it.
				wp_register_style( 'mapi-block-styles', MAPI_URL . '/inc/css/block-styles.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('mapi-block-styles');});

			},
		)
	);

		//Block: Map w/ Markers
		acf_register_block_type(array(
			'name'              => 'map-w-marker',
			'title'             => __('Map with Markers'),
			'description'       => __('A map block using the mapbox API.'),
			'render_template'   => MAPI_ABSPATH . '/inc/block-templates/map-w-marker.php',
			'category'          => 'mind-blocks',
			'icon'              => $icon,
			'keywords'          => array( 'call', 'action', 'brand', 'space', 'button', 'main'),
			'align'             => 'full',
			'mode'            	=> 'edit',
			'supports'					=> array(
				'align' => false,
			),
			'enqueue_assets' => function(){
				// We're just registering it here and then with the action get_footer we'll enqueue it.
				wp_register_style( 'mapi-block-styles', MAPI_URL . 'inc/css/block-styles.css', array(), MAPI_PLUGIN_VERSION );
				add_action( 'get_footer', function () {wp_enqueue_style('mapi-block-styles');});

				$google_maps_api = get_field('google_maps_api', 'options');
				wp_register_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=' . ($google_maps_api ? $google_maps_api : ''), array('jquery'), MAPI_PLUGIN_VERSION, true);
				wp_enqueue_script('google-maps');

				wp_register_script('google-maps-clustering', 'https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js', array('jquery', 'google-maps'), MAPI_PLUGIN_VERSION, true);
				wp_enqueue_script('google-maps-clustering');

				wp_register_script('map-block-init', MAPI_URL . 'inc/js/map-init.js', array('jquery', 'google-maps', 'google-maps-clustering'), MAPI_PLUGIN_VERSION, true);
				wp_enqueue_script('map-block-init');
				wp_localize_script( 'map-block-init', 'map_param_data', array(
					'postID' => get_the_id(), // WordPress AJAX
					));


			},
		)
	);

		//Block: Image Slider
		acf_register_block_type(array(
			'name'              => 'image-slider',
			'title'             => __('Image Slider'),
			'description'       => __('This block displays an image slider with captions.'),
			'render_template'   => MAPI_ABSPATH . '/inc/block-templates/image-slider.php',
			'category'          => 'mind-blocks',
			'icon'              => $icon,
			'keywords'          => array( 'slider', 'image', 'captions', 'Mindshare' ),
			'align'             => 'full',
			'mode'            	=> 'edit',
			'supports'					=> array(
				'align' => false,
			),
			'enqueue_assets' => function(){
				// We're just registering it here and then with the action get_footer we'll enqueue it.
				wp_register_style( 'mapi-block-styles', MAPI_URL . 'inc/css/block-styles.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('mapi-block-styles');});

				wp_register_style( 'slick-styles', MAPI_URL . 'inc/css/slick.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('slick-styles');});

				if(!is_admin()) :
					wp_register_script('slick-slider', MAPI_URL . 'inc/js/slick.min.js', array('jquery'), MAPI_PLUGIN_VERSION);
					wp_enqueue_script('slick-slider');

					wp_register_script('image-slider-js', MAPI_URL. 'inc/js/image-slider.js', array('jquery', 'slick-slider'), MAPI_PLUGIN_VERSION, true);
					wp_enqueue_script('image-slider-js');

					// wp_localize_script( 'image-slider-js', 'sliderOptions', array(
					// 	'arrows' => get_field('mapi_slider_arrows', get_the_id()),
					// 	'dots' => get_field('mapi_slider_dots', get_the_id())
					// ));
				endif;

			},
		)
	);


		//Block: Logo Slider
		acf_register_block_type(array(
			'name'              => 'mind-logo-slider',
			'title'             => __('Logo Slider'),
			'description'       => __('This block displays multiple logos in an infite slideshow.'),
			'render_template'   => MAPI_ABSPATH . '/inc/block-templates/mind-logo-slider.php',
			'category'          => 'mind-blocks',
			'icon'              => $icon,
			'keywords'          => array( 'logo', 'sponsors', 'logos', 'slider', 'image', 'captions', 'Mindshare' ),
			'align'             => 'full',
			'mode'            	=> 'edit',
			'supports'					=> array(
				'align' => false,
			),
			'enqueue_assets' => function(){
				// We're just registering it here and then with the action get_footer we'll enqueue it.
				wp_register_style( 'mapi-block-styles', MAPI_URL . 'inc/css/block-styles.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('mapi-block-styles');});

				wp_register_style( 'slick-styles', MAPI_URL . 'inc/css/slick.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('slick-styles');});

				if(!is_admin()) :
					wp_register_script('mapi-slick-slider', MAPI_URL . 'inc/js/slick.min.js', array('jquery'), MAPI_PLUGIN_VERSION);
					wp_enqueue_script('mapi-slick-slider');

					wp_register_script('image-slider-js', MAPI_URL. 'inc/js/image-slider.js', array('jquery', 'slick-slider'), MAPI_PLUGIN_VERSION, true);
					wp_enqueue_script('image-slider-js');

					// wp_localize_script( 'image-slider-js', 'sliderOptions', array(
					// 	'arrows' => get_field('mapi_slider_arrows', get_the_id()),
					// 	'dots' => get_field('mapi_slider_dots', get_the_id())
					// ));
				endif;

			},
		)
	);

		//Block: Image Grid
		acf_register_block_type(array(
			'name'              => 'image-grid',
			'title'             => __('Image Grid'),
			'description'       => __('This block displays a grid of images with titles, captions and an optional link.'),
			'render_template'   => MAPI_ABSPATH . '/inc/block-templates/image-grid.php',
			'category'          => 'mind-blocks',
			'icon'              => $icon,
			'keywords'          => array( 'grid', 'gallery', 'image', 'captions', 'Mindshare' ),
			'align'             => 'full',
			'mode'            	=> 'edit',
			'supports'					=> array(
				'align' => false,
			),
			'enqueue_assets' => function(){

					// We're just registering it here and then with the action get_footer we'll enqueue it.
				wp_register_style( 'mapi-block-styles', MAPI_URL . 'inc/css/block-styles.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('mapi-block-styles');});

				wp_register_style( 'lightbox-styles', MAPI_URL . 'inc/css/simple-lightbox.min.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('lightbox-styles');});

				//https://github.com/andreknieriem/simplelightbox
				wp_register_script('image-lightbox-js', MAPI_URL. 'inc/js/simple-lightbox.jquery.min.js', array('jquery'), MAPI_PLUGIN_VERSION, true);
				wp_enqueue_script('image-lightbox-js');


				wp_register_script('masonry-js', 'https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js', array('jquery'), MAPI_PLUGIN_VERSION, true);
				wp_enqueue_script('masonry-js');

				wp_register_script('lightbox-init', MAPI_URL. 'inc/js/lightbox-init.js', array('jquery', 'image-lightbox-js'), MAPI_PLUGIN_VERSION, true);
				wp_enqueue_script('lightbox-init');

			},
		)
	);

		//Block: Container
		acf_register_block_type(array(
			'name'              => 'container',
			'title'             => __('Container Block'),
			'description'       => __('A block that limits the width of content based on some selection criteria.'),
			'render_template'   => MAPI_ABSPATH . '/inc/block-templates/container.php',
			'category'          => 'mind-blocks',
			'icon'              => $icon,
			'keywords'          => array( 'container', 'width', 'Mindshare' ),
			'align'             => 'full',
			'mode'            	=> 'preview',
			'supports'					=> array(
				'align' => true,
				'mode' => false,
				'jsx' => true
			),
		)
	);


		acf_register_block_type(array(
			'name'              => 'accordion-block',
			'title'             => __('Accordion'),
			'description'       => __('A repeating accordion block.'),
			'render_template'   => MAPI_ABSPATH . '/inc/block-templates/accordion-block.php',
			'category'          => 'mind-blocks',
			'icon'              => $icon,
			'keywords'          => array( 'accordion', 'repeater', 'collapse', 'Mindshare' ),
			'align'             => 'full',
			'mode'            	=> 'edit',
			'supports'					=> array(
				'align' => false,
			),
			'enqueue_assets' => function(){
				// We're just registering it here and then with the action get_footer we'll enqueue it.
				wp_register_style( 'mapi-block-styles', MAPI_URL . '/inc/css/block-styles.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('mapi-block-styles');});
				//
				wp_register_script('bootstrap-js', MAPI_URL . 'inc/js/bootstrap/bootstrap.bundle.min.js', array('jquery'), MAPI_PLUGIN_VERSION);
				wp_enqueue_script('bootstrap-js');




			},
		)
	);




	}
}, 1);





if( function_exists('acf_add_local_field_group') ):
	add_action( 'acf/init', function() {

		global $_wp_additional_image_sizes;
		$args = array(
			'public' => true
		);
		$all_post_types = get_post_types($args, 'names', 'and' );

		//Block: Staff Cards
		acf_add_local_field_group(array(
			'key' => 'group_60908a6e732fb',
			'title' => 'Block: Staff Cards',
			'fields' => array(
				array(
					'key' => 'field_60908adc7c75d',
					'label' => 'Staff Cards',
					'name' => 'mind_staff_cards',
					'type' => 'group',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'layout' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_60908ae97c75e',
							'label' => 'Staff Cards',
							'name' => 'staff_cards',
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
							'layout' => 'row',
							'button_label' => 'Add Staff',
							'sub_fields' => array(
								array(
									'key' => 'field_60908af17c75f',
									'label' => 'Image',
									'name' => 'image',
									'type' => 'image',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'return_format' => 'array',
									'preview_size' => 'medium',
									'library' => 'all',
									'min_width' => '',
									'min_height' => '',
									'min_size' => '',
									'max_width' => '',
									'max_height' => '',
									'max_size' => '',
									'mime_types' => '',
								),
								array(
									'key' => 'field_60908af57c760',
									'label' => 'Name',
									'name' => 'name',
									'type' => 'text',
									'instructions' => '',
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
									'key' => 'field_60908afb7c761',
									'label' => 'Title',
									'name' => 'title',
									'type' => 'text',
									'instructions' => '',
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
									'key' => 'field_60908aff7c762',
									'label' => 'Short Bio',
									'name' => 'short_bio',
									'type' => 'textarea',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'maxlength' => '',
									'rows' => 3,
									'new_lines' => '',
								),
								array(
									'key' => 'field_60908b0b7c763',
									'label' => 'Staff Links',
									'name' => 'staff_links',
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
									'button_label' => 'Add Link',
									'sub_fields' => array(
										array(
											'key' => 'field_60908b137c764',
											'label' => 'Icon',
											'name' => 'icon',
											'type' => 'text',
											'instructions' => '',
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
											'key' => 'field_60908b177c765',
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
								array(
									'key' => 'field_60908de49bc1f',
									'label' => 'Staff Member Profile',
									'name' => 'staff_page_link',
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
),
),
'location' => array(
	array(
		array(
			'param' => 'block',
			'operator' => '==',
			'value' => 'acf/mind-staff-cards',
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

		//Block: Theme Specific Buttons
acf_add_local_field_group(array(
	'key' => 'group_607de32bb0b5d',
	'title' => 'Block: Buttons',
	'fields' => array(
		array(
			'key' => 'field_607de32f51a5d',
			'label' => 'Theme Specific Buttons',
			'name' => 'mind_buttons',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layout' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_607de39051a62',
					'label' => 'Buttons',
					'name' => 'buttons',
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
							'key' => 'field_607de33b51a5f',
							'label' => 'Button Link',
							'name' => 'button_link',
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
						array(
							'key' => 'field_607de34151a60',
							'label' => 'Button Type',
							'name' => 'button_type',
							'type' => 'select',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'choices' => array(
								'primary' => 'Primary',
								'secondary' => 'Secondary',
								'success' => 'Success',
								'danger' => 'Danger',
								'warning' => 'Warning',
								'info' => 'Info',
								'light' => 'Light',
								'dark' => 'Dark',
								'blank' => 'No Styling',
							),
							'default_value' => 'primary',
							'allow_null' => 0,
							'multiple' => 0,
							'ui' => 0,
							'return_format' => 'value',
							'ajax' => 0,
							'placeholder' => '',
						),
						array(
							'key' => 'field_607de38351a61',
							'label' => 'Button Size',
							'name' => 'button_size',
							'type' => 'select',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'choices' => array(
								'sm' => 'Small',
								'md' => 'Default',
								'lg' => 'Large',
							),
							'default_value' => false,
							'allow_null' => 0,
							'multiple' => 0,
							'ui' => 0,
							'return_format' => 'value',
							'ajax' => 0,
							'placeholder' => '',
						),
					),
				),
				array(
					'key' => 'field_607de3d951a63',
					'label' => 'Button Layout',
					'name' => 'button_layout',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '50',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'row' => 'Row',
						'column' => 'Column',
						'group' => 'Group',
					),
					'default_value' => 'row',
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
				array(
					'key' => 'field_607de79c35f0d',
					'label' => 'Button Alignment',
					'name' => 'button_alignment',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '50',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'start' => 'Left',
						'center' => 'Center',
						'end' => 'Right',
					),
					'default_value' => 'middle',
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/mind-button',
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

		//Block: Media and Image
acf_add_local_field_group(array(
	'key' => 'group_60745cc009296',
	'title' => 'Block: Media and Image',
	'fields' => array(
		array(
			'key' => 'field_60745cc61d382',
			'label' => 'Image and Content',
			'name' => 'image_and_content',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layout' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_60745d0d1d384',
					'label' => 'Image',
					'name' => 'image',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'array',
					'preview_size' => 'medium',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
						// array(
						// 	'key' => 'field_60745d1d1d385',
						// 	'label' => 'Content',
						// 	'name' => 'content',
						// 	'type' => 'wysiwyg',
						// 	'instructions' => '',
						// 	'required' => 0,
						// 	'conditional_logic' => 0,
						// 	'wrapper' => array(
						// 		'width' => '',
						// 		'class' => '',
						// 		'id' => '',
						// 	),
						// 	'default_value' => '',
						// 	'tabs' => 'all',
						// 	'toolbar' => 'full',
						// 	'media_upload' => 1,
						// 	'delay' => 0,
						// ),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/image-and-content',
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

		//ACF Block Fields: Map w/ Marker *
acf_add_local_field_group(array(
	'key' => 'group_5fad8bfb7b985',
	'title' => 'Block: Map w/ Marker',
	'fields' => array(
		array(
			'key' => 'field_5fad8c0313f53',
			'label' => 'Map w/ Marker',
			'name' => 'map_w_marker',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5faqwafd34rfad',
					'label' => 'Map w/ Marker',
					'name' => 'map_w_marker_locations',
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
					'min' => 1, 
					'max' => '',
					'layout' => 'block',
					'button_label' => 'Add Location',
					'sub_fields' => array(
						array(
							'key' => 'field_62iygauo8hp9ocv7d',
							'label' => 'Latitude',
							'name' => 'latitude',
							'type' => 'text',
							'instructions' => '',
							'required' => 1,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '33.3333333333%',
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
							'key' => 'field_6p0987oyhasd',
							'label' => 'Longitude',
							'name' => 'longitude',
							'type' => 'text',
							'instructions' => '',
							'required' => 1,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '33.3333333333%',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
					
					),
				),
			)
		)
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/map-w-marker',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'field',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

		//ACF Block Fields: Post List *
acf_add_local_field_group(array(
	'key' => 'group_5fe0ec87c4f81',
	'title' => 'Block: Post List Block',
	'fields' => array(
		array(
			'key' => 'field_5fe0ec8cc6a95',
			'label' => 'Post List Block',
			'name' => 'post_list_block',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layout' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_5fe0ecc7c6a98',
					'label' => 'Display Type',
					'name' => 'display_type',
					'type' => 'radio',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'gallery' => 'Gallery View',
						'list' => 'List View',
						'small' => 'Small List',
						'card' => 'Card View',
						'small_card' => 'Small Card View',
					),
					'allow_null' => 0,
					'other_choice' => 0,
					'default_value' => 'list',
					'layout' => 'horizontal',
					'return_format' => 'value',
					'save_other_choice' => 0,
				),
				array(
					'key' => 'field_5fe0ec9ac6a96',
					'label' => 'Categories',
					'name' => 'categories',
					'type' => 'taxonomy',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'taxonomy' => 'category',
					'field_type' => 'checkbox',
					'add_term' => 0,
					'save_terms' => 0,
					'load_terms' => 0,
					'return_format' => 'id',
					'multiple' => 0,
					'allow_null' => 0,
				),
				array(
					'key' => 'field_61a50fc393f4c',
					'label' => 'Post Types',
					'name' => 'post_type',
					'type' => 'checkbox',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => $all_post_types,
					'allow_custom' => 0,
					'default_value' => array(
					),
					'layout' => 'vertical',
					'toggle' => 0,
					'return_format' => 'value',
					'save_custom' => 0,
				),
				array(
					'key' => 'field_5fe0eca6c6a97',
					'label' => 'Posts to Show',
					'name' => 'posts_per_page',
					'type' => 'number',
					'instructions' => '',
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
					'min' => '',
					'max' => '',
					'step' => '',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/post-list-block',
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

		//ACF Block Fields: Accordion *
acf_add_local_field_group(array(
	'key' => 'group_5faae62cc8b8e',
	'title' => 'Block: Accordion',
	'fields' => array(
		array(
			'key' => 'field_6asd3jk0a2314ad77ae9dd',
			'label' => 'First Accordion Start Open',
			'name' => 'mapi_first_accordion_open',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 1,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5faae6330b120',
			'label' => 'Accordions',
			'name' => 'accordions',
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
			'layout' => 'block',
			'button_label' => 'Add Accordion Item',
			'sub_fields' => array(
				array(
					'key' => 'field_5faae6380b121',
					'label' => 'Accordion Header',
					'name' => 'accordion_header',
					'type' => 'text',
					'instructions' => '',
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
					'key' => 'field_5faae6400b122',
					'label' => 'Content',
					'name' => 'content',
					'type' => 'wysiwyg',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'tabs' => 'all',
					'toolbar' => 'full',
					'media_upload' => 1,
					'delay' => 0,
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/accordion-block',
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

		//ACF Block Fields: Slider Image
acf_add_local_field_group(array(
	'key' => 'group_5fa9944816d06',
	'title' => 'Block: Image Slider',
	'fields' => array(
		array(
			'key' => 'field_60a21341asdfb6f29',
			'label' => 'Slides Image Size',
			'name' => 'slide_image_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '25%',
				'class' => '',
				'id' => '',
			),
			'choices' => mapi_get_regisered_size_options(),
			'default_value' => false,
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_6vghjk0a2e977ae9dd',
			'label' => 'Show Arrows',
			'name' => 'mapi_slider_arrows',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '25%',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 1,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_60a2e1sf977ae9dd',
			'label' => 'Show Dots',
			'name' => 'mapi_slider_dots',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '25%',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_60980oyuoa2d',
			'label' => 'Autoplay',
			'name' => 'mapi_autoplay',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '25%',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5fa994503d2ac',
			'label' => 'Images',
			'name' => 'block_image_slides',
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
			'layout' => 'block',
			'button_label' => 'Add Image',
			'sub_fields' => array(
				array(
					'key' => 'field_5fa994553d2ad',
					'label' => 'Image',
					'name' => 'image',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'array',
					'preview_size' => 'medium',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
				array(
					'key' => 'field_5fa9945b3d2ae',
					'label' => 'Caption',
					'name' => 'caption',
					'type' => 'text',
					'instructions' => '',
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
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/image-slider',
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

		//ACF Block Fields: Image Grid *
acf_add_local_field_group(array(
	'key' => 'group_5fa9a845af0e5',
	'title' => 'Block: Image Grid',
	'fields' => array(
		array(
			'key' => 'field_6asd3jk1adyoupx123',
			'label' => 'Crop Grid Images to be Square?',
			'name' => 'crop_images',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5fa9a85064f7b',
			'label' => 'Images',
			'name' => 'block_image_grid',
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
			'layout' => 'block',
			'button_label' => 'Add Card',
			'sub_fields' => array(
				array(
					'key' => 'field_5fa9a85b64f7c',
					'label' => 'Image',
					'name' => 'image',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'array',
					'preview_size' => 'medium',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),

				array(
					'key' => 'field_5fa9a86464f7e',
					'label' => 'Description',
					'name' => 'desc',
					'type' => 'textarea',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'rows' => 3,
					'new_lines' => '',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/image-grid',
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

		//ACF Block Fields: Container *
acf_add_local_field_group(array(
	'key' => 'group_5faca1b7c808b',
	'title' => 'Block: Container',
	'fields' => array(
		array(
			'key' => 'field_5faca1bcebcb7',
			'label' => 'Container Options',
			'name' => 'container_options',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layout' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_5faca1daebcb8',
					'label' => 'Width',
					'name' => 'width',
					'type' => 'radio',
					'instructions' => 'This setting specifies the width on desktop devices, mobile devices will always be full width. Note: Odd numbers are used to ensure that the content is centered, based on Twitter Bootstrap',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						2 => '2 Columns',
						4 => '4 Columns',
						6 => '6 Columns',
						8 => '8 Columns',
						10 => '10 Columns',
						12 => '12 Columns (default)',
					),
					'allow_null' => 0,
					'other_choice' => 0,
					'default_value' => 12,
					'layout' => 'vertical',
					'return_format' => 'value',
					'save_other_choice' => 0,
				),
				array(
					'key' => 'field_5faca3f4d2f06',
					'label' => 'Background Color',
					'name' => 'background_color',
					'type' => 'color_picker',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/container',
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

		//ACF Block Fields: Notice Block
acf_add_local_field_group(array(
	'key' => 'group_6123f24c91198',
	'title' => 'Block: Notice Block',
	'fields' => array(
		array(
			'key' => 'field_6123f25990ccf',
			'label' => 'Notice Block',
			'name' => 'mind_notice_block',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layout' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_6123f25e90cd0',
					'label' => 'Notice Type',
					'name' => 'notice_type',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'primary' => 'Primary',
						'secondary' => 'Secondary',
						'success' => 'Success',
						'info' => 'Info',
						'warning' => 'Warning',
						'danger' => 'Danger',
						'light' => 'Light',
						'dark' => 'Dark',
					),
					'default_value' => 'warning',
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
				array(
					'key' => 'field_6123f2e58a2b0',
					'label' => 'Notice Content',
					'name' => 'notice_content',
					'type' => 'wysiwyg',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'tabs' => 'all',
					'toolbar' => 'full',
					'media_upload' => 1,
					'delay' => 0,
				),
				array(
					'key' => 'field_6123f3038a2b1',
					'label' => 'Notice Icon',
					'name' => 'notice_icon',
					'type' => 'text',
					'instructions' => 'fontawesome.com/icons EX: fas fa-check-circle',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => 'fas fa-check-circle',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/mind-notice-block',
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


		//ACF Block Fields: Logo Slider
acf_add_local_field_group(array(
	'key' => 'group_625994542e350',
	'title' => 'Block: Logo Slider',
	'fields' => array(
		array(
			'key' => 'field_6259945849979',
			'label' => 'Logo Slides',
			'name' => 'mind_logo_slides',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layout' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_625994614997a',
					'label' => 'Images',
					'name' => 'images',
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
					'min' => 1,
					'max' => 35,
					'layout' => 'row',
					'button_label' => 'Add Logo',
					'sub_fields' => array(
						array(
							'key' => 'field_625994664997b',
							'label' => 'Image',
							'name' => 'image',
							'type' => 'image',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'array',
							'preview_size' => 'medium',
							'library' => 'all',
							'min_width' => '',
							'min_height' => '',
							'min_size' => '',
							'max_width' => '',
							'max_height' => '',
							'max_size' => '',
							'mime_types' => '',
						),
						array(
							'key' => 'field_6259946a4997c',
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
						array(
							'key' => 'field_6259946f4997d',
							'label' => 'Caption',
							'name' => 'caption',
							'type' => 'text',
							'instructions' => '',
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
					),
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/mind-logo-slider',
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
	'show_in_rest' => 0,
));



		//ACF Block Fields: Card Repeater Block
acf_add_local_field_group(array(
	'key' => 'group_601235336f5c3',
	'title' => 'Block: Card Repeater',
	'fields' => array(
		array(
			'key' => 'field_6012353a4f7d9',
			'label' => 'Block Card Repeater',
			'name' => 'block_card_repeater',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layout' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_612fafbads126dcc9',
					'label' => 'Number of Columns',
					'name' => 'num_columns',
					'type' => 'radio',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'one' => 'One Column',
						'twelve' => 'Twelve Columns',
						'six' => 'Six Columns',
						'four' => 'Four Columns',
						'three' => 'Three Columns',
						'two' => 'Two Columns',
					),
					'allow_null' => 0,
					'other_choice' => 0,
					'default_value' => 'three',
					'layout' => 'horizontal',
					'return_format' => 'value',
					'save_other_choice' => 0,
				),
				array(
					'key' => 'field_601235414f7da',
					'label' => 'Cards',
					'name' => 'cards',
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
					'layout' => 'block',
					'button_label' => 'Add Card',
					'sub_fields' => array(
						array(
							'key' => 'field_601235464f7db',
							'label' => 'Card Image',
							'name' => 'card_image',
							'type' => 'image',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'array',
							'preview_size' => 'medium',
							'library' => 'all',
							'min_width' => '',
							'min_height' => '',
							'min_size' => '',
							'max_width' => '',
							'max_height' => '',
							'max_size' => '',
							'mime_types' => '',
						),
						array(
							'key' => 'field_6012356sfqf7dc',
							'label' => 'Card Header',
							'name' => 'card_header',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'maxlength' => '',
							'rows' => '',
							'new_lines' => '',
						),
						array(
							'key' => 'field_6012354b4f7dc',
							'label' => 'Card Body',
							'name' => 'card_body',
							'type' => 'textarea',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'maxlength' => '',
							'rows' => '',
							'new_lines' => '',
						),
						array(
							'key' => 'field_601235524f7dd',
							'label' => 'Card Link',
							'name' => 'card_link',
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
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/card-repeater-block',
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
}, 1);



endif;
