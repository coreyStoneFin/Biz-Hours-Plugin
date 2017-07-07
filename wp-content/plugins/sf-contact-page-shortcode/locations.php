<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! current_user_can( 'list_users' ) ) {
	wp_die(
		'<h1>' . __( 'Cheatin&#8217; uh?' ) . '</h1>' .
		'<p>' . __( 'Sorry, you are not allowed to list users.' ) . '</p>',
		403
	);
}

require_once "class-locations-list-table.php";

$wp_list_table = new wp_locations_list_table();
$pagenum       = $wp_list_table->get_pagenum();
$title         = __( 'Locations' );
// $parent_file = 'users.php';

add_screen_option( 'per_page' );

// contextual help - choose Help on the top right of admin panel to preview this.
get_current_screen()->add_help_tab( array(
	'id'      => 'overview',
	'title'   => __( 'Overview' ),
	'content' => '<p>' . __( 'This screen lists all the existing users for your site. Each user has one of five defined roles as set by the site admin: Site Administrator, Editor, Author, Contributor, or Subscriber. Users with roles other than Administrator will see fewer options in the dashboard navigation when they are logged in, based on their role.' ) . '</p>' .
	             '<p>' . __( 'To add a new user for your site, click the Add New button at the top of the screen or Add New in the Users menu section.' ) . '</p>'
) );

get_current_screen()->add_help_tab( array(
	'id'      => 'screen-display',
	'title'   => __( 'Screen Display' ),
	'content' => '<p>' . __( 'You can customize the display of this screen in a number of ways:' ) . '</p>' .
	             '<ul>' .
	             '<li>' . __( 'You can hide/display columns based on your needs and decide how many users to list per screen using the Screen Options tab.' ) . '</li>' .
	             '<li>' . __( 'You can filter the list of users by User Role using the text links above the users list to show All, Administrator, Editor, Author, Contributor, or Subscriber. The default view is to show all users. Unused User Roles are not listed.' ) . '</li>' .
	             '<li>' . __( 'You can view all posts made by a user by clicking on the number under the Posts column.' ) . '</li>' .
	             '</ul>'
) );

$help = '<p>' . __( 'Hovering over a row in the users list will display action links that allow you to manage users. You can perform the following actions:' ) . '</p>' .
        '<ul>' .
        '<li>' . __( 'Edit takes you to the editable profile screen for that user. You can also reach that screen by clicking on the username.' ) . '</li>';

if ( is_multisite() ) {
	$help .= '<li>' . __( 'Remove allows you to remove a user from your site. It does not delete their content. You can also remove multiple users at once by using Bulk Actions.' ) . '</li>';
} else {
	$help .= '<li>' . __( 'Delete brings you to the Delete Users screen for confirmation, where you can permanently remove a user from your site and delete their content. You can also delete multiple users at once by using Bulk Actions.' ) . '</li>';
}
$help .= '</ul>';

get_current_screen()->add_help_tab( array(
	'id'      => 'actions',
	'title'   => __( 'Actions' ),
	'content' => $help,
) );
unset( $help );

get_current_screen()->set_help_sidebar(
	'<p><strong>' . __( 'For more information:' ) . '</strong></p>' .
	'<p>' . __( '<a href="https://codex.wordpress.org/Users_Screen">Documentation on Managing Users</a>' ) . '</p>' .
	'<p>' . __( '<a href="https://codex.wordpress.org/Roles_and_Capabilities">Descriptions of Roles and Capabilities</a>' ) . '</p>' .
	'<p>' . __( '<a href="https://wordpress.org/support/">Support Forums</a>' ) . '</p>'
);

get_current_screen()->set_screen_reader_content( array(
	'heading_views'      => __( 'Filter users list' ),
	'heading_pagination' => __( 'Users list navigation' ),
	'heading_list'       => __( 'Users list' ),
) );

if ( empty( $_REQUEST ) ) {
	$referer = '<input type="hidden" name="wp_http_referer" value="' . esc_attr( wp_unslash( $_SERVER['REQUEST_URI'] ) ) . '" />';
} elseif ( isset( $_REQUEST['wp_http_referer'] ) ) {
	$redirect = remove_query_arg( array(
		'wp_http_referer',
		'updated',
		'delete_count'
	), wp_unslash( $_REQUEST['wp_http_referer'] ) );
	$referer  = '<input type="hidden" name="wp_http_referer" value="' . esc_attr( $redirect ) . '" />';
} else {
	$redirect = 'users.php';
	$referer  = '';
}

$update = '';

switch ( $wp_list_table->current_action() ) {

	/* Bulk Dropdown menu Role changes */
	case 'promote':
		check_admin_referer( 'bulk-users' );

		if ( ! current_user_can( 'promote_users' ) ) {
			wp_die( __( 'Sorry, you are not allowed to edit this user.' ) );
		}
		exit();

	case 'dodelete':
		if ( is_multisite() ) {
			wp_die( __( 'User deletion is not allowed from this screen.' ) );
		}
		check_admin_referer( 'delete-users' );

		if ( empty( $_REQUEST['users'] ) ) {
			wp_redirect( $redirect );
			exit();
		}
		exit();

	case 'delete':
		if ( is_multisite() ) {
			wp_die( __( 'User deletion is not allowed from this screen.' ) );
		}

		check_admin_referer( 'bulk-users' );

		if ( empty( $_REQUEST['users'] ) && empty( $_REQUEST['user'] ) ) {
			wp_redirect( $redirect );
			exit();
		}

		break;

	case 'doremove':
		check_admin_referer( 'remove-users' );

		if ( ! is_multisite() ) {
			wp_die( __( 'You can&#8217;t remove users.' ) );
		}

		if ( empty( $_REQUEST['users'] ) ) {
			wp_redirect( $redirect );
			exit;
		}

	case 'remove':

		check_admin_referer( 'bulk-users' );

		if ( ! is_multisite() ) {
			wp_die( __( 'You can&#8217;t remove users.' ) );
		}

		if ( empty( $_REQUEST['users'] ) && empty( $_REQUEST['user'] ) ) {
			wp_redirect( $redirect );
			exit();
		}
		break;

	default:

		if ( ! empty( $_GET['_wp_http_referer'] ) ) {
			wp_redirect( remove_query_arg( array(
				'_wp_http_referer',
				'_wpnonce'
			), wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
			exit;
		}
		break;

} // end of the $doaction switch

include_once( ABSPATH . 'wp-admin/admin-footer.php' );
