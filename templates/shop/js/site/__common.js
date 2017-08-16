var site = {};

site.utils = {};
site.utils.getObjectType = function(obj) {
	var toString = Object.prototype.toString,
		obj_type = false;
	switch (toString.call(obj)) {
		case "[object Array]": obj_type = 'array'; break;
		case "[object Object]": obj_type = 'object'; break;
		case "[object String]": obj_type = 'string'; break;
		case "[object Number]": obj_type = 'number'; break;
		case "[object Boolean]": obj_type = 'boolean'; break;
		case "[object Function]": obj_type = 'function'; break;
	}
	return obj_type;
};

site.utils.js = {};
site.utils.js.init = function(src) {
	switch (site.utils.getObjectType(src)) {
		case "array": for (i in src) this.init(src[i]); break;
		case "string": this.include(src); break;
	}
	return true;
};

site.utils.js.include = function(src) {
	jQuery("<script/>", {
		"charset" : 'utf-8',
		"type"    : 'text/javascript',
		"src"     : src
	}).appendTo("head");
};

site.utils.js.init([
	'/js/client/utilities.js',
	'/js/client/basket.js',
	'/js/site/basket.js',
	'/js/site/forms.js',
	'/js/site/message.js',
	'/js/site/captcha.js',
//	'/js/site/videocust.js',
	'/js/jquery/jquery.cookie.js'
]);