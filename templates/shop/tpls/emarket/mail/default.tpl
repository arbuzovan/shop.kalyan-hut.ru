<?php
$FORMS = Array();

/* Это идет на почту клиенту */
$FORMS['status_notification'] = <<<END

	<div id="template_preview">
		<table class="preview" border="0" cellspacing="0" cellpadding="0" width="100%" bgcolor="#edba53">
			<tbody>
				<tr>
				<td align="center" valign="top">
					<table class="campaign" border="0" cellspacing="0" cellpadding="0" width="560">
						<tbody>
							<tr>
								<td class="campaign" style="padding-right: 5px; font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: #ffffff;" width="560" align="right" valign="middle">
									<br />
								</td>
							</tr>
							<tr>
								<td class="campaign" width="560" height="10">&nbsp;</td>
							</tr>
						</tbody>
					</table>
					<table class="campaign" style="border: 5px solid #ffffff;" border="0" cellspacing="0" cellpadding="0" width="560" bgcolor="#ffffff">
						<tbody>
							<tr>
							<td width="560" align="center">
								<table border="0" cellspacing="0" cellpadding="0" width="560">
									<tbody>
										<tr>
											<td class="headerimage" width="560" align="center">
												<a style="border: none;" href="//shop.kalyan-hut.ru/">
													<img style="height: 175px; width: 560px; border: 0px;" src="//shop.kalyan-hut.ru/files/shapka_kal_yan_im.jpg" alt="" width="560" height="175" />
												</a>
											</td>
										</tr>
									</tbody>
								</table>
								<table class="headcontent" border="0" cellspacing="0" cellpadding="0" width="560">
									<tbody>
										<tr>
											<td class="headcontent" width="560" height="20">&nbsp;</td>
										</tr>
									</tbody>
								</table>
								<table class="table" border="0" cellspacing="0" cellpadding="0" width="520">
									<tbody>
									<tr>
										<td class="cell" style="color: #993300; font-family: Arial, Helvetica, sans-serif; line-height: 28px; font-size: 22px; font-weight: bold;" width="520" align="center">Ваш заказ №%order_number% принят и поступил в обработку</td>
									</tr>
									<tr>
										<td class="cell" width="520" height="14">&nbsp;</td>
									</tr>
									</tbody>
								</table>
								<table class="table" border="0" cellspacing="0" cellpadding="0" width="520">
								<tbody>
									<tr>
										<td class="cell" style="color: #000000; font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif; line-height: 22px; font-size: 16px; font-weight: bold;" width="520" align="center">
											Здравствуйте уважаемый Клиент! Мы уже занимаемся Вашим заказом, в скором времени с Вами свяжется менеджер.
										</td>
									</tr>
									<tr>
										<td class="cell" width="520" height="13">&nbsp;</td>
									</tr>
								</tbody>
								</table>
								<table class="table" border="0" cellspacing="0" cellpadding="0" width="520">
									<tbody>
										<tr>
										<td class="cell" style="border-top-width: 1px; border-color: #e2d9d2; border-top-style: solid;" width="520">
											<table class="table" border="0" cellspacing="0" cellpadding="0" width="520">
												<tbody>
													<tr>
														<td class="row" width="520" height="20">&nbsp;</td>
													</tr>
												</tbody>
											</table>
										</td>
										</tr>
									</tbody>
								</table>
								<table class="table" border="0" cellspacing="0" cellpadding="0" width="520">
									<tbody>
										<tr>
											<td class="cell" style="color: #333333; font-family: Arial, Helvetica, sans-serif; line-height: 18px; font-size: 12px;" width="520" align="left" valign="top">
												%emarket order(%order_id%, 'mail_form')%
											</td>
										</tr>
										<tr>
											<td class="spacer" width="520" height="10">&nbsp;</td>
										</tr>
									</tbody>
								</table>
								<table class="table" border="0" cellspacing="0" cellpadding="0" width="520">
								<tbody>
								<tr>
								<td class="cell" style="border-top-width: 1px; border-color: #e2d9d2; border-top-style: solid;" width="520">
								<table class="table" border="0" cellspacing="0" cellpadding="0" width="520">
								<tbody>
								<tr>
								<td class="row" width="520" height="20">&nbsp;</td>
								</tr>
								</tbody>
								</table>
								</td>
								</tr>
								</tbody>
								</table>
								<table class="table" border="0" cellspacing="0" cellpadding="0" width="520">
								<tbody>
								<tr>
								<td class="text499322" style="color: #333333; font-family: Arial, Helvetica, sans-serif; line-height: 18px; font-size: 12px;" align="left" valign="top"><img class="image499322" style="width: 213px; height: 133px; padding-bottom: 10px; padding-right: 20px; float: left; border: 0px;" src="//shop.kalyan-hut.ru/files/otdel_prodazh.jpg" alt="" width="213" height="133" />
								<p style="margin: 0px 0px 10px 0px; text-align: center; margin-bottom: 10px;">С уважением,</p>
								<p style="text-align: center; margin-bottom: 10px;"><strong>Отдел продаж интернет-магазина Кальян-Хат</strong></p>
								<p style="text-align: center; margin-bottom: 10px;">+7 (495) 210 17 79</p>
								<p style="text-align: center; margin-bottom: 10px;">info@kalyan-hut.ru</p>
								<p style="text-align: center; margin-bottom: 10px;"><a class="text_link" href="//shop.kalyan-hut.ru/contacts/">г. Москва, ул. Нижняя Первомайская, д. 45</a></p>
								</td>
								</tr>
								</tbody>
								</table>
								<br />
							</td>
							</tr>
						</tbody>
					</table>
					<br />
				</td>
				</tr>
			</tbody>
		</table>
	</div>
END;

$FORMS['status_notification_receipt'] = <<<END
	Спасибо за покупку, номер вашего  заказа: %order_number%
	<br/><br/>
	%emarket order(%order_id%, 'mail_form')%
	<br/><br/>
END;

$FORMS['neworder_notification'] = <<<END
	Спасибо за покупку, номер вашего  заказа: %order_number%
	<br/><br/>
	%emarket order(%order_id%, 'mail_form')%
	<br/><br/>
END;
?>