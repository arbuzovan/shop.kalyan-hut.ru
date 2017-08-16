<?php

$FORMS['customer_user'] = <<<END
<h2>Информация о покупателе</h2>
<ul style="list-style: none outside none; text-decoration: none; margin-left: 0px; padding-left: 0px;">
    <li style="margin-left: 0px;">
        <span>Имя: &nbsp;</span>%fname%
    </li>
    <li style="margin-left: 0px;">
        <span>Фамилия: &nbsp;</span>%lname%
    </li>
    <li style="margin-left: 0px;">
        <span>E-mail: &nbsp;</span>%e-mail%
    </li>
    <li style="margin-left: 0px;">
        <span>Телефон: &nbsp;</span>%telefon%
    </li>
</ul>
END;

$FORMS['customer_guest'] = <<<END
<h2>Информация о покупателе</h2>
<ul style="list-style: none outside none; text-decoration: none; margin-left: 0px; padding-left: 0px;">
    <li style="margin-left: 0px;">
        <span>Имя: &nbsp;</span>%fname%
    </li>
    <li style="margin-left: 0px;">
        <span>Фамилия: &nbsp;</span>%lname2%
    </li>
    <li style="margin-left: 0px;">
        <span>E-mail: &nbsp;</span>%e-mail%
    </li>
    <li style="margin-left: 0px;">
        <span>Телефон: &nbsp;</span>%phone%
    </li>
</ul>
END;
?>