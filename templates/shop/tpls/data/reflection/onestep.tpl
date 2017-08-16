<?php
 
$FORMS = Array();
 
$FORMS['reflection_block'] = <<<END
%groups%
END;
 
$FORMS['reflection_group'] = <<<END
    <tr>
        <td colspan="2">
            <div class="gropu_field_title">%title%</div>
        </td>
    </tr>
    %fields%
END;
 
 
$FORMS['reflection_field_string'] = <<<END
    <tr id="%name%_fld_row">
        <td class="order_fld_label">
            %title%<span class="required_asteriks"></span>:
        </td>
        <td>
            <input type="text" name="%input_name%" value="%value%" class="textinputs new_adress_input_fld" />
        </td>
    </tr>
END;
 
 
$FORMS['reflection_field_text'] = <<<END
	<tr id="%name%_fld_row">
		<td class="order_fld_label">
			%title%<span class="required_asteriks">:
		</td>
		<td>
			<textarea name="%input_name%" class="textinputs">%value%</textarea>
		</td>
	</tr>
END;
 
$FORMS['reflection_field_int'] = <<<END
	<tr id="%name%_fld_row">
		<td class="order_fld_label">
			%title%<span class="required_asteriks">:
		</td>
		<td>
			<input type="text" name="%input_name%" value="%value%" class="textinputs" />
		</td>
	</tr>
END;
 
$FORMS['reflection_field_relation'] = <<<END
	<tr >
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
 
?>