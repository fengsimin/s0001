<?php
return array(

	'/' => array(
		'method' => 'GET',
		'controller' => 'Home',
		'action' => 'index'
	),
	
	'/order' => array(
		'method' => 'POST',
		'controller' => 'Home',
		'action' => 'order'
	),
	
	// 流量统计
	'/stats' => array(
		'method' => 'POST',
		'controller' => 'Stats',
		'action' => 'index'
	),
);
