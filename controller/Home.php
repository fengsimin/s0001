<?php
namespace controller;

use ifeiwu\Controller;

class Home extends Controller
{
	
	public function _init()
	{
		$site = theme(site());
		
		$this->assign('site', $site);
	}

	public function index()
	{
		$item = db()->select('item')->where('state = 1')->order('sortby DESC')->get();

		$this->assign('item', $item);
		$this->display();
	}
	
	public function order()
	{
		if ($_POST['_token'] !== md5(session('_token'))) { error('非法提交数据！'); }

		$db = db();
		
		$item = $db->select('item', array('title','price'))
					->where("id = {$_POST['item_id']} AND state = 1")
					->get();
		
		if (!$item) { error('商品已下架！'); }
		
		$data['nid'] = 3;
		$data['ctime'] = time();
		$data['sn'] = date('ymdHis') . substr(microtime(), 2, 4);
		$data['color'] = $_POST['color'];
		$data['linkman'] = $_POST['linkman'];
		$data['mobile'] = $_POST['mobile'];
		$data['quantity'] = $_POST['quantity'];
		$data['address'] = $_POST['province'].' '.$_POST['city'].' '.$_POST['district'].' '.$_POST['address'];
		$data['total'] = number_format($item['price'] * $data['quantity'], 1, '.', '');
		$data['item_title'] = $item['title'];
		$data['item_price'] = $item['price'];
		$data['message'] = $_POST['message'];

		if ($db->insert('order', $data)->is()) {
			success('您的订单已收到！我们的工作人员会尽快与您联系 请您耐心等待...');
		} else {
			error('很抱歉！系统繁忙，请稍候再试...');
		}
	}

}
