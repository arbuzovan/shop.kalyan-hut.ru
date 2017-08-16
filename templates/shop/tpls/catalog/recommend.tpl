<?php

$FORMS = Array();



$FORMS['view_block'] = <<<END
    <div style="float: left; margin: 2px;">
            <p><b><a href="//%domain%%link%" class="title" umi:element-id="%id%" umi:field-name="name">%name%</a></b></p>
            <div style="margin: 3px;">
                    %data getProperty(%id%, 'photo', 'preview_image_home')%
            </div>
            <div>
                    <p><b>Цена: %emarket price('%id%', 'short')%</b></p>
                    %emarket basketAddLink(%id%)%
            </div>

    </div>

END;

?>