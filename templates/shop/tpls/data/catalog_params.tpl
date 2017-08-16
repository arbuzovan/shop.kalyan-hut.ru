<?php

$FORMS = Array();


$FORMS['group'] = <<<END

<p>
	<table border="0" padding="5">
		%lines%
	</table>
</p>

END;


$FORMS['group_line'] = <<<END

%data getProperty('%id%', '%prop_id%', '%template%')%

END;




$FORMS['wysiwyg'] = $FORMS['float'] = $FORMS['relation'] = $FORMS['int'] = $FORMS['string'] = $FORMS['text'] = <<<END

<tr>
        
	<td width="150">
		%title%:
	</td>

	<td umi:element-id="%id%" umi:field-name="%name%">
		<span style="color: #DC9B36" umi:element-id="%id%" umi:field-name="%name%">%value%</span>
	</td>
</tr>

<tr>
	<td colspan="2"><div class="spacerProps"></div></td>
</tr>

END;

$FORMS['string_empty'] = <<<END
<!--tr>
        <td>&nbsp;</td>
	<td umi:element-id="%id%" umi:field-name="%name%" umi:method="catalog" umi:empty="Задайте значение для поля">
        %value%
	</td>
</tr-->
END;

$FORMS['file'] = <<<END
END;

$FORMS['img_file'] = <<<END
<img src="%src%" width="%width%" height="%height%" />
END;

$FORMS['swf_file'] = <<<END
END;

$FORMS['date'] = <<<END
END;

$FORMS['boolean_yes'] = <<<END
[Boolean], %title%(%name%): -р
END;

$FORMS['boolean_no'] = <<<END
[Boolean], %title%(%name%): =хЄ
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

	<td width="150">
		%title%:
	</td>

	<td>
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