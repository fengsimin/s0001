<?php
class Order extends Item
{
	function __construct()
	{
		if (!$this->table)
		{
			$this->table = 'order';
		}
		
		parent::__construct();
	}

}
