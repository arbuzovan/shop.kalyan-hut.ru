<?php
$FORMS = array();


$FORMS['group'] = <<<END
<form action="%pre_lang%/emarket/basket/put/element/%id%/" method="get">
	<ol>
		%lines%
	</ol>
	<p>
		<input type="submit" value="Положить в корзину" />
	</p>
</form>
END;

$FORMS['group_line'] = <<<END
    <li>
    	%prop%
    </li>
END;

$FORMS['optioned_block'] = <<<END
<strong>%title%</strong>
<ul>
	%items%
</ul>
END;

$FORMS['optioned_block_empty'] = <<<END
<strong>%title%</strong> - Нет опций
END;

$FORMS['optioned_item'] = <<<END
<li>
	<label>
		<input type="radio" name="options[%field_name%]" value="%object-id%" />
		%object-name% %emarket applyPriceCurrency(%float%, 'short')%
	</label>
</li>
END;

?>