<?php


class teamphoto{

	var $_data;
	
	var $_teamphoto_ID;
	var $_ID;
	
	var $_table_name;
	public static $_uploadDIR = TEAMPHOTO_UPLOAD_DIR;
	public static $_uploadURL = TEAMPHOTO_UPLOAD_URL;
	
	function __construct(){
		$this->_table_name = TEAMPHOTO_TABLE;
	}
	
	function setPhoto(){
		$this->_table_name = TEAMPHOTO_TABLE;
	}
	function setLogs(){
		$this->_table_name = TEAMPHOTO_TABLE_LOGS;
	}
	
	function set($_teamphoto_ID){
		global $wpdb;
		$this->_teamphoto_ID = $_teamphoto_ID;
		if(empty($this->_teamphoto_ID)){
			return false;
		}
		$data = $wpdb->get_row("SELECT * FROM {$this->_table_name} WHERE ID = {$this->_teamphoto_ID}", ARRAY_A);
		$this->_data = $this->cleanup($data);
		
		
		return $this->_data;
	}
	function info(){
		return $this->_data;
	}
	
	
	function cleanup($array){
		foreach($array as &$val){
			if(is_array($val)){
				$val = unstrip_array($val);
			}else{
				$val = stripslashes($val);
			}
		}
		return $array;
	}
	
	function add_logs($team_id, $updates = 'Updates'){
		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;
		$now = date('Y-m-d G:i:s');
		$data_logs= array(
			'team_id'	=> $team_id,
			'changes'=>  $updates,
			'user_id'=> $user_id,
			'date_added'	=> $now
		);
		$this->setLogs();
		$this->add($data_logs);
	}
	
	function add($emp_data){
		global $wpdb;
		$this->_data = $this->cleanup($emp_data);
		$wpdb->insert($this->_table_name,$this->_data);
		return $wpdb->last_error . $wpdb->insert_id;
	}
	function update($emp_data,$ID=0){
	
		global $wpdb;
		
		if($ID == 0){
			$ID = $this->_teamphoto_ID;
		}
		
		$this->_data = $this->cleanup($emp_data);
		$wpdb->update($this->_table_name,$this->_data,array('ID'=>$ID));
		return $wpdb->last_error . $this->_teamphoto_ID;
	}
	function delete($ID=0){
		global $wpdb;
		$wpdb->delete($this->_table_name,array('ID'=>$ID));
		return $wpdb->last_error . $this->_teamphoto_ID;
	}
	
	public function savephoto($photo_src,$sport,$add_path='',$add_img_fname='',$filename = '',$size = 150){
		$sport = preg_replace("/[^A-Za-z0-9]/", '', $sport);
		$sport = strtolower($sport);
		
		$sport_path = '/teams/'. $sport . '/'. $add_path .'/';
		$sport_path = str_replace('//','/',$sport_path);
		$img_path = teamphoto::$_uploadDIR . $sport_path ;
		if(!is_dir($img_path)){
			mkdir($img_path);
		}
		
		$_filename =  basename($photo_src);
		if(!empty($filename)){
			$_filename = $add_img_fname . $filename;
		}
		
		$_newfile = str_replace('//','/',$img_path . $_filename);
		if(file_exists($_newfile)){
			unlink($_newfile);
		}
		
		if(file_exists($photo_src)){
			//size always square
			teamphoto::_resize($photo_src, $size, $size ,$_newfile);
		}else{
			$sport_path ='Error: ';
			$_filename=' Image not exist';
		}
		return $sport_path . $_filename;
	}
		
	public function _resize($img, $w, $h, $newfilename) {
		//Check if GD extension is loaded
		if (!extension_loaded('gd') && !extension_loaded('gd2')) {
			trigger_error("GD is not loaded", E_USER_WARNING);
			return false;
		}

		//Get Image size info
		$imgInfo = getimagesize($img);
		switch ($imgInfo[2]) {
			case 1: $im = imagecreatefromgif($img); break;
			case 2: $im = imagecreatefromjpeg($img);  break;
			case 3: $im = imagecreatefrompng($img); break;
			default:  trigger_error('Unsupported filetype!', E_USER_WARNING);  break;
		}
		
	 /* 
		//If image dimension is smaller, do not resize
		if ($imgInfo[0] <= $w && $imgInfo[1] <= $h) {
			$nHeight = $imgInfo[1];
			$nWidth = $imgInfo[0];
		}else{
		//yeah, resize it, but keep it proportional
			if ($w/$imgInfo[0] > $h/$imgInfo[1]) {
				$nWidth = $w;
				$nHeight = $imgInfo[1]*($w/$imgInfo[0]);
			}else{
				$nWidth = $imgInfo[0]*($h/$imgInfo[1]);
				$nHeight = $h;
			}
		}
		*/
		$imgInfo = getimagesize($img);
		$ratio = $imgInfo[0]/$imgInfo[1]; // width/height
		if( $ratio > 1) {
			$nWidth = $w;
			$nHeight = $h/$ratio;
		}
		else {
			$nWidth = $w*$ratio;
			$nHeight = $h;
		}
		
		$nWidth = round($nWidth);
		$nHeight = round($nHeight);

		$newImg = imagecreatetruecolor($nWidth, $nHeight);

		/* Check if this image is PNG or GIF, then set if Transparent*/  
		if(($imgInfo[2] == 1) OR ($imgInfo[2]==3)){
			imagealphablending($newImg, false);
			imagesavealpha($newImg,true);
			$transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
			imagefilledrectangle($newImg, 0, 0, $nWidth, $nHeight, $transparent);
		}
		imagecopyresampled($newImg, $im, 0, 0, 0, 0, $nWidth, $nHeight, $imgInfo[0], $imgInfo[1]);

		//Generate the file, and rename it to $newfilename
		switch ($imgInfo[2]) {
			case 1: imagegif($newImg,$newfilename); break;
			case 2: imagejpeg($newImg,$newfilename);  break;
			case 3: imagepng($newImg,$newfilename); break;
			default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
		}
		return $newfilename;
	}
	
	function checking($field,$val,$ID=0){
		global $wpdb;
		
		$ID = trim($ID);
		$val = trim($val);
		$field = trim($field);
		$search_ID ='';
		
		if($ID>0){
			$search_ID = "AND NOT ID={$ID}";
		}
			
		$q = "SELECT ID FROM {$this->_table_name} WHERE {$field} LIKE '{$val}' {$search_ID}";
		$count = $wpdb->get_var($q);
		return $count;
	}
	function search($field,$val,$ID=0){
		global $wpdb;
		
		$ID = trim($ID);
		$val = trim($val);
		$field = trim($field);
		$search_ID ='';
		
		if($ID>0){
			$search_ID = "AND NOT ID={$ID}";
		}
		$q = "SELECT ID FROM {$this->_table_name} WHERE {$field}='{$val}' {$search_ID}";
		
		$count = $wpdb->get_var($wpdb->prepare($q));
		return $count;
	}
	function searchboth($field,$val,$field2,$val2){
		global $wpdb;
		
		$ID = trim($ID);
		$val = trim($val);
		$field = trim($field);
		$val2 = trim($val2);
		$field2 = trim($field2);
		
		$q = "SELECT ID FROM {$this->_table_name} WHERE {$field}='{$val}' AND {$field2}='{$val2}'";
		
		$count = $wpdb->get_var($wpdb->prepare($q));
		return $count;
	}
	function total($field,$val){
		global $wpdb;
		$val = trim($val);
		$field = trim($field);
		
		$q = "SELECT COUNT(ID) FROM {$this->_table_name} WHERE {$field}='{$val}'";
		
		$count = $wpdb->get_var($wpdb->prepare($q));
		return $count;
	}
}

if(!function_exists('unstrip_array')){
	function unstrip_array($array){
		foreach($array as &$val){
			if(is_array($val)){
				$val = unstrip_array($val);
			}else{
				$val = stripslashes($val);
			}
		}
	return $array;
	}
}