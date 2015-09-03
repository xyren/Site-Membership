<?php
	
if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class horse_racing_race_list_Table extends WP_List_Table {
	
	var $_mode_view;
	var $_emp_tbl;
	var $_emr_tbl;
	var $_emc_tbl;
	var $_refer;
	var $_total_item;
	
    function __construct(){
        global $status, $page;
        
		//$this->_emp_tbl = 'employees';
		$this->_emp_tbl = HORSE_RACING_RACE_TABLE;
		$this->_emr_tbl = HORSE_RACING_TABLE;
		$this->_emc_tbl = HORSE_RACING_PRICE_TABLE;

        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'horse race',     //singular name of the listed records
            'plural'    => 'horse races',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
		$this->_mode_view = isset($_GET['mode']) ? $_GET['mode'] : 'excerpt';
    }
    
    function column_default($item, $column_name){
        switch($column_name){
            case 'ID':
				 return '<span id="td_'.$item->ID.'">'.$item->ID.'</span>';
            case 'horsebreed':
                return $item->$column_name;
			case 'race_title':
                return $item->$column_name;
			case 'race_result':
                return $item->$column_name;
			case 'date_added':
            default:
                return print_r($item,true); //Show the whole array for troubleshooting purposes
        }
    }
	function column_race_title($item){
	 global $wpdb;
		
		$actions = array(
            'edit'      => '<a href="?page=horse-race&action=edit&id='.$item->ID.'&eventID='.$item->horseevent_id.'&refer='.$this->_refer.'&viewby='.$_GET['page'].'">Edit</a>',
            'view_site'      => '<a href="javascript:alert(\'Not ready\')">View in site</a>',
            'delete'      => '<a href="#" item="'.$item->ID.'" class="trash delete-race">Delete</a>'
        );
		$ref_link = '?page='.$_GET['page'].'&id='.$item->ID.'&action=view&refer='.$this->_refer;
        return sprintf(
				'<strong>
				<a href="?page=horse-race&action=view&id='.$item->ID.'&eventID='.$item->horseevent_id.'&">
				%1$s </a>
				</strong> %2$s',
					$item->race_title,
					$this->row_actions($actions),
				$ref_link
        );
		//return $_out;
		
    }
	function column_horsebreed($item){
		if(empty($item->horsebreed)){
			return '---';
		}
		return $item->horsebreed;
    }
	function column_eventname($item){
		return '<a href="?page=horse-event&id='.$item->eventID.'&action=view&refer=admin.php?page=horse-race">'. $item->eventname .'</a>';
    }
	function column_totalprice($item){
		return '<a href="?page=horse-race&id='.$item->ID.'&eventID='.$item->horseevent_id.'&action=view&refer='.$this->_refer.'">'. $item->totalprice .'</a>';
    }
	
	function column_date_added($item){
		$event_date ='';
		$event_date = date("Y-M-d",strtotime($item->date_added));
		return $event_date;
    }
	function column_cb($item){
        return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
            'ID',
            $item->ID
        );
    } 
    
	function get_columns(){
		
		if(empty($this->_mode_view)){
			$this->_mode_view = 'excerpt';
		}
		
		if($this->_mode_view == 'excerpt'){
			$columns = array(
				'cb'        		=> '<input type="checkbox" />', //Render a checkbox instead of text
				'ID'     			=> 'ID',
				'race_title'  		=> 'Race Title',
				'eventname'  		=> 'Event',
				'totalprice'  		=> 'Wagers',
				'race_result'  		=> 'Results',
			);
			return $columns;
		} 
		$columns = array(
		   'cb'        			=> '<input type="checkbox" />', //Render a checkbox instead of text
			'ID'     			=> 'ID',
			'race_title'  		=> 'Race Title',
			'horsebreed'  		=> 'Horse Breed',
			'totalprice'  		=> 'Wagers',
			'eventname'  		=> 'Event',
			'race_result'  		=> 'Results',
			'date_added'  		=> 'Date Added',
		);
	
        return $columns;
    }
    function get_sortable_columns() {
        $sortable_columns = array(
            'ID'     			=> array('ID',true),     //true means its already sorted
			'race_title'  		=> array('race_title',false), 
			'horsebreed'  		=> array('horsebreed',false), 
			'totalprice'  		=> array('totalprice',false), 
			'eventname'  		=> array('eventname',false), 
			'race_result'  		=> array('race_result',false), 
			'date_added'  		=> array('date_added',false), 
        );
        return $sortable_columns;
    }
    function get_hidden_columns(){
		$columns = (array) get_user_option( 'managehorse-racing_page_horse-racecolumnshidden');
        return $columns;
    } 
  /*   function get_bulk_actions() {
        $actions = array(
            'delete'    => 'Delete'
        );
        return $actions;
    }   
    function process_bulk_action() {
        
        //Detect when a bulk action is being triggered...
        if( 'delete'===$this->current_action() ) {
            wp_die('Items deleted (or they would be if we had items to delete)!');
        }
        
    }
     */
    function get_horseevents($def_sql=''){
		global $wpdb;
		$additional_sql = '';
		
		
		if($_GET['page']=='horse-event'){
			$_REQUEST['eventID'] = $_GET['id'];
		}
		
		$sql_where = 'WHERE';
		if(!empty($_REQUEST['s'])){
			$additional_sql .= $sql_where.' '.wp_specialchars( stripslashes($_REQUEST['by']))." LIKE '%".wp_specialchars( stripslashes($_REQUEST['s']))."%'";
			$sql_where = 'AND';
		}
		if(!empty($_REQUEST['eventID'])){
			$additional_sql .= $sql_where." b.ID='".wp_specialchars( stripslashes($_REQUEST['eventID']))."'";
		}
		
		if(!empty($_REQUEST['orderby'])){
			$orderby_sql = ' ORDER BY '.$_REQUEST['orderby'] . ' '. $_REQUEST['order'];
		}else{
			$orderby_sql = ' ORDER BY ID DESC';
		}
		
		//horse_price_get_info
		
		$q="SELECT a.*,b.ID as eventID,b.eventname as eventname,count(c.ID) as totalprice
			FROM ".$this->_emp_tbl." as a
			LEFT JOIN ".$this->_emr_tbl." b ON b.ID=a.horseevent_id
			LEFT JOIN ".$this->_emc_tbl." c ON a.ID=c.race_id
			$additional_sql
			GROUP BY a.ID
			$orderby_sql
			";
		//echo $q;
		$events_results = $wpdb->get_results($q); 
		//$this->_total_events = $wpdb->get_var( "SELECT COUNT(*) FROM ".TABLE_NAME_EVENTS." ORDER BY ID ASC");
		return $events_results;
	}
	
    function prepare_items() {
        global $wpdb, $_wp_column_headers;
		
		$screen = get_current_screen();
		$user = get_current_user_id();
		$option = $screen->get_option('per_page', 'option');
		$per_page = get_user_meta($user, $option, true);
		if(!is_numeric($per_page)){
			$per_page =10;
		}
		
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();
		
		$_wp_column_headers[$screen->id]=$columns;
        $this->_column_headers = array($columns, $hidden, $sortable);
       
		wp_reset_vars( array( 'action', 'linkurl', 'name', 'image', 'description', 'visible', 'target', 'category', 'link_id', 'submit', 'orderby', 'order', 'links_show_cat_id', 'rating', 'rel', 'notes', 'linkcheck[]', 's' ) );

		$args = array( 'hide_invisible' => 0, 'hide_empty' => 0 );

		if ( !empty( $s ) )
			$args['search'] = $s;
		if ( !empty( $orderby ) )
			$args['orderby'] = $orderby;
		if ( !empty( $order ) )
			$args['order'] = $order;
			
       // $this->_column_headers = array($columns, $hidden, $sortable);
        
		
        //$this->process_bulk_action();   NO BULK for this script-  :) jenner
        
        $data = $this->get_horseevents();
		
        $current_page = $this->get_pagenum();
        $this->_total_item = $total_items = count($data);
		
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
        $this->items = $data;
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
		
		?>
		<style type="text/css">
			#ID{width: 70px;}
			#totalprice{width: 90px;}
			#eventname{width: 180px;}
			#horsebreed{width: 150px;}
			#race_result{width: 100px;}
			#date_added{width: 120px;}
			.button-primary span.count{color:#fff}
		
		</style>
		
		<script>
			
	jQuery(document).ready(function() {
		jQuery('.delete-race').click(function() {
			var t_ID = jQuery(this).attr('item');
		
			var ask_confirm = confirm("Are you sure you want to delete this Race?");
			if(ask_confirm == true){
				jQuery.ajax({
					url: "<?=site_url().'/wp-admin/admin-ajax.php'?>",
					type: 'post',
					dataType: "json",
					data: 'action=horse_racing_delete_race&ID='+t_ID,
					success: function(datae) {
						jQuery('#message').removeClass('updated');
						jQuery('#message').removeClass('error');
						
						jQuery('#message').fadeOut().fadeIn();
						jQuery('#message').addClass(datae['class']);
						jQuery('#message').html('<p>'+datae['text']+'</p>');
						
						if(datae['ID'] != null){
							jQuery('#row-' + t_ID).css('background-color','#ff8888');
							jQuery('#row-' + t_ID).fadeOut(700);
						}else{
							return false;
						}
					}
				});
				return false;
			}else{
				return false;
			}
		});
		
		jQuery('.delete-race-yes').live("click",function(){
			var t_ID = jQuery(this).attr('item');
	
			jQuery.ajax({
				url: "<?=site_url().'/wp-admin/admin-ajax.php'?>",
				type: 'post',
				dataType: "json",
				data: 'action=horse_racing_delete_race&confirm=yes&ID='+t_ID,
				success: function(datae) {
					jQuery('#message').removeClass('updated');
					jQuery('#message').removeClass('error');
					
					jQuery('#message').fadeOut().fadeIn();
					jQuery('#message').addClass(datae['class']);
					jQuery('#message').html('<p>'+datae['text']+'</p>');
					
					if(datae['ID'] != null){
						jQuery('#row-' + t_ID).css('background-color','#ff8888');
						jQuery('#row-' + t_ID).fadeOut(700);
					}else{
						return false;
					}
				}
			});
			return false;
		});
		
		jQuery('.delete-cancel').live("click",function(){
			jQuery('#message').fadeOut();
			jQuery('#message').html('<p>Delete Cancelled.</p>');
			return false;
		});
		
		
	});	
		
	</script>
		
		<?
		
    }
	function extra_tablenav( $which ) {
		global $wpdb;
		
		if ( 'top' == $which and $this->_total_item > 0){
			echo '<div class="tablenav one-page alignleft"><form method="get" action="">';
			$this->search_box( __( ' Search Race ' ), 'event_name' );
			
			$sel_search = $_REQUEST['by'];
			echo '<p class="search-box">Search 
				<select name="by" id="by">
					<option value="race_title" '.($sel_search == 'race_title' ? 'selected="true"' : '').'>Race Title</option>
					<option value="horsebreed" '.($sel_search == 'horsebreed' ? 'selected="true"' : '').'>Horse Breed</option>
					<option value="eventname" '.($sel_search == 'eventname' ? 'selected="true"' : '').'>Event Name</option>
				</select></p>';
				
				
			echo '<input type="hidden" name="page" class="post_status_page" value="'.$_GET['page'].'" />';
			echo '<input type="hidden" name="action" class="post_status_page" value="'.$_GET['action'].'" />';
			echo '<input type="hidden" name="id" class="post_status_page" value="'.$_GET['id'].'" />';
			echo '<input type="hidden" name="mode" class="post_status_mode" value="'.$_REQUEST['mode'].'" />';
			//wp_referer_field(true);
			echo '</form>';
			echo '<p><br/></p>';
			echo '</div>';
			
		}
		if ( 'top' == $which){
			if(isset($_REQUEST['by'])or isset($_REQUEST['s']) or isset($_REQUEST['orderby']) or  isset($_REQUEST['eventID'])){
				echo '<div class="tablenav one-page alignleft">
				<a href="?page='.$_GET['page'].'&action='.$_GET['action'].'&id='.$_GET['id'].'" class="button-primary">Reset Search/ Filter</a>
				</div>';
			}
		}
		$this->view_switcher($this->_mode_view);
	}

	
	function single_row( $item ) {
		static $row_class = '';
		$row_class = ( $row_class == '' ? ' class="alternate"' : '' );

		echo '<tr' . $row_class . ' id="row-'.$item->ID.'">';
		echo $this->single_row_columns( $item );
		echo '</tr>';
		}
}
