<?php

class Task_List_Table extends FJN_List_Table{
	function __construct(){
		parent::__construct( array(
			'singular'=> 'wp_list_text_link', //Singular label
			'plural' => 'wp_list_test_links', //plural label
			'ajax'   => false
		) );
	}

	function extra_tablenav( $which ) {
		if ( $which == "top" ){
		}
		if ( $which == "bottom" ){
		}
	}

	function get_fields() {
		return $fields= array(
			'col_task_id' => 'task_id',
			'col_activity_title' => 'activity_title',
			'col_project_title' => 'project_title',
			'col_assign_date' => 'assign_date',
			'col_seen_date' => 'seen_date',
			'col_start_date' => 'start_date',
			'col_done_date' => 'done_date'
		);
	}
	
	function get_columns() {
		return $columns= array(
			'col_task_id' => __('Task ID', 'fenjoon' ),
			'col_activity_title' => __('Activity title', 'fenjoon' ),
			'col_project_title' => __('Project title', 'fenjoon' ),
			'col_assign_date' => __('Assigned', 'fenjoon' ),
			'col_seen_date' => __('Seen', 'fenjoon' ),
			'col_start_date' => __('Started', 'fenjoon' ),
			'col_done_date' => __('Done', 'fenjoon' )
		);
	}
	
	public function get_hidden_columns(){
		return $hidden = array(
			
		);
	}
	
	public function get_sortable_columns(){
		return $sortable = array(
		//	'col_task_id'=>'task_id'
		);
	}

	function prepare_items(){
		global $wpdb, $_wp_column_headers;
		$perpage = 10;
		$activities = array( 'sitetypes', 'modules', 'features', 'attributes', 'standards' );
		$current_user = wp_get_current_user();
		$tasks_table = $wpdb->prefix.'tasks';
		$posts_table = $wpdb->posts;
		$query = 
			"SELECT t.task_id, p2.post_title activity_title, t.project_id, p.post_title project_title, t.activity_id activity_id, t.assign_date , t.seen_date, t.start_date, t.done_date
			FROM {$tasks_table} t 
				inner join {$posts_table} p on t.project_id = p.ID
				inner join {$posts_table} p2 on t.activity_id = p2.ID
			WHERE t.editor_id = {$current_user->id} AND t.project_id = p.ID AND t.activity_id = p2.ID";
		if( filter_var( $_GET["orderby"], FILTER_SANITIZE_STRING ) ){
			$orderby = filter_var( $_GET["orderby"], FILTER_SANITIZE_STRING );
			$query = $wpdb->prepare( $query ." ORDER BY %s" , $orderby );
			if( filter_var( $_GET["order"], FILTER_SANITIZE_STRING ) ){
				$order = filter_var( $_GET["order"], FILTER_SANITIZE_STRING );
				$query = $wpdb->prepare( $query ." ORDER %s" , $order );
			}
		}
		$totalitems = $wpdb->query( $query ); //return the total number of affected rows
		$paged = !empty( $_GET["paged"] ) ? filter_var( $_GET["paged"], FILTER_SANITIZE_NUMBER_INT ) : '';
		if( empty( $paged ) || !is_numeric( $paged ) || $paged <= 0 ) $paged=1;
		$totalpages = ceil( $totalitems / $perpage );
		if( !empty( $paged ) && !empty( $perpage ) ){
			$offset = ( $paged - 1 ) * $perpage;
			$query = $wpdb->prepare( $query . " LIMIT %d , %d", (int)$offset, (int)$perpage );
		}
		$this->set_pagination_args( array(
			"total_items" => $totalitems,
			"total_pages" => $totalpages,
			"per_page" => $perpage,
		)	);
		$columns = $this->get_columns();
		$hidden = $this->get_hidden_columns();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array( $columns, $hidden, $sortable );
		$this->items = $wpdb->get_results( $query );
	}

	function column_default( $item, $column_name ){
		$fields = $this->get_fields();
		echo $item->$fields[$column_name];
	}
}


?>