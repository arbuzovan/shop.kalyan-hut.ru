<?php

$FORMS = Array();

$FORMS['groups_block'] = <<<END
%lines%
END;

$FORMS['groups_line'] = <<<END
%data getPropertyGroupOfObject('%id%', '%group_id%', '%template%')%
END;

$FORMS['group'] = <<<END
%lines%
END;

$FORMS['group_line'] = <<<END
%prop%, 
END;

$FORMS['int'] = <<<END
%value%
END;

$FORMS['int_empty'] = <<<END
END;

$FORMS['string'] = <<<END
%value%
END;

$FORMS['string_empty'] = <<<END
END;

$FORMS['text'] = <<<END
%value%
END;

$FORMS['relation'] = <<<END
%value%
END;

$FORMS['relation_empty'] = <<<END
END;

$FORMS['date'] = <<<END
%value%
END;

$FORMS['boolean_yes'] = <<<END
Да
END;

$FORMS['boolean_no'] = <<<END
Нет
END;

$FORMS['wysiwyg'] = <<<END
%value%
END;

$FORMS['relation_mul_block'] = <<<END
%items%
END;

$FORMS['relation_mul_item'] = <<<END
%value%%quant%
END;
$FORMS['relation_mul_quant'] = <<<END
, 
END;

$FORMS['symlink_block'] = <<<END
%title%: %items%
END;

$FORMS['symlink_item'] = <<<END
<a href="%link%">%value%(</a>%quant%
END;

$FORMS['symlink_quant'] = <<<END
, 
END;

$FORMS['prop_unknown'] = <<<END

END;

?>