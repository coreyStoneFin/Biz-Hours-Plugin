<?php
if ( ! defined( "SFSLTable" ) ) {
	include_once "includes/Constants.php";
}


class wp_locations_list_table extends WP_List_Table {
	/**
	 * Constructor, we override the parent to pass our own arguments
	 * We usually focus on three parameters: singular and plural labels, as well as whether the class supports AJAX.
	 */
	function __construct( $args = array() ) {
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
	function get_columns() {
		return $columns = array(
			'col_id'       => __( 'ID' ),
			'col_name'     => __( 'Name' ),
			'col_address1' => __( 'Address1' ),
			'col_address2' => __( 'Address2' ),
			'col_city'     => __( 'City' ),
			'col_province' => __( 'State' ),
			'col_country'  => __( 'Country' ),
			'col_postal'   => __( 'Postal Code' ),
			'col_geometry' => __( 'Geometry' )
		);
	}

	/**
	 * Decide which columns to activate the sorting functionality on
	 * @return array $sortable, the array of columns that can be sorted by the user
	 */
	public function get_sortable_columns() {
		return $sortable = array(
			'col_id'       => 'id',
			'col_name'     => 'name',
			'col_city'     => 'city',
			'col_province' => 'province'
		);
	}

	/**
	 * Prepare the table with different parameters, pagination, columns and table elements
	 */
	function prepare_items() {
		global $wpdb, $_wp_column_headers;
		$screen = get_current_screen();

		/* -- Preparing your query -- */
		$query = "SELECT * FROM " . $wpdb->prefix . SFSLTable;

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
		$columns                           = $this->get_columns();
		$_wp_column_headers[ $screen->id ] = $columns;

		/* -- Fetch the items -- */
		$this->items = $wpdb->get_results( $query );
	}

	/**
	 * Display the rows of records in the table
	 * @return string, echo the markup of the rows
	 */
	function display_rows() {

		//Get the records registered in the prepare_items method
		$records = $this->items;

		//Get the columns registered in the get_columns and get_sortable_columns methods
		list( $columns, $hidden ) = $this->get_column_info();

		//Loop for each record
		if ( ! empty( $records ) ) {
			foreach ( $records as $rec ) {

				//Open the line
				echo '< tr id="record_' . $rec->link_id . '">';
				foreach ( $columns as $column_name => $column_display_name ) {

					//Style attributes for each col
					$class = "class='$column_name column-$column_name'";
					$style = "";
					if ( in_array( $column_name, $hidden ) ) {
						$style = ' style="display:none;"';
					}
					$attributes = $class . $style;

					//edit link
					$editlink = '/wp-admin/link.php?action=edit&link_id=' . (int) $rec->link_id;

					//Display the cell
					switch ( $column_name ) {
						case "col_id":
							echo '< td ' . $attributes . '>' . stripslashes( $rec->id ) . '< /td>';
							break;
						case "col_name":
							echo '< td ' . $attributes . '>' . stripslashes( $rec->name ) . '7< /td>';
							break;
						case "col_address1":
							echo '< td ' . $attributes . '>' . stripslashes( $rec->address1 ) . '< /td>';
							break;
						case "col_address2":
							echo '< td ' . $attributes . '>' . stripslashes( $rec->address2 ) . '< /td>';
							break;
						case "col_city":
							echo '< td ' . $attributes . '>' . stripslashes( $rec->city ) . '< /td>';
							break;
						case "col_province":
							echo '< td ' . $attributes . '>' . stripslashes( $rec->province ) . '< /td>';
							break;
						case "col_country":
							echo '< td ' . $attributes . '>' . stripslashes( $rec->country ) . '< /td>';
							break;
						case "col_postal":
							echo '< td ' . $attributes . '>' . stripslashes( $rec->postal ) . '< /td>';
							break;
						case "col_geometry":
							echo '< td ' . $attributes . '>' . stripslashes( $rec->geometry ) . '< /td>';
							break;
					}
				}

				//Close the line
				echo '< /tr>';
			}
		}
	}
}