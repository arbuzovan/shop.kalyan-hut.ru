<?php

$FORMS = Array();

$FORMS['groups_block'] = <<<END

	<div style="border: #F00 1px solid;">
		%lines%
	</div>

END;

$FORMS['groups_line'] = <<<END
    %data getPropertyGroup('%id%', '%group_id%', '%template%')%
END;


$FORMS['group'] = <<<END

	<table border="0" padding="5" width="99%">
		%lines%
	</table>

END;

$FORMS['group_line'] = <<<END

%data getProperty('%id%', '%prop_id%', '%template%')%

END;

$FORMS['int'] = $FORMS['string'] = $FORMS['text'] = <<<END

<tr>

	<td style="width: 50%; color: #000; font-size: 10px;">
		%title%:
	</td>

	<td style="color: #000; font-size: 10px;">
		%value%
	</td>
</tr>

<tr>
	<td colspan="2"><div class="spacerProps"></div></td>
</tr>

END;

$FORMS['relation'] = <<<END

<tr>

	<td style="width: 50%; color: #000; font-size: 10px;">
		%title%:
	</td>

	<td style="color: #000; font-size: 10px;">
		%value%
	</td>
</tr>

<tr>
	<td colspan="2"><div class="spacerProps"></div></td>
</tr>

END;

$FORMS['file'] = <<<END
END;

$FORMS['img_file'] = <<<END
<a href="%src%" target="_blank" class="gallery">
	%custom makeThumbnail(%filepath%, 200, 300, , , , %h1%)%
</a>
END;

$FORMS['swf_file'] = <<<END
END;

$FORMS['date'] = <<<END
END;

$FORMS['boolean_yes'] = <<<END
[Boolean], %title%(%name%): Да
END;

$FORMS['boolean_no'] = <<<END
[Boolean], %title%(%name%): Нет
END;


$FORMS['wysiwyg'] = <<<END
END;



/* Multiple property blocks */

$FORMS['int_mul_block'] = <<<END

[Int multiple], %title%: %items%

END;

$FORMS['string_mul_block'] = <<<END

[String multiple], %title%: %items%

END;

$FORMS['text_mul_block'] = <<<END
END;

$FORMS['relation_mul_block'] = <<<END


<tr>

	<td style="width: 50%; color: #000; font-size: 10px;">
		%title%:
	</td>

	<td style="color: #000; font-size: 10px;">
		%items%
	</td>
</tr>

<tr>
	<td colspan="2"><div class="spacerProps"></div></td>
</tr>

END;

$FORMS['file_mul_block'] = <<<END
END;

$FORMS['img_file_mul_block'] = <<<END
END;

$FORMS['swf_file_mul_block'] = <<<END
END;

$FORMS['date_mul_block'] = <<<END
END;

$FORMS['boolean_mul_block'] = <<<END
END;

$FORMS['wysiwyg_mul_block'] = <<<END
END;


/* Multiple property item */

$FORMS['int_mul_item'] = <<<END
%value%%quant%
END;

$FORMS['string_mul_item'] = <<<END
%value%%quant%
END;

$FORMS['text_mul_item'] = <<<END
END;

$FORMS['relation_mul_item'] = <<<END
%value%%quant%
END;

$FORMS['file_mul_item'] = <<<END
END;

$FORMS['img_file_mul_item'] = <<<END
END;

$FORMS['swf_file_mul_item'] = <<<END
END;

$FORMS['date_mul_item'] = <<<END
END;

$FORMS['boolean_mul_item'] = <<<END
END;

$FORMS['wysiwyg_mul_item'] = <<<END
END;


/* Multiple property quant */

$FORMS['int_mul_quant'] = <<<END
, 
END;

$FORMS['string_mul_quant'] = <<<END
, 
END;

$FORMS['text_mul_quant'] = <<<END
END;

$FORMS['relation_mul_quant'] = <<<END
, 
END;

$FORMS['file_mul_quant'] = <<<END
END;

$FORMS['img_file_mul_quant'] = <<<END
END;

$FORMS['swf_file_mul_quant'] = <<<END
END;

$FORMS['date_mul_quant'] = <<<END
END;

$FORMS['boolean_mul_quant'] = <<<END
END;

$FORMS['wysiwyg_mul_quant'] = <<<END
END;



$FORMS['symlink_block'] = <<<END
[Symlink multiple], %title%: %items%
END;

$FORMS['symlink_item'] = <<<END
<a href="%link%">%value%(%id%, %object_id%)</a>%quant%
END;


$FORMS['symlink_quant'] = <<<END
, 
END;


?>