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
	
	
	
}