<?


class site_members{
	
	public static $memberLevel = array(
		1 => 'Member',
		2 => 'Band',
		3 => 'Venue Manager',
		4 => 'Modulator',
		7 => 'Admin',
	);
	
	public function __construct() {
		//$this->memberLevel = 
	}
	
	public function init() {
		
		foreach (self::rewrite() as $rule => $rewrite) {
	        add_rewrite_rule( $rule,$rewrite, 'top' );
	    }
	  
		add_filter('template_include', array( 'site_members', 'template_include' ),1,1);  
		//add_filter('template_redirect', array( 'site_members', 'template_include' ));  
		
		add_filter( 'query_vars', array( 'site_members', 'prefix_register_query_var'));
		account::ajax_init();
	}
	
	public function prefix_register_query_var($vars){
	    $vars[] = 'cl';
	    $vars[] = 'mod';
	    $vars[] = 'func';
	    $vars[] = 'lv';
	    return $vars;
	}
	
	
	public function memberLevel($_ID=''){
	
		if(!empty($_ID) and $_ID !== false){
			if(array_key_exists($_ID, self::$memberLevel)){
				$_t = self::$memberLevel;
				return $_t[$_ID];
			}
			return false;
		}
		return self::$memberLevel;
	}
	
	public function levelID(){
		return self::get_levelID_from_url();
	}
	
	public function get_levelID_from_url(){
		$_reqID = explode('_',$_GET['page']);
		$_levelID = (int)end($_reqID );
		
		if(array_key_exists($_levelID,self::$memberLevel)){
			return $_levelID;
		}
		return false;
	}
	
	public function rewriteRules($rules){
		$newrules = self::rewrite();
		return $newrules + $rules;
	}
	
	public function rewrite(){
		$newrules = array();
		$newrules['profile-casting/jobs/(.*)/(.*)$'] = 'index.php?type=castingjobs&target=$matches[1]&value=$matches[2]&rbgroup=casting';
		$newrules['profile-casting/(.*)$'] = 'index.php?type=casting&target=$matches[1]&rbgroup=casting';
		$newrules['profile-casting'] = 'index.php?type=casting&rbgroup=casting';
		
		$newrules['signup/(.*)$'] = 'index.php?cl=site_member&mod=account&func=signup&lv=$matches[1]';
		$newrules['signup'] = 'index.php?cl=site_member&mod=account&func=signup';
		$newrules['register'] = 'index.php?cl=site_member&mod=account&func=signup';
		
		$newrules['account/(.*)$'] = 'index.php?cl=site_member&mod=account&func=$matches[1]';
		$newrules['account'] = 'index.php?cl=site_member&mod=account&func=index';
		
		return $newrules;
	}
	
	public function removeRules($rules){
		$newrules = self::rewrite();
		foreach ($newrules as $rule => $rewrite) {
	        unset($rules[$rule]);
	    }
		return $rules;
	}
	
	public function template_include($template){
		
		$_templateDir = MEMBERS_DIR_PLUG . '/template';
		$_class = get_query_var( 'cl' );
		$_module = get_query_var('mod');
		$_function = get_query_var('func');
		if($_class == "site_member"){
			switch ($_module){
				case 'account':
					print_r( $_function);
					$_access = $_templateDir . '/'. $_module .'/'. $_function .'.php';
					if(file_exists($_access)){
						return $_access;
					}
					if(empty($_function))
						return $_templateDir . '/'. $_module .'/index.php';
					return $_templateDir . '/'. $_module .'/404.php';
					
				default: echo "No match!"; break;	
			}
		}
		return $template;
	}
	
	public function install(){
		global $wp_rewrite, $wpdb;
		foreach(self::$memberLevel as $key => $val){
			$_member = new member_level($key);
			add_role( $_member->key ,$_member->name, array( 'read' => true, 'level_0' => true ));
		}
	    remove_role( 'subscriber');
		add_filter('rewrite_rules_array', 'site_members::rewriteRules'); 
		$wp_rewrite->flush_rules( false );
		
		$_sql = array();
		$_sql[] = '
			CREATE TABLE IF NOT EXISTS `'. MEMBERS_TABLE .'` (
			  `ID` bigint(20) NOT NULL,
			  `userID` bigint(11) NOT NULL,
			  `member_accepted` datetime NOT NULL,
			  `level_id` int(11) NOT NULL
			) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
			';
		$_sql[] = 'ALTER TABLE `'. MEMBERS_TABLE .'` ADD PRIMARY KEY (`ID`);';

		
		$_error = array();
		foreach($_sql as $_query){
			$wpdb->query($_query);
			if(!empty($wpdb->last_error)){
				$_error[] = $wpdb->last_error;
			}
		}
		
		update_option('site_membership_version',site_membership_version);
		
	}
	
	public function uninstall(){
		global $wp_rewrite;
		foreach(self::$memberLevel as $key => $val){
			$_member = new member_level($key);
			remove_role( $_member->key);
		}
		add_role( 'subscriber','Subscriber', array( 'read' => true, 'level_0' => true ));
		
		add_action('generate_rewrite_rules', function ($wp_rewrite){
			$newrules = self::rewrite();
            $wp_rewrite->rules = $newrules + $wp_rewrite->rules;
		});
		add_filter('rewrite_rules_array', 'site_members::removeRules'); 
		$wp_rewrite->flush_rules( false );
	}
	
}

class member_level{
	
	public $id;
	public $name;
	public $role;
	
	public function __construct($_ID = 0) {
		
		if(!empty($_ID) and $_ID !== false){
			if(array_key_exists($_ID, site_members::$memberLevel)){
				$_t = site_members::$memberLevel;
				$this->id = $_ID;
				$this->name = $_t[$_ID];
				$this->key = str_replace( '-', '_', sanitize_title( $_t[$_ID] ));
				$this->role = 0;
			}
		}
	}
}


