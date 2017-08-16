<?php

$FORMS = Array();

$FORMS['category'] = <<<END

				<div id="shop" class="block">

					%catalog getCategoryList('home', '%category_id%')%

					<div class="third-column">
						<a href="//%domain%%link%" class="go">Перейти в Каталог</a>
						<h2>Лучший выбор</h2>
						%catalog getObjectsList('home', '/market/hamsters/', 2)%
					</div>
					<!-- dont kill this hack!!! -->
					<div style="clear:both"></div>

				</div>

	
END;


$FORMS['category_block'] = <<<END

					<div class="second-column">
						<h2>%h1%</h2>
						<ul>
							%lines%
						</ul>
					</div>

END;


$FORMS['category_block_empty'] = <<<END

END;


$FORMS['category_block_line'] = <<<END
					<li><a href="//%domain%%link%">%text%</a></li>

END;



$FORMS['objects_block'] = <<<END
%lines%
END;


$FORMS['objects_block_line'] = <<<END
%catalog viewObject(%id%, 'home')%

END;


$FORMS['objects_block_empty'] = '';


$FORMS['view_block'] = <<<END
					<div class="item">

						<table border="0">
							<tr>
								<td style="vertical-align:top;" umi:element-id="%id%" umi:field-name="photo">
									%data getProperty(%id%, 'photo', 'preview_image_home')%
								</td>
								<td style="padding-left: 8px; vertical-align:top;">
									<a href="//%domain%%link%" class="title" umi:element-id="%id%" umi:field-name="name">%name%</a>
									%data getProperty(%id%, 'price', 'catalog_preview')%
									%data getPropertyGroup(%id%, 'short_info', 'catalog_preview')%
								</td>
							</tr>
						</table>

						%emarket basketAddLink(%id%)% 
					</div>

END;

?>