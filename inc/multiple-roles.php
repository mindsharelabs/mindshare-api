<?php
/*
	Copyright 2013 Nikola Nikolov (email: nikolov.tmw@gmail.com)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function mind_plugin_init() {
	load_plugin_textdomain( 'multiple-roles-per-user', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'mind_plugin_init' );

function mind_admin_enqueue_scripts( $handle ) {
	if ( 'user-edit.php' == $handle ) {
		// We need jQuery to move things around :)
		wp_enqueue_script( 'jquery' );
	}
}
add_action( 'admin_enqueue_scripts', 'mind_admin_enqueue_scripts', 10 );

/**
 * Adds the GUI for selecting multiple roles per user
 */
function mind_add_multiple_roles_ui( $user ) {
	// Not allowed to edit user - bail
	if ( ! current_user_can( 'edit_user', $user->ID ) ) {
		return;
	}
	$roles = get_editable_roles();
	$user_roles = array_intersect( array_values( $user->roles ), array_keys( $roles ) ); ?>
	<div class="mrpu-roles-container">
		<h3><?php _e( 'User Roles', 'multiple-roles-per-user' ); ?></h3>
		<table class="form-table">
			<tr>
				<th><label for="user_credits"><?php _e( 'Roles', 'multiple-roles-per-user' ); ?></label></th>
				<td>
					<?php foreach ( $roles as $role_id => $role_data ) : ?>
						<label for="user_role_<?php echo esc_attr( $role_id ); ?>">
							<input type="checkbox" id="user_role_<?php echo esc_attr( $role_id ); ?>" value="<?php echo esc_attr( $role_id ); ?>" name="mind_user_roles[]"<?php echo in_array( $role_id, $user_roles ) ? ' checked="checked"' : ''; ?> />
							<?php echo $role_data['name']; ?>
						</label>
						<br />
					<?php endforeach; ?>
					<br />
					<span class="description"><?php _e( 'Select one or more roles for this user.', 'multiple-roles-per-user' ); ?></span>
					<?php wp_nonce_field( 'mind_set_roles', '_mind_roles_nonce' ); ?>
				</td>
			</tr>
		</table>
	</div>
	<?php
	// Do some hacking around to hide the built-in user roles selector
	// First hide it with CSS and then get rid of it with jQuery ?>
	<style>
		label[for="role"],
		select#role {
			display: none;
		}
	</style>
	<script type="text/javascript">
		(function($){
			$(document).ready(function(){
				var row = $('select#role').closest('tr');
				var clone = row.clone();
				// clone.insertAfter( $('select#role').closest('tr') );
				row.html( $('.mrpu-roles-container tr').html() );
				$('.mrpu-roles-container').remove();
			})
		})(jQuery)
	</script>
<?php }
add_action( 'edit_user_profile', 'mind_add_multiple_roles_ui', 0 );

/**
 * Saves the selected roles for the user
 */
function mind_save_multiple_user_roles( $user_id ) {
	// Not allowed to edit user - bail
	if ( ! current_user_can( 'edit_user', $user_id ) || ! wp_verify_nonce( $_POST['_mind_roles_nonce'], 'mind_set_roles' ) ) {
		return;
	}

	$user = new WP_User( $user_id );
	$roles = get_editable_roles();
	$new_roles = isset( $_POST['mind_user_roles'] ) ? (array) $_POST['mind_user_roles'] : array();
	// Get rid of any bogus roles
	$new_roles = array_intersect( $new_roles, array_keys( $roles ) );
	$roles_to_remove = array();
	$user_roles = array_intersect( array_values( $user->roles ), array_keys( $roles ) );
	if ( ! $new_roles ) {
		// If there are no roles, delete all of the user's roles
		$roles_to_remove = $user_roles;
	} else {
		$roles_to_remove = array_diff( $user_roles, $new_roles );
	}

	foreach ( $roles_to_remove as $_role ) {
		$user->remove_role( $_role );
	}

	if ( $new_roles ) {
		// Make sure that we don't call $user->add_role() any more than it's necessary
		$_new_roles = array_diff( $new_roles, array_intersect( array_values( $user->roles ), array_keys( $roles ) ) );
		foreach ( $_new_roles as $_role ) {
			$user->add_role( $_role );
		}
	}
}
add_action( 'edit_user_profile_update', 'mind_save_multiple_user_roles' );

/**
 * Gets rid of the "Role" column and adds-in the "Roles" column
 */
function mind_add_roles_column( $columns ) {
	$old_posts = isset( $columns['posts'] ) ? $columns['posts'] : false;
	unset( $columns['role'], $columns['posts'] );
	$columns['mind_roles'] = __( 'Roles', 'multiple-roles-per-user' );
	if ( $old_posts ) {
		$columns['posts'] = $old_posts;
	}

	return $columns;
}
add_filter( 'manage_users_columns', 'mind_add_roles_column' );

/**
 * Displays the roles for a user
 */
function mind_display_user_roles( $value, $column_name, $user_id ) {
	static $roles;
	if ( ! isset( $roles ) ) {
		$roles = get_editable_roles();
	}
	if ( 'mind_roles' == $column_name ) {
		$user = new WP_User( $user_id );
		$user_roles = array();
		$_user_roles = array_intersect( array_values( $user->roles ), array_keys( $roles ) );
		foreach ( $_user_roles as $role_id ) {
			$user_roles[] = $roles[ $role_id ]['name'];
		}

		return implode( ', ', $user_roles );
	}

	return $value;
}
add_filter( 'manage_users_custom_column', 'mind_display_user_roles', 10, 3 );
