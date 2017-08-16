<?php

$FORMS = Array();

$FORMS['reflection_block'] = <<<END
%groups%
END;

$FORMS['reflection_group'] = <<<END
<table>
	<tr>
		<td colspan="2">
			<br/><br /><b>%title%</b><br /><br />
		</td>
	</tr>
	%fields%
</table>
END;


$FORMS['reflection_field_string'] = <<<END
	<tr>
		<td style="padding-bottom: 10px;">
			%title%%required_asteriks%:
		</td>
		<td style="padding-bottom: 10px;">
			<input id="%name%" type="text" name="%input_name%" value="%value%" class="textinputs" />
		</td>
	</tr>
END;

$FORMS['reflection_field_date'] = <<<END
	<tr>
		<td>
			%title%%required_asteriks%:
		</td>
		<td>
			<input type="text" name="%input_name%" value="%value%" class="textinputs" size="50" />
		</td>
	</tr>
END;

$FORMS['reflection_field_text'] = <<<END
	<tr>
		<td>
			%title%%required_asteriks%:
		</td>
		<td>
			<textarea name="%input_name%" class="textinputs">%value%</textarea>
		</td>
	</tr>
END;


$FORMS['reflection_field_wysiwyg'] = <<<END
	<tr>
		<td>
			%title%%required_asteriks%:
		</td>
		<td>
			<textarea name="%input_name%" class="textinputs">%value%</textarea>
		</td>
	</tr>
END;

$FORMS['reflection_field_int'] = <<<END
	<tr>
		<td>
			%title%%required_asteriks%:
		</td>
		<td>
			<input type="text" name="%input_name%" value="%value%" class="textinputs" />
		</td>
	</tr>
END;

$FORMS['reflection_field_boolean'] = <<<END
	<tr>
		<td>
			%title%%required_asteriks%:
		</td>
		<td>
			<input type="hidden" id="%input_name%" name="%input_name%" value="%value%" />
			<input onclick="javascript:document.getElementById('%input_name%').value = (this.checked) ? '1' : '0';" type="checkbox" %checked% value="1" />
		</td>
	</tr>
END;

$FORMS['reflection_field_password'] = <<<END
	<tr>
		<td>
			%title%%required_asteriks%:
		</td>
		<td>
			<input type="password" name="%input_name%" value="" class="textinputs" />
		</td>
	</tr>
	<tr>
		<td>
			Подтверждение:
		</td>
		<td>
			<input type="password" name="%input_name%" value="" class="textinputs" />
		</td>
	</tr>
END;


$FORMS['reflection_field_relation'] = <<<END
	<tr>
		<td>
			%title%%required_asteriks%:
		</td>

		<td>
			<select name="%input_name%" style="width: 205px" class="textinputs">
				<option />
				%options%
			</select>
		</td>
	</tr>

END;

$FORMS['reflection_field_relation_option'] = <<<END
	<option value="%id%">%name%</option>
END;


$FORMS['reflection_field_relation_option_a'] = <<<END
	<option value="%id%" selected="selected">%name%</option>
END;


$FORMS['reflection_field_multiple_relation'] = <<<END
	<tr>
		<td>
			%title%%required_asteriks%:
		</td>

		<td>
			<select name="%input_name%" class="textinputs" multiple>
				<option />
				%options%
			</select>
		</td>
	</tr>

END;

$FORMS['reflection_field_multiple_relation_option'] = <<<END
	<option value="%id%">%name%</option>
END;


$FORMS['reflection_field_multiple_relation_option_a'] = <<<END
	<option value="%id%" selected="selected">%name%</option>
END;

$FORMS['reflection_field_img_file'] = <<<END

	<tr>
		<td>
			%title%%required_asteriks%:
		</td>

		<td>
			<input type="file" name="%input_name%" class="textinputs" style="height: 20px" />
			%data getPropertyOfObject(%object_id%, '%name%', 'avatar')%
		</td>
	</tr>


END;

?>