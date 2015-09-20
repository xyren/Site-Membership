<?
add_action('admin_menu', 'sitemember_menu');

function sitemember_menu(){
	global $sitemember_screen_manage;
	add_menu_page('Site Member','Site Member','administrator','site-member','sitemember_ui','dashicons-groups');

	$sitemember_screen = add_submenu_page('site-member','Site Members Overview','Overview','administrator','site-member','sitemember_ui');
		add_submenu_page('site-member','Add Site Member','Add New Event','administrator','site-member-add','sitemember_add_ui');
		/* add_submenu_page('site-member1','Edit Site Member','Edit Site Member','administrator','site-member&action=edit','sitemember_edit_ui');
		 */
		
		foreach(site_members::memberLevel() as $key => $val){
			$sitemember_screen_manage[$key] = add_submenu_page('site-member','Manage All '. $val,$val,'administrator','site-member-list_'.$key,'sitemember_manage_ui');
			add_submenu_page('site-member1','Add '. $val,'Add '. $val,'administrator','site-member-list_'.$key.'&action=add','sitemember_manage_ui');
			add_submenu_page('site-member1','edit '. $val,'edit '.$val,'administrator','site-member-list_'.$key.'&action=edit','sitemember_manage_ui');
			add_submenu_page('site-member1','view '. $val,'view '.$val,'administrator','site-member-list_'.$key.'&action=edit','sitemember_manage_ui');
		}
		
		add_submenu_page('site-member','Settings & Config','Settings & Config','administrator','site-member-settings','sitemember_settings_ui');
		
	
	if(isset($_GET['page'])){
		if(strrpos($_GET['page'],'site-member-list') !== false){
			
			
			if(isset($_GET['action'])== 'add'){
				add_action('admin_print_scripts',array('member_scripts','member_form_add'));
			}
			
			
		}else{
			if(is_admin()){
				if(strrpos($_GET['page'],'site-member') !== false){
					add_action('admin_print_scripts',array('member_scripts','admin'));
					echo "wow";
				}
			}
		}
		
	}
	
	
}

function sitemember_manage_ui(){
	switch ($_GET['action']) {
		case 'add':
			sitemember_add_ui();break;
		case 'edit':
			sitemember_edit_ui();break;
		case 'view':
			sitemember_view_ui();break;
		default:
			require_once(MEMBERS_DIR_PLUG .'/site-member/list.php');break;
	}
	//require_once('home-overview.php');
}

function sitemember_ui(){
	switch ($_GET['action']) {
		case 'add':
			sitemember_add_ui();break;
		case 'edit':
			sitemember_edit_ui();break;
		case 'view':
			sitemember_view_ui();break;
		default:
			require_once(MEMBERS_DIR_PLUG .'/site-member/home-overview.php');break;
	}
	//require_once('home-overview.php');
}
function sitemember_add_ui(){require_once(MEMBERS_DIR_PLUG.'/site-member/add.php');}
function sitemember_edit_ui(){require_once('site-member/edit.php');}
function sitemember_view_ui(){require_once('site-member/view.php');}

function sitemember_settings_ui(){require_once(MEMBERS_DIR_PLUG.'/site-member/settings.php');}


