<?php
	
if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/*/
	 * ======================== Split Languages ===============
	 * @Returns languages separatad by space
	 * @param $delimiter : the needle to split the languages
	 * @param $separator : the language output separator
	 * @param $languages : the languages
	/*/
class members_list_Table extends WP_List_Table {
	var $_total_item;
	var $level_id;
	var $_mode_view;
	var $_table_users;
	var $_table;
	
    function __construct($level_id = null){
        global $status, $page;
		
        parent::__construct( array(
            'singular'  => ' member',
            'plural'    => ' members',
            'ajax'      => false
        ) );
		$this->_mode_view = isset($_GET['mode']) ? $_GET['mode'] : 'list';
		$this->level_id = $level_id;
		
		$this->_table = MEMBERS_TABLE;
		$this->_table_users = WPUSERS_TABLE;
		
    }
    
	function get_columns(){
		$columns = array(
			'cb'       		    => '<span class="drag-icon"></span>', //Render a checkbox instead of text
			'ID'     		    => 'ID',
			'thumb'     	    => 'thumb',
			'user_login'  	    => 'Username',
			'user_nicename'      => 'Name',
			'user_email' 	    => 'E-mail',
			'social_account'     => 'Social Account',
			'user_registered' 	=> 'Date Added',
		);
		
		if($this->_mode_view == 'excerpt'){
			$columns = array(
				'cb'       		=> '<span class="drag-icon"></span>', //Render a checkbox instead of text
				'ID'     		=> 'ID',
				'thumb'         => 'thumb',
				'user_nicename' => 'Name',
				'user_email' 	=> 'E-mail',
				'social_account' 		=> 'Social Account',
			);
		}
			
        return $columns;
    }
    function get_sortable_columns() {
        $sortable_columns = array(
			'ID'     		    => array('ID',true),     //true means its already sorted
			'user_login'  	    => array('Username',false), 
			'user_nicename'     => array('Name',false), 
			'user_email' 	    => array('E-mail',false), 
			'user_registered' 	=> array('Date Added',false), 
        );
        return $sortable_columns;
    }
    function get_hidden_columns(){
        global $sitemember_screen_manage;
        $_screen_name = $sitemember_screen_manage[$this->level_id];
		$columns = (array) get_user_option( 'manage'. $_screen_name.'columnshidden');
        return $columns;
    }
    
	
    function column_default($item, $column_name){
        global $wpdb, $social_account;
		switch($column_name){
			case 'ID':
				return '<span id="td_'.$item->ID.'">'.$item->ID.'</span>';
	        case 'user_registered':
				return date('F j, Y', strtotime($item->$column_name)) .'<br/>'.  date('g:i a', strtotime($item->$column_name));
	        case 'user_nicename':
				return $item->$column_name;
	        case 'user_login':
				return $item->$column_name;
			case 'user_email':
				return $item->$column_name;
	        case 'social_account':
				return $social_account[$item->$column_name];
	        default:
                return print_r($item,true); //Show the whole array for troubleshooting purposes
        }
    }
	
	function column_cb($item){
        return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
            'ID',
            $item->ID
        );
    }
	
	function column_user_login($item){
		global $wpdb, $social_account ;
		
		$actions = array(
            'view'      => '<a href="?page=iog-menu_sections&action=view&ID='.$item->ID.'">View Students</a>',
            'edit'      => '<a href="?page=iog-menu_sections&action=edit&ID='.$item->ID.'">Edit Details</a>',
            'delete'    => '<a href="#" item="'.$item->ID.'" class="trash delete">Delete</a>'
        );
        return sprintf(
				'<strong>
				<a href="?page=iog-menu_sections&action=view&ID='.$item->ID.'" title="View Details">
				%1$s</a>
				</strong> <br/> %2$s',
					stripslashes( $item->user_login),
					$this->row_actions($actions)
				
        );
    }
	
	
    function get_lists($def_sql=''){
		global $wpdb;
		$q="SELECT a.*,b.* FROM ". $this->_table." as a INNER JOIN ".$this->_table_users." as b ON a.userID=b.ID WHERE 
			a.level_id='{$this->level_id}' {$def_sql} ORDER BY a.ID DESC";
		$events_results = $wpdb->get_results($q);
		return $events_results;
	}
	
    function prepare_items($sem_ID = 0) {
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
		
		
		if(!empty($sem_ID)){
			$data = $this->get_lists(" AND a.sem_ID = '{$sem_ID}'");
		}else{
			$data = $this->get_lists();
		}
		
		//print_r($data);
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
			#ID{width: 70px !important;}
			#section_no{width: 250px;}
			#social_account{width: 150px;}
			#remarks{min-width: 150px;}
			#school_year{width: 80px;}
			#user_registered{width: 150px;}
		</style>
	<script>
	
	jQuery(document).ready(function() {
		
		jQuery('.delete').click(function() {
			var t_ID = jQuery(this).attr('item');
		
			var ask_confirm = confirm("Are you sure you want to delete this Section?"+t_ID);
			if(ask_confirm == true){
				jQuery.ajax({
					url: "<?=site_url().'/wp-admin/admin-ajax.php'?>",
					type: 'post',
					dataType: "json",
					data: 'action=section_delete&ID='+t_ID,
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
		
    });
		
	</script>
		<?
    }
	
	function extra_tablenav( $which ) {
		global $wpdb;
		
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


