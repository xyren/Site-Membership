
	<div class="wrap">	
		<h2>Add Member
		
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
				echo '</h2>';
				echo $_subjectname . ': ' .$_subName;
					
				echo ' <a href="edit.php?post_type=examination&page=questions-ui&'.
					'action=list-question&subID='.$_subjctID.'&subcat='.$_subjct.'" class="add-new-h2">Back to list</a>';
				echo '</p>';
				
				
				global $form_event_action, $form_action , $_subjID;
				$form_event_action = 'question_add';
				$_subjID = $_subjctID;
			/* 	$form_action="add";
				$fighterClass = new mma();
				$fighterClass->setFigther();
				$_fighter = $fighterClass->info();
				$fighter = (object) $_fighter; */
				include('form.question.php');
				
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