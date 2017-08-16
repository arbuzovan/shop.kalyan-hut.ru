<?php

$FORMS = Array();

$FORMS['view_block_empty'] = <<<END

END;

$FORMS['view_block'] = <<<END
<div style="min-height:300px; height: 350px;" class="item" umi:element-id="%id%" itemprop="itemListElement" itemscope itemtype="http://schema.org/Product">
	%data getProperty(%id%, 'new_good', 'new_good')%
	<div class="item_a" style="vertical-align:top;" umi:element-id="%id%" umi:field-name="photo">
		<a href="//%domain%%link%">%data getProperty(%id%, 'photo', 'preview_image')%</a>
	</div>
	<div style="clear: both; margin-top: 10px; padding-bottom: 10px;">
		%emarket showPrice(%id%)%<br />
		<a itemprop="url" href="//%domain%%link%" umi:element-id="%id%" umi:field-name="name" class="title"><span itemprop="name">%name%</span></a><br />
		<div style="margin-top: 6px;">
		%emarket basketSmallAddLink(%id%)%
		</div>
	</div>
</div>

END;

?>
