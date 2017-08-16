<?php

$FORMS = Array();

$FORMS['img_file'] = <<<END
	<a href="%src%" target="_blank">%system makeThumbnail(%filepath%, 200, 'auto', 'view')%</a>
END;


?>