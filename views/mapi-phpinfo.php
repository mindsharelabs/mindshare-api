<?php
require_once('../../../../wp-blog-header.php');
if(current_user_can('manage_options')) {
	phpinfo();
}
