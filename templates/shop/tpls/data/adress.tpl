<?php
$FORMS = Array();

$FORMS['groups_block'] = <<<END
<h2>Адрес доставки:</h2>
<ul style="list-style: none outside none; text-decoration: none; margin-left: 0px; padding-left: 0px;">
    %lines%
</ul>
END;

$FORMS['groups_line'] = <<<END
<li style="margin-left: 0px;">
    %data getPropertyGroup('%id%', '%group_id%', '%template%')%
</li>
END;


$FORMS['group'] = <<<END
<h2>Адрес доставки:</h2>
<ul style="list-style: none outside none; text-decoration: none; margin-left: 0px; padding-left: 0px;">
    %lines%
</ul>
END;

$FORMS['group_line'] = <<<END
<li style="margin-left: 0px;">
    %prop%
</li>
END;



$FORMS['int'] = <<<END
%title% : %value%

END;

$FORMS['price'] = <<<END
%title% : %value%

END;


$FORMS['string'] = <<<END
%title% : %value%

END;

$FORMS['text'] = <<<END
%title% : %value%

END;


$FORMS['relation'] = <<<END
%title% : %value%

END;

$FORMS['file'] = <<<END
[File], %title% <br />
Filename: %filename%;<br />
Filepath: %filepath%;<br />
Filepath: %src%;<br />
Size: %size%<br />
Extension: %ext%<br />
<a href="%src%">%src%</a>
END;

$FORMS['swf_file'] = $FORMS['img_file'] = <<<END
%title% <br />
Filename: %filename%;<br />
Filepath: %filepath%;<br />
Filepath: %src%;<br />
Size: %size%<br />
Extension: %ext%<br />
%width% %height%<br />
<img src="%src%" width="%width%" height="%height%" />

END;

$FORMS['date'] = <<<END
%title% : %value%

END;

$FORMS['boolean_yes'] = <<<END
%title% : Да
END;

$FORMS['boolean_no'] = <<<END
%title% : Нет
END;


$FORMS['wysiwyg'] = <<<END
%title% : %value%

END;


/* Multiple property blocks */

$FORMS['relation_mul_block'] = <<<END
%title%: %items%
END;

/* Multiple property item */

$FORMS['relation_mul_item'] = <<<END
%value% %quant%
END;

/* Multiple property quant */
$FORMS['symlink_block'] = <<<END
%title%: %items%
END;

$FORMS['symlink_item'] = <<<END
<a href="%link%">%value%</a>%quant%
END;

$FORMS['symlink_quant'] = <<<END
, 
END;


$FORMS['guide_block'] = <<<END
<select name="guide_%guide_id%">
%items%
</select>
END;

$FORMS['guide_block_empty'] = <<<END

END;

$FORMS['guide_block_line'] = <<<END
<option value="%id%">%text%</option>
END;


?>