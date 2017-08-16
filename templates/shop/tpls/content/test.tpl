<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" xmlns:umi="http://www.umi-cms.ru/TR/umi">
	<head>
            <link type="text/css" rel="stylesheet" href="/templates/shop/css/cms/responsive.css" />
            <link href="/templates/shop/css/slick/slick-theme.css" type="text/css" />
            <link href="/templates/shop/css/slick/slick.css" type="text/css" />
        
            %system getOuterContent('./templates/shop/tpls/content/head.inc.tpl')%
            <script type="text/javascript" src="/templates/shop/js/init.js"></script>
	</head>

	<body id="umi-cms-demo">
		%system getOuterContent('./templates/shop/tpls/content/inc/header.inc.tpl')%
		<div id="content_wrapper">
                    %system getOuterContent('./templates/shop/tpls/content/inc/left.inc.tpl')%
                    <div id="content">
                        <div class="i txt">
                            <h1  umi:element-id="%pid%" umi:field-name="h1">%h1%</h1>
                            <div umi:element-id="%pid%" umi:field-name="content">
                                %content%
                            </div>
                            <div class="clear">------------------</div>
                            hello
                            <div class="clear">------------------</div>
                            <div class="stars stars_0"></div>
                            <div class="stars stars_1"></div>
                            <div class="stars stars_2"></div>
                            <div class="stars stars_3"></div>
                            <div class="stars stars_4"></div>
                            <div class="stars stars_5"></div>
                        </div>
                    </div>
		</div>
	</div>
	
	<div class="clear"></div>
	
	%system getOuterContent('./templates/shop/tpls/content/inc/footer.inc.tpl')%
	
</body>
</html>