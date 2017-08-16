<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
				xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
				xmlns:php="http://php.net/xsl"
				extension-element-prefixes="php"
				exclude-result-prefixes="xsl php">

<xsl:output method="xml" encoding="utf-8"/>

<xsl:template match="umidump[@version='2.0']">
	<xsl:variable name="date" select="php:function('date', 'Y-m-d')" />

	<КоммерческаяИнформация ВерсияСхемы="2.01" ДатаФормирования="{$date}">
		<xsl:apply-templates select="objects/object[properties/group/@name='order_props']" mode="order" />
	</КоммерческаяИнформация>


</xsl:template>

<xsl:template match="umidump">
	<error>Unknown umidump version</error>
</xsl:template>

	
<xsl:template match="object" mode="order">
	<xsl:param name="order_num" select="properties/group/property[@name='number']/value" />
         
	<xsl:param name="status_change_date" select="string(properties/group/property[@name='status_change_date']/value/@unix-timestamp)" />
	<xsl:param name="order_date" select="string(properties/group/property[@name='order_date']/value/@unix-timestamp)" />
	<xsl:param name="total_price" select="properties/group/property[@name='total_price']/value" />
	<xsl:param name="customer_id" select="properties/group/property[@name='customer_id']/value/item/@id" />
	<xsl:param name="customer_comments" select="properties/group/property[@name='comments']/value" />
	
	<xsl:param name="order_status_id" select="number(properties/group/property[@name='status_id']/value/item/@id)" />
	<xsl:param name="order_status" select="document(concat('uobject://', $order_status_id))/udata/object" />
	<xsl:param name="order_status_codename" select="string($order_status//property[@name='codename']/value)" />

	<xsl:param name="payment_date" select="string(properties/group/property[@name='payment_date']/value/@unix-timestamp)" />
	<xsl:param name="payment_document_num" select="string(properties/group/property[@name='payment_document_num']/value)" />
	
	<xsl:param name="payment_type_id" select="string(properties/group/property[@name='payment_id']/value/item/@id)" />
	<xsl:param name="payment_type" select="document(concat('uobject://', $payment_type_id))/udata/object/@name" />
	
	<xsl:param name="delivery_type_id" select="string(properties/group/property[@name='delivery_id']/value/item/@id)" />
	<xsl:param name="delivery_type" select="document(concat('uobject://', $delivery_type_id))/udata/object/@name" />
		
	<xsl:param name="payment_status_id" select="number(properties/group/property[@name='payment_status_id']/value/item/@id)" />
	<xsl:param name="payment_status_codename" select="string(document(concat('uobject://', $payment_status_id))//property[@name='codename']/value)" />
	<xsl:param name="delivery_allow_date" select="string(properties/group/property[@name='delivery_allow_date']/value/@unix-timestamp)" />
	
	<xsl:param name="discont_tip_id" select="number(properties/group/property[@name='order_discount_id']/value/item/@id)" />
	<xsl:param name="discont_tip" select="document(concat('uobject://', $discont_tip_id))/udata/object" />
	
	<xsl:param name="discont_mod_id" select="number($discont_tip/properties/group/property[@name='discount_modificator_id']/value/item/@id)" />
	<xsl:param name="discont_mod" select="document(concat('uobject://', $discont_mod_id))/udata/object" />
	<xsl:param name="discont_proc" select="number($discont_mod//property[@name='proc']/value)" />

        
        <xsl:param name="adress_id" select="properties/group/property[@name='delivery_address']/value/item/@id"/>
        
        <xsl:param name="date_of_delivery" select="document(concat('uobject://',$adress_id))/udata/object/properties/group/property[@name='data_dostavki']/value" />
        <xsl:param name="time_of_delivery" select="document(concat('uobject://',$adress_id))/udata/object/properties/group/property[@name='data_dostavki']/value" />
	<Документ>
		<Ид><xsl:value-of select="@id" /></Ид>
		<Номер><xsl:value-of select="$order_num" /></Номер>
		<Дата>
			<xsl:if test="string-length($order_date)">
				<xsl:value-of select="php:function('date', 'Y-m-d', $order_date)" />
			</xsl:if>
		</Дата>
		
		<ХозОперация>Заказ товара</ХозОперация>
		<Роль>Продавец</Роль>
		<Валюта>руб</Валюта>
		<Курс>1</Курс>
		<Сумма><xsl:value-of select="$total_price" /></Сумма>
                
                <xsl:if test="$date_of_delivery != ''">
                    <ДатаДоставки>Дата доставки: <xsl:value-of select="document(concat('uobject://',$adress_id))/udata/object/properties/group/property[@name='data_dostavki']/value" /></ДатаДоставки>
                </xsl:if>
                
                <xsl:if test="$time_of_delivery != ''">
                    <ВремяДоставки>
                        <xsl:value-of select="document(concat('uobject://',$adress_id))/udata/object/properties/group/property[@name='vremya_dostavki']/value" />
                    </ВремяДоставки>
                </xsl:if>
		<xsl:if test="string-length($order_date)">
                    <Время><xsl:value-of select="php:function('date', 'H:i:s', $order_date)" /></Время>
		</xsl:if>
                
		<Комментарии>
                    <xsl:value-of select="document(concat('uobject://',$adress_id))/udata/object/properties/group/property[@name='order_comments']/value" />
                </Комментарии>
		<xsl:if test="$customer_id">
			<Контрагенты>
                            <xsl:apply-templates select="document(concat('uobject://', $customer_id))/udata/object" mode="customer" />
			</Контрагенты>
		</xsl:if>

		<Товары>
			<xsl:apply-templates select="properties/group/property[@name='delivery_price']/value" mode="delivery"/>
			<xsl:apply-templates select="properties/group/property[@name='order_items']/value/item" mode="order-item">
				<xsl:with-param name="discont" select="$discont_proc"/>
			</xsl:apply-templates>
		</Товары>

		<ЗначенияРеквизитов>
				
			<xsl:if test="string-length($payment_date)">
				<ЗначениеРеквизита>
					<Наименование>Дата оплаты</Наименование>
					<Значение><xsl:value-of select="php:function('date', 'Y-m-d', $payment_date)" /></Значение>
				</ЗначениеРеквизита>
			</xsl:if>

			<xsl:if test="string-length($payment_document_num)">
				<ЗначениеРеквизита>
					<Наименование>Номер платежного документа</Наименование>
					<Значение><xsl:value-of select="$payment_document_num" /></Значение>
				</ЗначениеРеквизита>
			</xsl:if>

			<xsl:if test="string-length($payment_type)">
				<ЗначениеРеквизита>
					<Наименование>Метод оплаты</Наименование>
					<Значение><xsl:value-of select="$payment_type" /></Значение>
				</ЗначениеРеквизита>
			</xsl:if>
			
			<xsl:if test="string-length($delivery_type)">
				<ЗначениеРеквизита>
					<Наименование>Способ доставки</Наименование>
					<Значение><xsl:value-of select="$delivery_type" /></Значение>
				</ЗначениеРеквизита>
			</xsl:if>

			<xsl:if test="string-length($delivery_allow_date)">
				<ЗначениеРеквизита>
					<Наименование>Дата разрешения доставки</Наименование>
					<Значение><xsl:value-of select="php:function('date', 'Y-m-d', $delivery_allow_date)" /></Значение>
				</ЗначениеРеквизита>
				<ЗначениеРеквизита>
					<Наименование>Доставка разрешена</Наименование>
					<Значение>true</Значение>
				</ЗначениеРеквизита>
			</xsl:if>

			<ЗначениеРеквизита>
				<Наименование>Заказ оплачен</Наименование>
				<Значение>
					<xsl:choose>
						<xsl:when test="$payment_status_codename = 'accepted'">true</xsl:when>
						<xsl:otherwise>false</xsl:otherwise>
					</xsl:choose>
				</Значение>
			</ЗначениеРеквизита>

			<ЗначениеРеквизита>
				<Наименование>Отменен</Наименование>
				<Значение>
					<xsl:choose>
						<xsl:when test="$order_status_codename = 'canceled'">true</xsl:when>
						<xsl:otherwise>false</xsl:otherwise>
					</xsl:choose>
				</Значение>
			</ЗначениеРеквизита>

			<ЗначениеРеквизита>
				<Наименование>Финальный статус</Наименование>
				<Значение>
					<xsl:choose>
						<xsl:when test="$order_status_codename = 'ready'">true</xsl:when>
						<xsl:otherwise>false</xsl:otherwise>
					</xsl:choose>
				</Значение>
			</ЗначениеРеквизита>

			<ЗначениеРеквизита>
				<Наименование>Статус заказа</Наименование>
				<Значение><xsl:value-of select="$order_status/@name" /></Значение>
			</ЗначениеРеквизита>

			<xsl:if test="string-length($status_change_date)">
				<ЗначениеРеквизита>
					<Наименование>Дата изменения статуса</Наименование>
					<Значение><xsl:value-of select="php:function('date', 'Y-m-d H:i', $status_change_date)" /></Значение>
				</ЗначениеРеквизита>
			</xsl:if>
		</ЗначенияРеквизитов>
	</Документ>
</xsl:template>


<xsl:template match="item" mode="order-item">
	<xsl:param name="discont" select="$discont"/>
	<xsl:apply-templates select="document(concat('uobject://', @id))/udata/object" mode="order-item">
		<xsl:with-param name="discont" select="$discont"/>
	</xsl:apply-templates>
</xsl:template>

<xsl:template match="object" mode="order-item">
	<xsl:param name="good-id" select="properties/group/property[@name='item_link']/value/page/@id" />
	<xsl:param name="good" select="document(concat('upage://', $good-id))/udata/page" />
	<xsl:param name="item_price" select="properties/group/property[@name='item_price']/value" />
	<xsl:param name="item_amount" select="properties/group/property[@name='item_amount']/value" />
	<xsl:param name="item_total_price" select="properties/group/property[@name='item_total_price']/value" />
	<xsl:param name="discont" select="$discont"/>
	
	<Товар>
		<xsl:choose>
			<xsl:when test="not($good)">
				<Ид><xsl:value-of select="@id" /></Ид>
			</xsl:when>
			<xsl:when test="$good//property[@name = '1c_product_id']/value">
				<Ид><xsl:value-of select="$good//property[@name = '1c_product_id']/value" /></Ид>
			</xsl:when>
			<xsl:otherwise>
				<Ид><xsl:value-of select="$good-id" /></Ид>
			</xsl:otherwise>
		</xsl:choose>
		<xsl:if test="$good//property[@name = '1c_catalog_id']/value">
			<ИдКаталога><xsl:value-of select="$good//property[@name = '1c_catalog_id']/value" /></ИдКаталога>
		</xsl:if>

		<Наименование><xsl:value-of select="$good/name | @name" /></Наименование>
		<БазоваяЕдиница Код="796" НаименованиеПолное="Штука" МеждународноеСокращение="PCE">шт</БазоваяЕдиница>

		<ЦенаЗаЕдиницу><xsl:value-of select="$item_price" /></ЦенаЗаЕдиницу>
		<Сумма><xsl:value-of select="$item_total_price" /></Сумма>
		<Количество><xsl:value-of select="$item_amount" /></Количество>
		<Единица>шт</Единица>
		<Коэффициент>1</Коэффициент>
		<xsl:if test="$discont">
			<Скидки>
				<Скидка>
					<Процент>
						<xsl:value-of select="$discont"/>
					</Процент>
					<УчтеноВСумме>false</УчтеноВСумме>
				</Скидка>
			</Скидки>
		</xsl:if>
		
		<ЗначенияРеквизитов>
			<ЗначениеРеквизита>
			<Наименование>ВидНоменклатуры</Наименование>
			<Значение>Товар</Значение>
			</ЗначениеРеквизита>
			<ЗначениеРеквизита>
			<Наименование>ТипНоменклатуры</Наименование>
			<Значение>Товар</Значение>
			</ЗначениеРеквизита>
		</ЗначенияРеквизитов>
	</Товар>
</xsl:template>

<xsl:template match="value" mode="delivery">
	<xsl:variable name="price_delivery" select="." />
	<xsl:if test="$price_delivery &gt; 0">
		<Товар>
			<Ид>
				ORDER_DELIVERY
			</Ид>
			<Наименование>
				Доставка заказа
			</Наименование>
			<БазоваяЕдиница Код="796" НаименованиеПолное="Штука" МеждународноеСокращение="PCE">
				шт
			</БазоваяЕдиница>
			<ЦенаЗаЕдиницу>
				<xsl:value-of select="$price_delivery" />
			</ЦенаЗаЕдиницу>
			<Количество>
				1
			</Количество>
			<Сумма>
				<xsl:value-of select="$price_delivery" />
			</Сумма>
			<ЗначенияРеквизитов>
				<ЗначениеРеквизита>
					<Наименование>
						ВидНоменклатуры
					</Наименование>
					<Значение>
						Услуга
					</Значение>
				</ЗначениеРеквизита>
				<ЗначениеРеквизита>
					<Наименование>
						ТипНоменклатуры
					</Наименование>
					<Значение>
						Услуга
					</Значение>
				</ЗначениеРеквизита>
			</ЗначенияРеквизитов>
		</Товар>
	</xsl:if>
</xsl:template>

<xsl:template match="object" mode="customer">
	<xsl:variable name="delivery_id" select="//properties/group/property[@name='delivery_addresses']/value/item/@id"/>
	<xsl:variable name="phone" select="//property[@name='phone']/value"/>
	<xsl:variable name="telefon" select="//property[@name='telefon']/value"/>
	<Контрагент>
		<Ид><xsl:value-of select="@id" /></Ид>
		<Наименование>
                    <xsl:value-of select="//property[@name='fname']/value" />&#160;<xsl:value-of select="//property[@name='lname2']/value" />
                </Наименование>
		<ПолноеНаименование>
                    <xsl:value-of select="//property[@name='fname']/value" />&#160;<xsl:value-of select="//property[@name='lname2']/value" />
                </ПолноеНаименование>
		<Роль>Покупатель</Роль>
		<Фамилия>
                    <xsl:value-of select="//property[@name='lname2']/value" />
                </Фамилия>
		<Имя>
                    <xsl:value-of select="//property[@name='fname']/value" />
                </Имя>
                <Контакты>
                        <Контакт>
                                <Тип>Телефон</Тип>
                                <Значение>
                                    <xsl:if test="string-length($phone)">
                                        <xsl:value-of select="$phone" />
                                    </xsl:if>
                                    <xsl:if test="string-length($telefon)">
                                        <xsl:value-of select="$telefon" />
                                        <!--xsl:value-of select="//property[@name='phone']/value" /-->
                                    </xsl:if>
                                </Значение>
                        </Контакт>
                        <Контакт>
                                <Тип>Почта</Тип>
                                <Значение>
                                    <xsl:value-of select="//property[@name='e-mail']/value" />
                                </Значение>
                        </Контакт>
                </Контакты>
		<xsl:apply-templates select="document(concat('uobject://', $delivery_id))/udata/object" mode="current_address" />
	</Контрагент>
</xsl:template>

<xsl:template match="object" mode="current_address">
        <Адрес>
            <Представление>
                <xsl:value-of select="//property[@name='index']/value" />,&#160; г.<xsl:value-of select="//property[@name='city']/value" />,&#160;<xsl:value-of select="//property[@name='street']/value" />,&#160;д.<xsl:value-of select="//property[@name='house']/value" />,корпус.<xsl:value-of select="//property[@name='korpus']/value" />,&#160;подъезд.<xsl:value-of select="//property[@name='podezd']/value" />,&#160;домофон.<xsl:value-of select="//property[@name='домофон']/value" />,&#160;этаж.<xsl:value-of select="//property[@name='etazh']/value" />,&#160;Кв.<xsl:value-of select="//property[@name='flat']/value" />
            </Представление>
        </Адрес>
</xsl:template>

</xsl:stylesheet>
