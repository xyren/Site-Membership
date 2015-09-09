
	<div class="wrap">	
		<h2>View Question
		
		<?
		if(isset($_GET['subcat']) && isset($_GET['subID'])){
			$_subjct = $_GET['subcat'];
			$_subjctID = $_GET['subID'];
			
			$term = get_term_by('slug', $_subjct, 'exam'); 
			$_subjectname = $term->name; 
			$_subName = get_the_title( $_GET['subID']);
			
			if(empty($_subjectname) or empty($_subName)){			
				echo ' Error: 
					</h2><div class="error below-h2" id="message">
					<p><b>Invalid request:</b> The subject your requesting to view doesn\'t exist in database.
					</p>
				</div>';
			}else{
				echo '</h2><h3>';
				echo $_subjectname . ': ' .$_subName;
					
				echo '</h3> <a href="edit.php?post_type=examination&page=questions-ui&'.
					'action=list-question&subID='.$_subjctID.'&subcat='.$_subjct.'" class="add-new-h2">Back to list</a>';
				echo '</p>';
				
				
						
				$question_id = $_GET['id'];
				//if(empty($question_id)) return;
				
				
				global $_subjID, $wpdb, $questionInfo;
				$_subjID = $_subjctID;
				
				$questionInfo = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}questions WHERE ID = '{$question_id}'");
				
				
				if($questionInfo->ID){
					
					include('view.question-details.php');
				}else{
					echo '<div class="error below-h2" id="message">
				<p><b>Invalid request:</b> The subject your requesting to view doesn\'t exist in database.
				</p>
			</div>';
				}
				
			}
		}else{
			echo 'Error: 
				</h2><div class="error below-h2" id="message">
				<p><b>Invalid request:</b> The subject your requesting to view doesn\'t exist in database.
				</p>
			</div>';
		}
		
		
    ?>
		
	</div>
	