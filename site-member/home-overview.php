<div class="wrap">
	<h1>
Users	<a href="user-new.php" class="page-title-action">Add New</a>
</h1>

<ul class='subsubsub'>
	<li class='all'><a href='users.php' class="current">All <span class="count">(1)</span></a> |</li>
	<li class='administrator'><a href='users.php?role=administrator'>Administrator <span class="count">(1)</span></a></li>
</ul>



	<div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
        <div class="tablenav top">

		<div class="alignleft actions">
		  <form id="download_member" method="get">
						<select name="member_ver" id="member_ver">
			<option selected="selected" value="">Download Member List</option>
				<option class="hide-if-no-js" value="Yes">Verified</option>
				<option value="No">Not Verified</option>
			</select>
			<input type="submit" value="Download" class="button-secondary action" id="doaction" name="">
			<input name="page" type="hidden" id="page" value="horse-racing" />
					  <input name="download" type="hidden" id="download" value="true" />
					  </form>
					</div>
					
					<br class="clear">
		</div>
	</div>

<script>
	
	jQuery(document).ready(function($) {
		/*$("#download_member").submit(function(){
			alert($("#member_ver").val());	
			return false;
		});
		*/
	});
</script>
</div>
