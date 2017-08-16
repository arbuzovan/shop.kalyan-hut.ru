<?php

$FORMS = Array();

$FORMS['elements_block'] = <<<END
<p>Найдено %total%  страниц</p>
<br />
	%items%
END;

$FORMS['elements_block_line'] = <<<END
    %catalog viewObject(%id%, 'preview')%
END;

$FORMS['elements_block_empty'] = <<<END
<p>Ничего не найдено. Попробуйте изменить критерии поиска</p>
END;

$FORMS['separator'] = <<<END
|
END;

$FORMS['separator_last'] = <<<END
!
END;
?>