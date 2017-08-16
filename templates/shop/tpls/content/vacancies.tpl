<?php

$FORMS = Array();

$FORMS['vacancies'] = <<<END
<style>
    .vacancy_short_wrapper{
        background: #fce2c1 none repeat scroll 0 0;
        padding: 12px 10px;
        border-radius: 3px;
    }
    .vacancy_short_wrapper ul{
        padding: 0;
    }
    .vacancy_short_wrapper ul li{
        float: left;
        width: 30%;
        padding: 0;
        margin: 0;
    }
    
    .vacancy_short_wrapper ul li div:first-child{
        font-weight: bold;
    }
    
    .vacancy_short_wrapper ul li:last-child{
        margin-left: 10px;
    }
    
    .vac_param_caption{
        font-weight: bold;
    }
        
.vac_duties, .vac_demands, .vac_conditions{
    margin-top: 10px;
}

.vacancy_reply, .vacReplySnd {
    -moz-box-shadow:inset 0px 1px 0px 0px #fce2c1;
    -webkit-box-shadow:inset 0px 1px 0px 0px #fce2c1;
    box-shadow:inset 0px 1px 0px 0px #fce2c1;
    background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ffc477), color-stop(1, #fb9e25) );
    background:-moz-linear-gradient( center top, #ffc477 5%, #fb9e25 100% );
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffc477', endColorstr='#fb9e25');
    background-color:#ffc477;
    -webkit-border-top-left-radius:4px;
    -moz-border-radius-topleft:4px;
    border-top-left-radius:4px;
    -webkit-border-top-right-radius:4px;
    -moz-border-radius-topright:4px;
    border-top-right-radius:4px;
    -webkit-border-bottom-right-radius:4px;
    -moz-border-radius-bottomright:4px;
    border-bottom-right-radius:4px;
    -webkit-border-bottom-left-radius:4px;
    -moz-border-radius-bottomleft:4px;
    border-bottom-left-radius:4px;
    text-indent:0;
    border:1px solid #eeb44f;
    display:inline-block;
    color:#ffffff;
    font-family:Arial;
    font-size:15px;
    font-weight:bold;
    font-style:normal;
    height:39px;
    line-height:39px;
    width:131px;
    text-decoration:none;
    text-align:center;
    text-shadow:1px 1px 0px #cc9f52;
}
.vacancy_reply:hover, .vacReplySnd:hover{
    background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #fb9e25), color-stop(1, #ffc477) );
    background:-moz-linear-gradient( center top, #fb9e25 5%, #ffc477 100% );
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#fb9e25', endColorstr='#ffc477');
    background-color:#fb9e25;
    color: white;
}
.vacancy_reply:active,  .vacReplySnd:active{
    position:relative;
    color: white;
}

.require::after {
    color: red;
    content: '*';
}

input.vacancyReplyForm, select.vacancyReplyForm{
    height: 24px;
    width: 480px;
    margin-bottom: 3px;
    padding-left: 4px;
}

textarea.vacancyReplyForm{
    min-height: 100px;
    width: 480px;
    min-width: 480px;
    margin-bottom: 3px;
    padding: 4px;
}
    
</style>
%lines%
END;

$FORMS['vacancy'] = <<<END
<h2>%name%</h2>
<div class="vacancy_short_wrapper">
    <ul>
        <li>
            <div>Уровень зарплаты</div>
            <div>%vac_salary%</div>
        </li>
        <li>
            <div>Адрес</div>
            <div>%vac_adress%</div>
        </li>
        <li>
            <div>Требуемый опыт работы</div>
            <div>%vac_experience%</div>
        </li>
    </ul>
    <div class="clear"></div>
</div>
<br>
<div class="vac_duties">
    <div class="vac_param_caption">Обязанности:</div>
    <div class="vac_param_content">%vac_duties%</div>
</div>
<div class="vac_demands">
    <div class="vac_param_caption">Требования:</div>
    <div class="vac_param_content">%vac_demands%</div>
</div>
<div class="vac_conditions">
    <div class="vac_param_caption">Условия:</div>
    <div class="vac_param_content">%vac_conditions%</div>
</div>
<a class="vacancy_reply" rel="%id%" href="#">Откликнуться</a>
END;

?>