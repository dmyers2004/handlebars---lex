#!/usr/bin/env php
<?php
require __DIR__.'/vendor/autoload.php';

$data = include 'data.php';

$template = file_get_contents(__DIR__.'/templates/template2.lex');

$parser = new Lex\Parser();

echo $parser->parse($template, $data,'callback');

function callback($name, $attributes, $content) {
	var_dump(func_get_args());
	
	switch($name) {
		case 'lex.lower':
			return strtolower($content);
		break;
	}
}