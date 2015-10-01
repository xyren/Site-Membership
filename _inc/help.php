<?

function sitemember_settings_add_help(){
	
	$screen = get_current_screen();
	//$screen->remove_help_tabs();
	
	global $_include,$_help_tab;
	$_include = true;
	foreach (glob(MEMBERS_DIR_PLUG .'/site-member/settings_*.php') as $filename){
        $_info = get_file_data($filename,array('Tab Name','Tab ID'));
		$tabs[$_info[1]] = $_info[0];
		include_once($filename);
	}
	foreach ($_help_tab as $_help){
		$screen->add_help_tab( $_help);
	}
	/* // Help sidebars are optional
	$screen->set_help_sidebar(
		'<p><strong>' . __( 'For more information:' ) . '</strong></p>' .
		'<p><a href="http://wordpress.org/support/" target="_blank">' . _( 'Support Forums' ) . '</a></p>'
	);
	 */
}

add_action( 'load-site-member_page_site-member-settings', 'sitemember_settings_add_help' );

/* if (isset($_GET['page']) && $_GET['page'] == 'site-member-settings') {
	add_action('contextual_help', 'sitemember_settings_add_help', 10, 3);
} */