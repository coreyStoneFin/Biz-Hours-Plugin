<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

//Our class extends the WP_List_Table class, so we need to make sure that it's there
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
//Our class extends the WP_List_Table class, so we need to make sure that it's there
if ( ! class_exists( 'GooglePlace' ) ) {
	require_once( 'includes/GooglePlace.php' );
	require_once( 'includes/GooglePlacesAPI.php' );
}

if ( ! defined( "SFSLTable" ) ) {
	include_once "includes/Constants.php";
}

class wp_locations_list_table extends WP_List_Table {
	/**
	 * Constructor, we override the parent to pass our own arguments
	 * We usually focus on three parameters: singular and plural labels, as well as whether the class supports AJAX.
	 */
	public function __construct( $args = array() ) {
		parent::__construct( array(
			'singular' => 'wp_location', //Singular label
			'plural'   => 'wp_locations', //plural label, also this well be one of the table css class
			'ajax'     => false, //We won't support Ajax for this table,
			'screen'   => isset( $args['screen'] ) ? $args['screen'] : null,
		) );
	}

	/**
	 * Define the columns that are going to be used in the table
	 * @return array $columns, the array of columns to use with the table
	 */
	public function get_columns() {
		$columns = array(
			'id'       => __( 'ID' ),
			'name'     => __( 'Name' ),
			'address1' => __( 'Address1' ),
			'address2' => __( 'Address2' ),
			'city'     => __( 'City' ),
			'province' => __( 'State' ),
			'country'  => __( 'Country' ),
			'postal'   => __( 'Postal Code' ),
			'geometry' => __( 'Geometry' )
		);

		return $columns;
	}

	/**
	 * Decide which columns to activate the sorting functionality on
	 * @return array $sortable, the array of columns that can be sorted by the user
	 */
	public function get_sortable_columns() {
		$sortable = array(
			'id'       => 'id',
			'name'     => 'name',
			'city'     => 'city',
			'province' => 'province'
		);

		return $sortable;
	}

	/**
	 * Get a list of all, hidden and sortable columns, with filter applied
	 *
	 * @return array
	 */
	public function get_column_info() {
		if ( ! isset( $this->_column_headers ) ) {
			$columns = get_columns();
			$hidden = get_hidden_columns( $this->screen );

			$sortable_columns = $this->get_sortable_columns();
			/**
			 * Filters the list table sortable columns for a specific screen.
			 *
			 * The dynamic portion of the hook name, `$this->screen->id`, refers
			 * to the ID of the current screen, usually a string.
			 *
			 * @since 3.5.0
			 *
			 * @param array $sortable_columns An array of sortable columns.
			 */
			$_sortable = apply_filters( "manage_{$this->screen->id}_sortable_columns", $sortable_columns );

			$sortable = array();
			foreach ( $_sortable as $id => $data ) {
				if ( empty( $data ) )
					continue;

				$data = (array) $data;
				if ( !isset( $data[1] ) )
					$data[1] = false;

				$sortable[$id] = $data;
			}

			$primary = $this->get_primary_column_name();
			$this->_column_headers = array( $columns, $hidden, $sortable, $primary );
		}

		return $this->_column_headers;
	}
	/**
	 * Prepare the table with different parameters, pagination, columns and table elements
	 */
	public function prepare_items() {
		global $wpdb;
	//	$screen = get_current_screen();

		/* -- Preparing your query -- */
		$query = "SELECT  id, place_id,  alt_ids,  name,  geometry,  address1,  address2,  city,  province,  country,  postal FROM " . $wpdb->prefix . SFSLTable;

		/* -- Ordering parameters -- */
		//Parameters that are going to be used to order the result
		$orderby = ! empty( $_GET["orderby"] ) ? $wpdb->_escape( $_GET["orderby"] ) : 'ASC';
		$order   = ! empty( $_GET["order"] ) ? $wpdb->_escape( ( $_GET["order"] ) ) : '';
		if ( ! empty( $orderby ) & ! empty( $order ) ) {
			$query .= ' ORDER BY ' . $orderby . ' ' . $order;
		}

		/* -- Pagination parameters -- */
		//Number of elements in your table?
		$totalitems = $wpdb->query( $query ); //return the total number of affected rows

		//How many to display per page?
		$perpage = 10;

		//Which page is this?
		$paged = ! empty( $_GET["paged"] ) ? $wpdb->_escape( ( $_GET["paged"] ) ) : '';

		//Page Number
		if ( empty( $paged ) || ! is_numeric( $paged ) || $paged <= 0 ) {
			$paged = 1;
		}

		//How many pages do we have in total?
		$totalpages = ceil( $totalitems / $perpage );

		//adjust the query to take pagination into account
		if ( ! empty( $paged ) && ! empty( $perpage ) ) {
			$offset = ( $paged - 1 ) * $perpage;
			$query  .= ' LIMIT ' . (int) $offset . ',' . (int) $perpage;
		}
		/* -- Register the pagination -- */
		$this->set_pagination_args( array(
			"total_items" => $totalitems,
			"total_pages" => $totalpages,
			"per_page"    => $perpage,
		) );
		//The pagination links are automatically built according to those parameters

		/* -- Register the Columns -- */
	//	 $columns                           = $this->get_columns();
	//	 $_wp_column_headers[ $screen->id ] = $columns;

		/* -- Fetch the items -- */
		$this->items = $wpdb->get_results( $query );
	}

	public function no_items() {
		_e( 'No Locations found.' );
	}

	/**
	 * Display the rows of records in the table
	 * @return string, echo the markup of the rows
	 */
	public function display_rows() {

		//Get the records registered in the prepare_items method
		$records = $this->items;

		// list( $columns, $hidden ) = $this->get_column_info();

		//Loop for each record
		if ( ! empty( $records ) ) {
			foreach ( $records as $recId => $rec ) {
				echo PHP_EOL . "\t" . $this->single_row( $rec );

			}
		}
	}

	protected function get_default_primary_column_name() {
		return 'id';
	}

	public function single_row( $location_object, $style = '', $role = '', $numposts = 0 ) {
		if ( ! ( $location_object instanceof GooglePlace ) ) {
			$location_object = $this->get_location( $location_object );
		}

		//Open the line
		$r = "<tr id='user-$location_object->id'>";

		//Get the columns registered in the get_columns and get_sortable_columns methods
		list( $columns, $hidden, $sortable, $primary ) = $this->get_column_info();

		foreach ( $columns as $column_name => $column_display_name ) {
			$classes = "$column_name column-$column_name";
			if ( $primary === $column_name ) {
				$classes .= ' has-row-actions column-primary';
			}
			if ( 'posts' === $column_name ) {
				$classes .= ' num'; // Special case for that column
			}

			if ( in_array( $column_name, $hidden ) ) {
				$classes .= ' hidden';
			}

			$data = 'data-colname="' . wp_strip_all_tags( $column_display_name ) . '"';

			$attributes = "class='$classes' $data";

			if ( 'cb' === $column_name ) {
				$r .= "<th scope='row' class='check-column'>$checkbox</th>";
			} else {
				$r .= "<td $attributes>";
				switch ( $column_name ) {
					case 'username':
						$r .= "$avatar $edit";
						break;
					case 'name':
						$r .= "$user_object->first_name $user_object->last_name";
						break;
					case 'email':
						$r .= "<a href='" . esc_url( "mailto:$email" ) . "'>$email</a>";
						break;
					case 'role':
						$r .= esc_html( $roles_list );
						break;
					case 'posts':
						if ( $numposts > 0 ) {
							$r .= "<a href='edit.php?author=$user_object->ID' class='edit'>";
							$r .= '<span aria-hidden="true">' . $numposts . '</span>';
							$r .= '<span class="screen-reader-text">' . sprintf( _n( '%s post by this author', '%s posts by this author', $numposts ), number_format_i18n( $numposts ) ) . '</span>';
							$r .= '</a>';
						} else {
							$r .= 0;
						}
						break;
					default:
						/**
						 * Filters the display output of custom columns in the Users list table.
						 *
						 * @since 2.8.0
						 *
						 * @param string $output Custom column output. Default empty.
						 * @param string $column_name Column name.
						 * @param int $user_id ID of the currently-listed user.
						 */
						$r .= apply_filters( 'manage_users_custom_column', '', $column_name, $user_object->ID );
				}

				if ( $primary === $column_name ) {
					//	$r .= $this->row_actions( $actions );
				}
				$r .= "</td>";
			}
		}
		$r .= '</tr>';

		return $r;
	}

	protected function get_location( $object ) {
		if ( $object instanceof GooglePlace ) {
			return $object;
		}

		// $query = "SELECT  id, place_id,  alt_ids,  name,  geometry,  address1,  address2,  city,  province,  country,  postal" . $wpdb->prefix . SFSLTable;
		$gp = new GooglePlace();
		if ( is_array( $object ) ) {
			if ( array_key_exists( 'id', $object ) ) {
				$gp->id       = $object["id"];
				$gp->place_id = $object["place_id"];
				$gp->alt_ids  = $object["alt_ids"];
				$gp->name     = $object["name"];
				$gp->geometry = $object["geometry"];
				$gp->address1 = $object["address1"];
				$gp->address2 = $object["address2"];
				$gp->city     = $object["city"];
				$gp->province = $object["province"];
				$gp->country  = $object["country"];
				$gp->postal   = $object["postal"];
			} else {
				$gp->id       = $object[0];
				$gp->place_id = $object[1];
				$gp->alt_ids  = $object[2];
				$gp->name     = $object[2];
				$gp->geometry = $object[3];
				$gp->address1 = $object[4];
				$gp->address2 = $object[5];
				$gp->city     = $object[6];
				$gp->province = $object[7];
				$gp->country  = $object[8];
				$gp->postal   = $object[9];
			}
		}
		if ( is_object( $object ) ) {
			$gp->id       = $object->id;
			$gp->place_id = $object->place_id;
			$gp->alt_ids  = $object->alt_ids;
			$gp->name     = $object->name;
			$gp->geometry = $object->geometry;
			$gp->address1 = $object->address1;
			$gp->address2 = $object->address2;
			$gp->city     = $object->city;
			$gp->province = $object->province;
			$gp->country  = $object->country;
			$gp->postal   = $object->postal;
		}

		return $gp;
	}

	protected function get_bulk_actions() {
		$actions = array();

		if ( is_multisite() ) {
			if ( current_user_can( 'remove_users' ) ) {
				$actions['remove'] = __( 'Remove' );
			}
		} else {
			if ( current_user_can( 'delete_users' ) ) {
				$actions['delete'] = __( 'Delete' );
			}
		}

		return $actions;
	}
}