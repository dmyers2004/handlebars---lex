#!/usr/bin/env php
<?php
/*
options:
<- helper name ->
[name] => lex_lowercase

<- key value pair ->
[hash] => Array
	[size] => 123
	[fullname] => Don Myers

<- full context object ->
[contexts] => ...

<- current context ->
[_this] => Array
	[name] => Dan
	[age] => 21
*/
@unlink('debug.log');

require __DIR__.'/vendor/autoload.php';

$data = include 'data.php';
$template = file_get_contents(__DIR__.'/templates/template3.bar');

$helpers = [];

$helpers['lowercase'] = function($options) {
	return strtolower($options['fn']()); /* parse inter block content */
};

$helpers['uppercase'] = function($options) {
	return strtoupper($options['fn']($options['_this']));
};

$helpers['blocker'] = function($options) {
	return $options['fn'](); /* parse inter block content */
};

$helpers['is_even'] = function($value,$options) {
	/* parse the "then" (fn) or the "else" (inverse) */
	return ($value % 2) ? $options['fn']($options['_this']) : $options['inverse']($options['_this']);
};

$helpers['is_odd'] = function($value,$options) {
	return ($value % 2) ? $options['inverse']($options['_this']) : $options['fn']($options['_this']);
};

$helpers['if_eq'] = function($value1,$value2,$options) {
	return ($value1 == $value2) ? $options['fn']($options['_this']) : $options['inverse']($options['_this']);
};

$helpers['if_lt'] = function($value1,$value2,$options) {
	return ($value1 < $value2) ? $options['fn']($options['_this']) : $options['inverse']($options['_this']);
};

$helpers['if_gt'] = function($value1,$value2,$options) {
	return ($value1 > $value2) ? $options['fn']($options['_this']) : $options['inverse']($options['_this']);
};

$helpers['if_ne'] = function($value1,$value2,$options) {
	return ($value1 != $value2) ? $options['fn']($options['_this']) : $options['inverse']($options['_this']);
};

/* in is a reference to the data array sent in */
$helpers['set'] = function($options) use (&$in) {
	$in[$options['hash']['name']] = $options['hash']['value'];

	return;
};

/* _this is a the data array sent in */
$helpers['get'] = function($options) {
	return $options['_this'][$options['hash']['name']];
};

//$flags = LightnCandy\LightnCandy::FLAG_ERROR_LOG | LightnCandy\LightnCandy::FLAG_HANDLEBARS | LightnCandy\LightnCandy::FLAG_STANDALONEPHP;
$flags = LightnCandy\LightnCandy::FLAG_RENDER_DEBUG | LightnCandy\LightnCandy::FLAG_HANDLEBARS | LightnCandy\LightnCandy::FLAG_SPVARS | LightnCandy\LightnCandy::FLAG_HANDLEBARSJS;

$phpstr = LightnCandy\LightnCandy::compile($template,['flags'=>$flags,'helpers'=>$helpers]);

file_put_contents('compiled/template.php','<?php '.$phpstr.'?>');

$renderer = include 'compiled/template.php';

echo $renderer($data);

function logger($v) {
	if ($log_handle = @fopen('debug.log','a')) {
		if (is_array($v)) {
			$v = print_r($v,true);	
		}
		fwrite($log_handle,'*******************************'.chr(10).date('H:i:s').' '.$v.chr(10));
		fclose($log_handle);
	}
}