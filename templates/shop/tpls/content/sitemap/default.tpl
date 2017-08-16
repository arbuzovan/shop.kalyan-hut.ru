<?php

$FORMS = Array();

$FORMS['block'] = <<<END
<ul umi:element-id="%block-element-id%" umi:module="content" umi:method="sitemap" umi:button-position="bottom right">
    %items%
</ul>
END;

$FORMS['item'] = <<<END
    <li style="margin-left: 10px;">
        <a href="%link%">%name%</a><br />
        %sub_items%
    </li>
END;

?>