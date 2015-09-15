<?

if ( is_user_logged_in()){
	wp_logout();
	
	if(wp_get_referer()){
		wp_redirect(wp_get_referer().'/?logout');
	}
}

?>
<h1>logout account success</h1>