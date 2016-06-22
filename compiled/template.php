<?php use \LightnCandy\SafeString as SafeString;use \LightnCandy\Runtime as LR;return function ($in = null, $options = null) {
    $helpers = array(            'uppercase' => function($options) {
	return strtoupper($options['fn']($options['_this']));
}
,
            'if_eq' => function($value1,$value2,$options) {
	return ($value1 == $value2) ? $options['fn']($options['_this']) : $options['inverse']($options['_this']);
}
,
            'set' => function($options) use (&$in) {
	$in[$options['hash']['name']] = $options['hash']['value'];

	return;
}
,
            'get' => function($options) {
	return $options['_this'][$options['hash']['name']];
}
,
);
    $partials = array();
    $cx = array(
        'flags' => array(
            'jstrue' => true,
            'jsobj' => true,
            'spvar' => true,
            'prop' => false,
            'method' => false,
            'lambda' => false,
            'mustlok' => false,
            'mustlam' => false,
            'echo' => false,
            'partnc' => false,
            'knohlp' => false,
            'debug' => isset($options['debug']) ? $options['debug'] : 1,
        ),
        'constants' => array(),
        'helpers' => isset($options['helpers']) ? array_merge($helpers, $options['helpers']) : $helpers,
        'partials' => isset($options['partials']) ? array_merge($partials, $options['partials']) : $partials,
        'scopes' => array(),
        'sp_vars' => isset($options['data']) ? array_merge(array('root' => $in), $options['data']) : array('root' => $in),
        'blparam' => array(),
        'partialid' => 0,
        'runtime' => '\LightnCandy\Runtime',
    );
    
    return '<h1>'.LR::debug('[title]', 'encq', $cx, ((is_array($in) && isset($in['title'])) ? $in['title'] : LR::miss($cx, '[title]'))).'</h1>
'.LR::debug('each [projects]', 'sec', $cx, ((is_array($in) && isset($in['projects'])) ? $in['projects'] : LR::miss($cx, '[projects]')), null, $in, true, function($cx, $in) {return '	<h3>'.LR::debug('[name]', 'encq', $cx, ((is_array($in) && isset($in['name'])) ? $in['name'] : LR::miss($cx, '[name]'))).'</h3>
	<h4>Assignees</h4>
	<ul>
'.LR::debug('each [assignees]', 'sec', $cx, ((is_array($in) && isset($in['assignees'])) ? $in['assignees'] : LR::miss($cx, '[assignees]')), null, $in, true, function($cx, $in) {return '		<li>
			'.LR::debug('^@[index] 2', 'hbch', $cx, 'if_eq', array(array((isset($cx['sp_vars']['index']) ? $cx['sp_vars']['index'] : LR::miss($cx, '@[index]')),'2'),array()), $in, false, function($cx, $in) {return 'Don Myers';}).'
		</li>
';}).'	</ul>
';}).''.LR::debug('FIXME: helper', 'encq', $cx, LR::debug('set age [title]', 'hbch', $cx, 'set', array(array(),array('name'=>'age','value'=>((is_array($in) && isset($in['title'])) ? $in['title'] : LR::miss($cx, '[title]')))), 'encq', $in)).'

<p>'.LR::debug('FIXME: helper', 'encq', $cx, LR::debug('get age', 'hbch', $cx, 'get', array(array(),array('name'=>'age')), 'encq', $in)).'</p>

<p>'.LR::debug('^', 'hbch', $cx, 'uppercase', array(array(),array()), $in, false, function($cx, $in) {return ''.LR::debug('[age]', 'encq', $cx, ((is_array($in) && isset($in['age'])) ? $in['age'] : LR::miss($cx, '[age]'))).'';}).'</p>';
};?>