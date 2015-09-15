<?



global $current_user;
if(!is_user_logged_in()){
	$current_url = $_SERVER["REQUEST_URI"];
	wp_redirect('/account/login/?redirect_to='. urlencode($current_url));
	exit;
}
get_header();?>
<h1>welcome to account index as dashboard</h1>
<a href="/account/logout/" class="button">Logout</a>
<?
get_footer();?>