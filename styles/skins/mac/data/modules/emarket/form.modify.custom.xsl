<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE xsl:stylesheet SYSTEM "ulang://common">
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:umi="http://www.umi-cms.ru/TR/umi"
	xmlns:php="http://php.net/xsl"
	>

	<xsl:template match="data[@type = 'form' and (@action = 'modify' or @action = 'create')]">
		<form class="form_modify" method="post" action="do/" enctype="multipart/form-data">
			<input type="hidden" name="referer" value="{/result/@referer-uri}" id="form-referer" />
			<input type="hidden" name="domain" value="{$domain-floated}"/>
			<input type="hidden" name="permissions-sent" value="1" />
			<script type="text/javascript">
				var treeLink = function(key, value){
					var settings = SettingsStore.getInstance();
					
					return settings.set(key, value, 'expanded');
				}
			</script>
			<xsl:apply-templates mode="form-modify" />
			<xsl:apply-templates select="page" mode="permissions" />

			<xsl:if test="@action = 'modify' and count(page) = 1">
				<xsl:apply-templates select="document(concat('udata://backup/backup_panel/', page/@id))/udata" />
			</xsl:if>
		</form>
		<script type="text/javascript">
			var method = '<xsl:value-of select="/result/@method" />';
			<![CDATA[
				jQuery('form.form_modify').submit(function() {
					
					var val = true;  
					var str = '<div id="errorList"><p class="error"><strong>' + getLabel('js-label-errors-found') + ':</strong></p><ol class="error">';
					
					jQuery('.required', this).each(function(){
						if (this.value == '') {
							if (val === true) val = false;
							var innerText = jQuery('label[for=' + this.id + '] acronym').text();
							str += '<li>' + getLabel('js-error-required-field') + ' "' + innerText + '".' + '</li>';
						}
					});
					str += '</ol></div>';
					
					if (val === false) {
						if (jQuery("div").is("#errorList") === false) {
							jQuery('div#page').before(str);
						} else {
							jQuery("#errorList").remove();
							jQuery('div#page').before(str);
						}
						jQuery('body').scrollTop(0);
					}
					return val;
				});
			]]>
		</script>
	</xsl:template>

	<xsl:template match="page|object" mode="form-modify">
		<xsl:apply-templates select="properties/group" mode="form-modify" />
	</xsl:template>

		<xsl:template match="field[@type = 'relation' and @name = 'show_fields' or @name = 'not_null_fields']" mode="form-modify">
		<div class="field relation" id="{generate-id()}" umi:type="{@type-id}">
			<xsl:choose>
				<xsl:when test="@multiple = 'multiple'">
					 <xsl:attribute name="style">
						<xsl:text>height:340px;</xsl:text>
					</xsl:attribute>
				</xsl:when>
				<xsl:when test="@public-guide = '1'">
					 <xsl:attribute name="style">
						<xsl:text>height:100px;</xsl:text>
					</xsl:attribute>
				</xsl:when>
				<xsl:otherwise/>
			</xsl:choose>
			<xsl:if test="not(@required = 'required')">
				<xsl:attribute name="umi:empty"><xsl:text>empty</xsl:text></xsl:attribute>
			</xsl:if>
			<label for="relationSelect{generate-id()}">
				<span class="label">
					<acronym>
						<xsl:apply-templates select="." mode="sys-tips" />
						<xsl:value-of select="@title" />
					</acronym>
					<xsl:apply-templates select="." mode="required_text" />
				</span>
				<span>
					<select name="{@input_name}" id="relationSelect{generate-id()}">
						<xsl:apply-templates select="." mode="required_attr" />
						<xsl:if test="@multiple = 'multiple'">
							<xsl:attribute name="multiple">multiple</xsl:attribute>
							<xsl:attribute name="style">height: 262px;</xsl:attribute>
						</xsl:if>
						<xsl:if test="not(values/item/@selected)">
							<option value=""></option>
						</xsl:if>
						<xsl:apply-templates select="values/item" />
					</select>
				</span>
			</label>
			<input type="text" id="relationInput{generate-id()}" class="search_input" />
			<xsl:if test="@public-guide = '1'">
				<input type="button" id="relationButton{generate-id()}" value =" " class="relation-add"  />
				<div>
					<a href="{$lang-prefix}/admin/data/guide_items/{@type-id}/"><xsl:text>&label-edit-guide-items;</xsl:text></a>
				</div>
			</xsl:if>
		</div>
	</xsl:template>
	
	<xsl:template match="field[@name = 'manager_comment']" mode="form-modify">
	  <div class="field">
		<label for="{@name}">
		  <xsl:value-of select="@title"/>
		</label>
		<textarea name="{@input_name}" id="{@name}" style="height: 100px;">
		  <xsl:value-of select="."/>
		</textarea>
	  </div>
	</xsl:template>
        
	<xsl:template match="field[@name = 'youtube_video']" mode="form-modify">
	  <div class="field">
		<label for="{@name}">
		  <xsl:value-of select="@title"/>
		</label>
		<textarea name="{@input_name}" id="{@name}" style="height: 100px;">
		  <xsl:value-of select="."/>
		</textarea>
	  </div>
	</xsl:template>
	
</xsl:stylesheet>