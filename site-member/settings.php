<?

?>

<div class="wrap">	
	<h1>Settings</h1>
	
	<div id="ajax-response"></div>
	<?
	
	$_options = get_option('site-member-settings');
	//print_r($_options);
	?>
	
	<script>
	jQuery(document).ready(function($) {
		
		jQuery('#site-member-settings').on("submit", function(){
			$(this).api_ajax("#ajax-response","Settings successfully saved.");
			return false;
		});
		
		jQuery('.nav-tab').on("click", function(){
			jQuery('.nav-tab').removeClass('nav-tab-active');
			jQuery(this).addClass('nav-tab-active');
			jQuery(this).blur();
			var tab_ID = jQuery(this).attr('tab-id');
			var tab_title = jQuery(this).attr('title');
			jQuery('.nav-tab-wrapper-content').hide();
			jQuery('#'+tab_ID).fadeIn();
			<?
			$page_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			$page_link .= "?page={$_GET['page']}&tab=";
			?>
			window.history.pushState("Site Member Settings"+tab_title, "Settings: "+tab_title, "<?=$page_link;?>"+tab_ID);
			return false;
		});
		
	});
	</script>
	<style>
		.hide{display:none}
	</style>
	
	<br/>
	
    <h2 class="nav-tab-wrapper">
    <? 
		
	$tabs = array();
	$settings_tabs = array();
	
	foreach (glob(MEMBERS_DIR_PLUG .'/site-member/settings_*.php') as $filename){
        $_info = get_file_data($filename,array('Tab Name','Tab ID'));
		$tabs[$_info[1]] = $_info[0];
		$settings_tabs[] = $filename;
	}
    
    echo '';
    $current = empty($_GET['tab']) ? 'tab-content-api' : $_GET['tab'];
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
		echo "<a class='nav-tab{$class}' href='?page={$_GET['page']}&tab={$tab}' tab-id='{$tab}' title='{$name}'>$name</a>";
    }
    ?></h2>
    <?
    $nextend_fb_connect = maybe_unserialize(get_option('nextend_fb_connect'));
    
    
    print_r($nextend_fb_connect);
    ?>
    
    
    
	<form method="post" name="site-member-settings" id="site-member-settings">
		<input type="hidden" name="action" value="settings_save" />
		
		<?php wp_nonce_field(MEMBERS_SECRET.'_settings'); ?>
		
		<?
		global $_include;
		$_include = false;
		foreach ($settings_tabs as $filename){
            include($filename);
		}
		?>
		
		<p class="submit">
			<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"  />
		</p>
		
	</form>
	
	<script>
			//default tab
			jQuery(document).ready(function($) {
				$('#<?=$current;?>').fadeIn();
			});
	</script>


</div>