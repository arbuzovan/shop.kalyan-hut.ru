<?php

$FORMS = array();

$FORMS['customer_user'] = <<<END
%fname% %lname%  (%email%)
END;

$FORMS['customer_guest'] = <<<END
<!--%fname% %lname% (%email%, %phone%)-->
END;

?>