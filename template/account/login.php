<?php


// *************************************************************************************************** //
// Respond to Login Request
if ( $_SERVER['REQUEST_METHOD'] == "POST" && !empty( $_POST['action'] ) && $_POST['action'] == 'log-in' ) {

	global $error;
	//$login = wp_login( $_POST['user-name'], $_POST['password'] ); TODO: remove deprecated
	$login = wp_signon( array( 'user_login' => $_POST['user-name'], 'user_password' => $_POST['password'], 'remember' => isset($_POST['remember-me'])?$_POST['remember-me']:false ), false );

    get_currentuserinfo();
    
	if(isset($login->ID)) {
		wp_set_current_user($login->ID);// populate
			get_user_login_info();
	}
}

function get_user_login_info(){

    global $user_ID;
	$redirect = isset($_REQUEST["lastviewed"])?$_REQUEST["lastviewed"]:"";
	get_currentuserinfo();
	$user_info = get_userdata( $user_ID );

	
	$customUrl = '/casting-dashboard/';
	
	
	
	if($user_ID){

		// If user_registered date/time is less than 48hrs from now
	
		if(!empty($redirect)){
			header("Location: ". get_bloginfo("wpurl"). "/profile/".$redirect);
		} else {

			// If Admin, redirect to plugin
			if( $user_info->user_level > 7) {
				echo 'admin';
				//header("Location: ". admin_url("admin.php?page=rb_agency_menu"));
			} else {
				header("Location: ". get_bloginfo("wpurl"). $customUrl);
		
			}
		}
	} elseif(empty($_POST['user-name']) || empty($_POST['password']) ){
		header("Location: ". get_bloginfo("wpurl"));

	} else {
		header("Location: ". get_bloginfo("wpurl"). "/profile-member/");
		
	}
}

// ****************************************************************************************** //
// Already logged in 
	if (is_user_logged_in()) {

		global $user_ID; 
		$login = get_userdata( $user_ID );
		get_user_login_info();


// ****************************************************************************************** //
// Not logged in
	} else {

		// *************************************************************************************************** //
		// Prepare Page
		echo 'header';

		echo "<div id=\"rbcontent\" class=\"rb-interact rb-interact-login\">\n";

			// Show Login Form
			$hideregister = true;

	
		$widthClass = "half";
	

	echo "     <div id=\"rbsignin-register\" class=\"rbinteract\">\n";

	if ( $error ) {
	echo "<p class=\"error\">". $error ."</p>\n";
	}

	echo "        <div id=\"rbsign-in\" class=\"inline-block\">\n";
	echo "          <h1>". __("Members Sign in", RBAGENCY_interact_TEXTDOMAIN). "</h1>\n";
	
	if(isset($_POST['action'])){
		echo '<div id="login_error">	<strong>ERROR</strong>: Invalid username. <a href="http://wp.xyren.pc/wp-login.php?action=lostpassword">Lost your password?</a><br />';
	}
	echo "          <form name=\"loginform\" id=\"login\" action=\"". network_site_url("/"). "account/login/?try\" method=\"post\">\n";
	echo "            <div class=\"field-row\">\n";
	echo "              <label for=\"user-name\">". __("Username", RBAGENCY_interact_TEXTDOMAIN). "</label><input type=\"text\" name=\"user-name\" value=\"". esc_attr( isset($_POST['user-name'])?$_POST['user-name']:"", 1 ) ."\" id=\"user-name\" />\n";
	echo "            </div>\n";
	echo "            <div class=\"field-row\">\n";
	echo "              <label for=\"password\">". __("Password", RBAGENCY_interact_TEXTDOMAIN). "</label><input type=\"password\" name=\"password\" value=\"\" id=\"password\" /> <a href=\"". get_bloginfo('wpurl') ."/wp-login.php?action=lostpassword\">". __("forgot password", RBAGENCY_interact_TEXTDOMAIN). "?</a>\n";
	echo "            </div>\n";
	echo "            <div class=\"field-row\">\n";
	echo "              <label><input type=\"checkbox\" name=\"remember-me\" value=\"forever\" /> ". __("Keep me signed in", RBAGENCY_interact_TEXTDOMAIN). "</label>\n";
	echo "            </div>\n";
	echo "            <div class=\"field-row submit-row\">\n";
	echo "              <input type=\"hidden\" name=\"action\" value=\"log-in\" />\n";
	echo "              <input type=\"submit\" value=\"". __("Sign In", RBAGENCY_interact_TEXTDOMAIN). "\" /><br />\n";
	echo "            </div>\n";
	echo "          </form>\n";
	echo "        </div> <!-- rbsign-in -->\n";

	
	
	

		if (( current_user_can("create_users") || $rb_agencyinteract_option_registerallow == 1)) {
	
				/*	echo "        <div id=\"rbsign-up\" class=\"inline-block\">\n";
					echo "          <div id=\"talent-register\" class=\"register\">\n";
					echo "            <h1>". __("Not a member", RBAGENCY_interact_TEXTDOMAIN). "?</h1>\n";
					echo "            <h3>". __("Client", RBAGENCY_interact_TEXTDOMAIN). " - ". __("Register here", RBAGENCY_interact_TEXTDOMAIN). "</h3>\n";
					echo "            <ul>\n";
					echo "              <li>". __("Create your free profile page", RBAGENCY_interact_TEXTDOMAIN). "</li>\n";
					echo "              <li><a href=\"". get_bloginfo("wpurl") ."/casting-register\" class=\"rb_button\">". __("Register as Casting Agent", RBAGENCY_interact_TEXTDOMAIN). "</a></li>\n";
					echo "            </ul>\n";
					echo "          </div> <!-- talent-register -->\n";
					echo "          <div class=\"clear line\"></div>\n";*/
					echo "        <div id=\"rbsign-up\" class=\"inline-block\">\n";
					echo "          <div id=\"talent-register\" class=\"register\">\n";
					echo "            <h1>". __("Not a member", RBAGENCY_interact_TEXTDOMAIN). "?</h1>\n";

					echo "<h3>Client - Register here</h3>
					<ul>
						<li>Create your free profile page</li>
						<li>List Auditions & Jobs Free free</li>
						<li>Contact People in the talent Directory</li>
					</ul>
					<input type=\"button\" onclick=\"location.href='/casting-register'\" value=\"Register Now\">
					
					";
					
					echo "          </div> <!-- talent-register -->\n";
					echo "          <div class=\"clear line\"></div>\n";
					echo "        </div> <!-- rbsign-up -->\n";
	
					echo "        </div> <!-- rbsign-up -->\n";
		}
	

	echo "      <div class=\"clear line\"></div>\n";
	echo "      </div>\n";

	}// Done
