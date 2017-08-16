<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE xsl:stylesheet SYSTEM "ulang://common">
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:umi="http://www.umi-cms.ru/TR/umi"
	xmlns:php="http://php.net/xsl"
	>

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