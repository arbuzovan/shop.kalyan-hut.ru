<?php

$FORMS = Array();


$FORMS['search_block'] = <<<END
<div id="search_block">
    <form method="get" action="%content get_page_url(%category_id%)%">
        <fieldset> 
            <legend>Фильтр по товарам</legend>
            <a name="filter_wrapper"></a>
            <ul class="filter_list">
                %lines%
            </ul>
            <div class="clear"></div>
        </fieldset>
        <p>
            <input type="submit" class="smallBuyBtnFilter" style="font-size: 14px; width: 95px;" value="Подобрать" />
            &nbsp;&nbsp;&nbsp;
            <input class="smallBuyBtnFilter" style="font-size: 14px; width: 95px;" type="button" onclick="javascript: window.location = '%content get_page_url(%category_id%)%';" value="Сбросить" />
        </p>
    </form>
</div>
END;


$FORMS['search_block_line'] = <<<END
    <li>
        %selector%
    </li>
END;

$FORMS['search_block_line_relation'] = <<<END
<div class="hat">%title%</div>
<div>
    <select id="%name%_fld" name="fields_filter[%name%]" class="textinputs">
        <option />%items%
    </select>
</div>
END;

$FORMS['search_block_line_symlink'] = <<<END
<div class="hat">%title%</div>
<div>
    <select id="%name%_fld" name="fields_filter[%name%]" class="textinputs">
        <option />%items%
    </select>
</div>
END;


$FORMS['search_block_line_text'] = <<<END
<div class="hat">%title%</div>
<div>
    <input type="text" id="%name%_fld" name="fields_filter[%name%]" class="textinputs" value="%value%" />
</div>
END;

$FORMS['search_block_line_price'] = <<<END
<div class="hat">%title%</div>
<div>
    от &nbsp;<input type="text" id="%name%_from_fld" name="fields_filter[%name%][0]" class="textinputs" value="%value_from%" size="12" />
    до &nbsp;<input type="text" id="%name%_to_fld" name="fields_filter[%name%][1]" class="textinputs" value="%value_to%" size="12" />
</div>
<div class="clear"></div>
END;

$FORMS['search_block_line_boolean'] = <<<END
<div class="hat">
    <label for="fields_filter[%name%]">%title%</label>
</div>
<div>
    <input id="%name%_fld" type="checkbox" name="fields_filter[%name%]" id="fields_filter[%name%]" %checked% value="1" /> 
</div>

END;
?>