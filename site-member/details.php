
	
	<style>
		.question-cnt pre{font-family:Arial; font-size:14px;line-height:1.8em;}
		.question-cnt .choices{margin: 5px 10px;background-color:#eee;padding:10px;color:#333;}
		.question-cnt .choices.answer-correct{color:#000;font-weight:bold;border:1px solid #eee;background-color:#fff;}
	</style>
	<div class="updated question-cnt">
		<pre><?=stripslashes($questionInfo->question);?></pre>
	
		<?
			$_choice = json_decode($questionInfo->choices);
			if(!empty($_choice)){
				for($x=0;$x<=4;$x++){
					if(!empty($_choice[$x])){
						if($questionInfo->answerID == $x){
							echo '<div class="choices answer-correct">';
						}else{
							echo '<div class="choices">';
						}
						echo stripslashes($_choice[$x]).'</div>';
					}
				}
			}?>
	
	</div>
	
	<p class="submit">
		<a href="edit.php?post_type=examination&page=questions-ui&action=edit_question&subID=<?
			echo $_subjctID.'&subcat='.$_subjct.'&id='.$question_id;?>" class="button">Edit Question</a>
	</p>