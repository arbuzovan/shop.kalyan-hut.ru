<?php
$FORMS = array();
	
$FORMS['price_block'] = <<<END
%price-original%
%price-actual%
END;

$FORMS['price_original'] = <<<END
<strike>%prefix% %original% %suffix%</strike>

END;

$FORMS['price_actual'] = <<<END
%prefix% <span umi:element-id="%id%" umi:field-name="price" style="font-size: 20px;" itemprop="offers" itemscope itemtype="http://schema.org/Offer"><b itemprop="price">%actual%</b><meta itemprop="priceCurrency" content="RUB"></span> %suffix%

END;
?>