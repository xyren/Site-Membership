<div class="wrap">	
	<h1 id="add-new-user">Add New User</h1>
		<?
		$_levelID = site_members::get_levelID_from_url();
		$_level = site_members::memberLevel($_levelID);
		if(!empty($_level)){
			echo "Add ".$_level;
		}else{
			die('Request Member Level not found.');
		}?>
	</h1>
	<p>Create a brand new <?=$_level;?> and add them to this site.</p>
	
	<?
	
	$now = current_time('mysql');

	global $wpdb;
	$_temp ='the_x_con';
		$userdata = array(
			'user_pass' => esc_attr($_temp),
			'user_login' => esc_attr($_temp),
			'first_name' => esc_attr($_temp .'first'),
			'last_name' => esc_attr($_temp.' last'),
			'user_email' => esc_attr($_temp .'@email.com'),
			'role' => 'modulator'
		);
		$new_user = wp_insert_user( $userdata );
		
		$wpdb->insert(MEMBERS_TABLE , array('userID'=>$new_user , 'member_accepted'=>$now , 'level_id' => 4));
		$insert_id= $wpdb->insert_id;
	
		?>
	
	
	<form>
 <input type="password" name="password" />
 <input type="password" name="password_retyped" />
 <span id="password-strength"></span>
 <input type="submit" disabled="disabled" value="Submit" />
</form>





<?
	
				
				global $form_event_action, $form_action , $_subjID;
				$form_event_action = 'question_add';
				$_subjID = $_subjctID;
			/* 	$form_action="add";
				$fighterClass = new mma();
				$fighterClass->setFigther();
				$_fighter = $fighterClass->info();
				$fighter = (object) $_fighter; */
				include('form.php');
				
			
	
			echo 'Error: 
				</h2><div class="error below-h2" id="message">
				<p><b>Invalid request:</b> The subject your requesting to view doesn\'t exist in database.
				</p>
			</div>';
		
		
		
    ?>
		
	</div>