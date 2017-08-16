<?php

$FORMS = Array();

$FORMS['groups_block'] = <<<END

	%lines%

END;

$FORMS['groups_line'] = <<<END
	%data getPropertyGroup('%id%', '%group_id%', '%template%')%
END;


$FORMS['group'] = <<<END
    <table style="width: 450px">
        %lines%
    </table>
END;

$FORMS['group_line'] = <<<END
    <tr>%prop%</tr>
END;



$FORMS['int'] = <<<END

[Int], %title%(%name%): %value%

END;

$FORMS['price'] = <<<END

[Price], %title%(%name%): %value%

END;


$FORMS['string'] = <<<END
<td valign="top" style="font-weight: bold; vertical-align: top; width: 170px; text-align: right; padding-right: 7px;">%title%: </td><td>%value%</td>

END;

$FORMS['text'] = <<<END
END;


$FORMS['relation'] = <<<END
<td valign="top" style="font-weight: bold; vertical-align: top; width: 170px; text-align: right; padding-right: 7px;">%title%: </td><td>%value%</td>
END;

$FORMS['file'] = <<<END
END;

$FORMS['img_file'] = <<<END
[Image File], %title%(%name%)<br />
Filename: %filename%;<br />
Filepath: %filepath%;<br />
Filepath: %src%;<br />
Size: %size%<br />
Extension: %ext%
%width% %height%
<img src="%src%" width="%width%" height="%height%" />
END;

$FORMS['swf_file'] = <<<END
END;

$FORMS['video_file'] = <<<END
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
<td style="font-weight: bold; vertical-align: top; width: 170px; text-align: right; padding-right: 7px;">%title%: </td>
<td>%items%</td>
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

/*%value%(%object_id%)%quant%*/
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

$FORMS['symlink_block_empty'] = <<<END

END;

$FORMS['symlink_block'] = <<<END
<div class="r8" style="color: #e7411d; font-size: 16px; font-weight: bold; margin-bottom: 7px; margin-top: 10px; ">Рекомендуем так же приобрести:</div>
<ul class="recomendation_item">%items%</ul>
END;

$FORMS['symlink_item'] = <<<END
<li>
    <div style="float: left; margin-right: 15px;">
        %custom makeThumbnail1(%photo%,'80','80', 'test', 0, false, %h1%)%
    </div>
    <div class="recommendedItemName">
        <a href="%link%" target="_blank" style="text-decoration: none;">%value%</a>
    </div>
    <div style="margin-top: 7px;">%data getProperty(%id%,'price')%</div>
    <a href="/emarket/basket/put/element/%id%/" rel="%id%" class="smallBuyBtnOrange" >Купить</a>
    <div class="clear"></div>
</li>
END;


$FORMS['symlink_quant'] = <<<END
, 
END;


$FORMS['date'] = <<<END

%title%: %value%

END;

$FORMS['optioned_block'] = <<<END

END;

$FORMS['optioned_block_empty'] = <<<END

END;

$FORMS['optioned_item'] = <<<END

END;

?>