<?php

$FORMS = Array();

$FORMS['error_no_form'] = '<b>Форма не определена</b><br />Обратитесь к администрации ресурса';

$FORMS['send_successed'] = 'Ваше сообщение отправлено';

$FORMS['form_block'] = <<<END
<form id="dispatches_form" enctype="multipart/form-data" method="post">
	%groups%
</form>
END;

$FORMS['address_select_block']  = <<<END
<table style="width: 500px !important;">
    <tr>
        <td style="width:100%;">
            Получатель
        </td>

        <td>
            <select name="system_email_to" style="width: 300px">
                %options%
            </select>
        </td>
    </tr>
</table>
END;

$FORMS['address_select_block_line']  = <<<END
	<option value="%id%">%text%</option>
END;

$FORMS['address_separate_block']  = <<<END
<b>Выберите адреса из списка</b><br />
%lines%
<br />
END;

$FORMS['address_separate_block_line']  = <<<END
<input type="checkbox" id="%id%" name="system_email_to[]" value="%value%" /> <label for="%id%">%description%</label><br />
END;

$FORMS['reflection_block'] = <<<END
%groups%
%system captcha()%
<table border="0" style="width: 500px; !important">
<tr>
	<td style="text-align:right;padding-top:10px;">
		<input type="submit" value="Отправить" />
	</td>
</tr>
</table>
END;

$FORMS['reflection_group'] = <<<END
<table border="0" style="width: 500px; !important">
	%fields%
</table>
END;

$FORMS['reflection_group_address'] = <<<END
<table border="0" width="500">
    <tr>
        <td>
            Получатель
        </td>

        <td>
            <select name="system_email_to" style="width:300px;">
                %options%
            </select>
        </td>
    </tr>
</table>


END;


$FORMS['reflection_field_string'] = <<<END
	<tr>
		<td style="width:100%;">
			%title%&nbsp;<span>%required_asteriks%<span>:
		</td>

		<td>
			<input type="text" name="%name%" id="%name%" value="%value%" size="50"  style="width:300px;" />
		</td>
	</tr>

END;

$FORMS['reflection_field_password'] = <<<END

	<tr>
		<td>
			%title%:
		</td>

		<td>
			<input type="password" name="%input_name%" value="" size="50" />
		</td>
	</tr>
END;

$FORMS['reflection_field_int'] = <<<END

	<tr>
		<td style="width:100%;">
			%title%:
		</td>

		<td>
			<input type="text" name="%input_name%" value="%value%" size="15" />
		</td>
	</tr>

END;


$FORMS['reflection_field_text'] = <<<END

	<tr>
		<td style="width:100%;">
			%title%:
		</td>

		<td>
			<textarea name="%input_name%" style="width:300px;">%value%</textarea>
		</td>
	</tr>

END;

$FORMS['reflection_field_wysiwyg'] = <<<END

	<tr>
		<td style="width:100%;">
			%title%:
		</td>

		<td>
			<textarea name="%input_name%" style="width:300px">%value%</textarea>
		</td>
	</tr>

END;

$FORMS['reflection_field_boolean'] = <<<END

	<tr>
		<td style="width:100%;">
			%title%:
		</td>

		<td>
			<input type="hidden" id="%input_name%" name="%input_name%" value="%value%" />
			<input onclick="javascript:document.getElementById('%input_name%').value = this.checked;" type="checkbox" %checked% value="1" />
		</td>
	</tr>

END;

$FORMS['reflection_field_file'] = <<<END

	<tr>
		<td style="width:100%;">
			%title%:
		</td>

		<td>
			Максимальный размер файла: %maxsize% МБ <br>
            <input type="file" name="%input_name%" style="width:300px;" />
		</td>
	</tr>
END;

$FORMS['reflection_field_img_file'] = <<<END

	<tr>
		<td style="width:100%;">
			%title%:
		</td>

		<td>
			Максимальный размер файла: %maxsize% МБ <br>
            <input type="file" name="%input_name%" style="width:300px;" />
		</td>
	</tr>
END;


$FORMS['reflection_field_relation'] = <<<END
    <tr>
        <td style="width:100%;">
            %title%:
        </td>

        <td>
            <select name="%input_name%" style="width: 205px" class="textinputs" style="width:300px;">
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
        <td style="width:100%;">
            %title%:
        </td>

        <td>
            <select name="%input_name%" multiple style="width:300px;">
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

?>