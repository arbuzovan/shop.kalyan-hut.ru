<?php

$FORMS = Array();

$FORMS['img_file'] = <<<END
	<!--%system makeThumbnail(%filepath%, 119, 161, 'view')%-->
	<!--%custom makeThumbnail(%filepath%, 120, 160)%-->
    %system makeThumbnail(%filepath%, 120, 160, 'view_island')%
END;

