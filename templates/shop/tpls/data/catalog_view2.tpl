<?php

$FORMS = Array();

$FORMS['img_file'] = <<<END
	%system makeThumbnail(%filepath%, 600, 'auto', 'catalog_view')%
END;


?>