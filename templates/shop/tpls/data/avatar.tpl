<?php

$FORMS = Array();

$FORMS['img_file'] = <<<END
<!--	<img src="%src%" width="%width%" height="%height%" alt="" border="0" />-->
	%system makeThumbnail(%filepath%, 57, 57, 'avatar')% 
END;


?>