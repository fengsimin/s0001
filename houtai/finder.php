<?php
class Finder extends Ifeiwu
{
	private $root = 'data/finder/';
	
	function __construct()
	{
		if (!$this->table)
		{
			$this->table = 'finder';
		}

		parent::__construct();
	}

	protected function postAll($pid, $request_data)
	{
		//所有文件
		$files = $this->db->select($this->table)
						  ->where($request_data['where'])
						  ->order($request_data['order'])
						  ->all();

		//当前文件夹位置
		$paths = array();
		
		if ($pid)
		{
			$level = $this->db->select($this->table, 'level')->where(array('id', '=', $pid))->get(0);
			$level = array_filter(explode(',', $level));
	
			$paths = $this->db->select($this->table, array('id', 'name'))
							  ->where(array('id', 'IN', $level), 'AND', array('type', '=', 'folder'))
							  ->all();
		}

		return array('files'=>$files, 'paths'=>$paths);
	}

	protected function postAdd($request_data)
	{
		$path = $request_data['path'];
		$name = $request_data['name'];
		$type = mime_content_type('../' . $path . $name);
		$foid = $request_data['foid'];
		
		if (!is_dir($this->_UTF82GBK('../' . $path)))
		{
			if (!mkdir($this->_UTF82GBK('../' . $path), 0777, true))
			{
				return $this->error('创建文件夹失败！');
			}
		}
		
		$filename = $this->_UTF82GBK('../' . $path . $name);

		//如果是图片添加图片尺寸
		if (stripos($type, 'image') !== false && is_file($filename))
		{
			$imagesize = getimagesize($filename);
			$data['width'] = $imagesize[0];
			$data['height'] = $imagesize[1];
		}

		$data['path'] = $path;
		$data['name'] = $name;
		$data['type'] = $type;
		$data['pid'] = $foid ? $foid : 0;
		$data['size'] = $request_data['size'];
		$data['ctime'] = time();
		$data['ext'] = end(explode('.', $name));

		$this->db->beginTransaction();

		//添加文件信息到数据库
		if (!$id = $this->db->insert($this->table, $data)->id())
		{
			unlink($filename);
			
			$this->db->rollBack();
			
			return $this->error('上传文件 ' . $name . ' 失败！');
		}
		
		//更新文件层次级别
		$level = $this->_getLevel($id);
		
		if ($this->db->update($this->table, array('level' => $level), array('id', '=', $id))->is())
		{
			$this->db->commit();
			
			return $this->success();
		}
		
		$this->db->rollBack();

		return $this->error('上传文件 ' . $name . ' 失败！');
	}

	//创建文件夹
	protected function postMkdir($request_data)
	{
		//新建文件夹名称
		$pid = $request_data['pid'];
		$name = $request_data['name'];
		
		if ($name===null || $name==='') {
			return $this->error('无效的参数！');
		}

		$data = array();
		$data['name'] = $name;
		$data['pid'] = $pid;

		// 当前文件夹ID，查找文件夹路径
		$folder_path = '';
		$level = $this->db->select($this->table, '`level`')->where(array('id', '=', $pid))->get(0);
		if ($level)
		{
			$level = array_filter(explode(',', $level));
			
			$folder = $this->db->select($this->table, '`name`')
							   ->where(array('id', 'IN', $level), 'AND', array('type', '=', 'folder'))
							   ->all();
							   
			foreach ($folder as $value) {
				$folder_path .= $value['name'] . '/';
			}			   
		}
		
		// 字符编码转换，避免中文乱码
		$dirname = $this->_UTF82GBK('../' . $this->root . $folder_path . $name);
		
		if (is_dir($dirname))
		{
			return $this->error($name . ' 文件夹已存在！');
		}

		if (!mkdir($dirname, 0755, true))
		{
			return $this->error('创建文件夹失败！');
		}
		
		$this->db->beginTransaction();
		
		$data['path'] = $this->root . $folder_path;
		$data['sortby'] = 1;
		$data['type'] = 'folder';
		$data['ctime'] = time();

		if (!$id = $this->db->insert($this->table, $data)->id())
		{
			rmdir($dirname);
			
			$this->db->rollBack();
			
			return $this->error('创建文件夹失败！');
		}

		//更新文件夹层次级别
		$level = $this->_getLevel($id);
			
		if ($this->db->update($this->table, array('level' => $level), array('id', '=', $id))->is())
		{
			$this->db->commit();
			
			return $this->success();
		}
		else
		{
			rmdir($dirname);
			
			$this->db->rollBack();
			
			return $this->error('创建文件夹失败！');
		}
	}

	// 重命名
	protected function postRename($request_data)
	{
		$id = $request_data['id'];
		$name = $request_data['name'];
		
		if (!$id || $name===null || $name==='') {
			return $this->error('无效的参数！');
		}
		
		$finder = $this->db->select($this->table, array('path', 'name', 'level'))
						   ->where(array('id', '=', $id))
						   ->get();
		$path = $finder['path'];
		
		if (!$path || stripos($path, $this->root)===false) {
			return $this->error('无效的路径！');
		}
		
		$oldname = $this->_UTF82GBK('../' . $path . $finder['name']);
		$newname = $this->_UTF82GBK('../' . $path . $name);
		
		$this->db->beginTransaction();
		
		if (is_file($oldname))
		{
			if ($this->db->update($this->table, array('name' => $name), array('id', '=', $id))->is())
			{
				if (rename($oldname, $newname)) {
					$this->db->commit();
					return $this->success();
				} else {
					$this->db->rollBack();
					return $this->error('文件重命名失败！');
				}
			}
			else
			{
				$this->db->rollBack();
				
				return $this->error('文件重命名失败！');
			}
		}
		// 重命名文件夹
		elseif (is_dir($oldname))
		{
			if ($this->db->update($this->table, array('name' => $name), array('id', '=', $id))->is())
			{
				if (rename($oldname, $newname)) {
					// 找出当前文件夹下面的所有文件和文件夹
					$sublist = $this->db->select($this->table, array('id', 'level', 'type'))
										->where(array('level', 'LIKE', "%,{$id},%"))
										->all();
					
					foreach ($sublist as $sub)
					{
						if ($sub['level'] == $finder['level']) { continue; }
						
						$newpath = '';
						$level = array_filter(explode(',', $sub['level']));
						
						// 重新建立文件路径
						foreach ($level as $lid) {
							$levelobj = $this->db->select($this->table, array('name', 'level'))
												 ->where("id = $lid AND type = 'folder'")
												 ->get();
							
							if ($sub['type'] == 'folder' && ($sub['level']==$levelobj['level'])) { continue; }

							$level_name = $levelobj['name'];
							$newpath .= $level_name!='' ? $level_name . '/' : '';
						}
						
						$is_path_update = $this->db->update($this->table, array('path'=>$this->root . $newpath), array('id', '=', $sub['id']))->is();
						
						if ($is_path_update===false) {
							break;
						}
					}

					if ($is_path_update!==false) {
						$this->db->commit();
						return $this->success();
					} else {
						rename($newname, $oldname);
						$this->db->rollBack();
						return $this->error('文件夹重命名失败！');
					}
				}
				else {
					$this->db->rollBack();
					return $this->error($name . ' 文件夹已存在！');
				}
			}
			else
			{
				$this->db->rollBack();
				return $this->error('文件夹重命名失败！');
			}
		}
		else
		{
			return $this->error('找不到重命名的文件/文件夹！');
		}
	}

	//文件是否存在
	protected function postIsFile($request_data)
	{
		$path = $request_data['path'];
		$name = $request_data['name'];

		if (file_exists($this->_UTF82GBK('../'. $path . $name)))
		{
			return $this->success($name . ' 文件已存在！');
		}
		else
		{
			return $this->error($name . ' 文件不存在！');
		}
	}
	
	//删除文件/文件夹
	protected function postDelete($request_data)
	{
		$ids = $request_data['id'];
		
		foreach ($ids as $id)
		{
			$file = $this->db->select($this->table, array('path','name'))->where(array('id', '=', $id))->get();
			
			if (!$file) { continue; }
			
			$path = $file['path'];
			$name = $file['name'];
			
			// 没有指定目录或文件名
			if (!$path || stripos($path, 'data/finder/')===false || $name==null || $name=='') {
				$this->db->delete($this->table, array('id', '=', $id))->is();
				continue;
			}
			
			$filename = $this->_UTF82GBK('../'. $path . $name);
	
			//删除文件
			if (is_file($filename))
			{
				if ($this->db->delete($this->table, array('id', '=', $id))->is())
				{
					@unlink($filename);
				}
			}
			//删除目录
			elseif (is_dir($filename))
			{
				if ($this->db->delete($this->table, array('level', 'LIKE', "%,{$id},%"))->is())
				{
					$this->_rmdir($filename);
				}
			}
			// 不是文件或目录
			else {
				$this->db->delete($this->table, array('level', 'LIKE', "%,{$id},%"));
			}
		}

		return $this->success();
	}
	
	// 当前文件夹路径
	protected function getCurPath($foid)
	{
		$level = $this->db->select($this->table, 'level')->where(array('id', '=', $foid))->get(0);
		
		$level = array_filter(explode(',', $level));

		$data = $this->db->select($this->table, array('id', 'name'))
						 ->where(array(array('id', 'IN', $level), 'AND', array('type', '=', 'folder')))
						 ->all();

		return $this->success('', $data);
	}
}
