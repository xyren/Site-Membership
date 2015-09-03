

<div id="col-left">
	<div class="col-wrap">
		<div class="form-wrap">
			<h3>
			<a href="?page=horse-event&action=view&id=<?=$horseRace_info->horseevent_id;?>"><?=$horseRaceClass->returnRace($horseRace_id,'eventname');?></a>
			
			&raquo;
			<?=$horseRace_info->race_title?></h3>

			<div class="form-field form-required">
				<label>Race Title</label>
				<input name="tag-name" type="text" value="<?=$horseRace_info->race_title?>" size="40" disabled readonly="true"/>
			</div>
			<div class="form-field">
				<label>Horse Breed</label>
				<input name="slug" type="text" value="<?=$horseRace_info->horsebreed?>" size="40" disabled readonly="true" />
			</div>	
			
			<div class="form-field">
				<label>Winning Horse</label>
				<td><input name="horsename" type="text" id="horsename" value="<?=$horseRace_info->horsename?>" disabled readonly="true" />
			</div>
			
			<div class="form-field">
				<label>Scratches</label>
				<input name="scratches" type="text" id="scratches" value="<?=$horseRace_info->scratches?>" disabled readonly="true" />
			</div>
			
			<div class="form-field">
				<label>Race Result</label>
				<input name="slug" type="text" value="<?=$horseRace_info->race_result?>" size="40" disabled readonly="true" />
			</div>
			<div class="form-field">
				<label>Date - Added </label>
				<input name="slug" type="text" value="<?=$horseRace_info->date_added?>" size="40" disabled readonly="true" />
				<p><?=date('l, F j, Y  - g:i A',strtotime( $horseRace_info->date_added . ' ' . $horseRace_info->eventtime));?></p>
			</div>
			<div class="form-field">
				<label>Eventname  </label>
				<input name="slug" type="text" value="<?=$horseRaceClass->returnRace($horseRace_id,'eventname');?>" size="40" disabled readonly="true" />
			</div>

			<?
			$video_code = html_entity_decode(stripslashes($horseRace_info->videocode));
			if(!empty($video_code)){?>
			
				<div id="videorace">
					<? 
						$pattern_h = "/height=\"[0-9]*\"/";
						$video_codec = preg_replace($pattern_h, "height='300'", $video_code);
						$pattern_w = "/width=\"[0-9]*\"/";
						$video_code = preg_replace($pattern_w, "width='400'", $video_codec);
						echo $video_code;
					?>
				</div>
			<? } ?>
	

	<p class="submit">
		<a href="?page=horse-race&action=edit&id=<?=$horseRace_info->ID?>&eventID=<?=$horseRace_info->horseevent_id;?>&refer=<?=urlencode('?page=horse-race&id='.$horseRace_info->ID.'&action=view')?>" class="button">
		Edit Race Info</a></p>
	
		</div>
	

	</div>
</div>

