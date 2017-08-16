<?php

$FORMS = Array();

$FORMS['reflection_block'] = <<<END

	<tr>
		<td>
			Аватар
		</td>
		
		<td>
			%groups%
		</td>
	</tr>
	
		
	<tr>
		<td>
			Загрузить свой аватар
		</td>
		
		<td>
			<input type="file" name="avatar[user_avatar_file]" />
		</td>
	</tr>

END;

$FORMS['reflection_group'] = <<<END

%fields%

END;


$FORMS['reflection_field_relation'] = <<<END

         									%options%

END;


/*аватары здесь*/
$FORMS['reflection_field_relation_option'] = <<<END

									<div class="radio">
										<label for="item11">
											%data getPropertyOfObject(%id%, 'picture', 'avatar')%
										</label>
										<input type="radio" id="item11" name="%input_name%" value="%id%" />
									</div>

END;

$FORMS['reflection_field_relation_option_a'] = <<<END

									<div class="radio">
										<label for="item11">
											%data getPropertyOfObject(%id%, 'picture', 'avatar')%
										</label>
										<input type="radio" id="item11" name="%input_name%" value="%id%" checked="checked" />
									</div>

END;

?>
