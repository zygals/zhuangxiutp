<?php
    
namespace app\back\controller;
use think\Controller;
use think\Db;
use think\Request;

Class GongGaoController extends Controller
{

	public function index()
	{
        $a = Db::name('gonggao')->order('sort','asc')->select();
        $a = $a->toArray();
        // dump();die;
        $url = request()->url();

        $data = ['list_'=>$a,'url'=>$url];
        $view = 'index';
		return view($view,$data);

	}

	public function add()
	{
		return view('add');
		
	}

	public function save(Request $request)
	{
		$data = $request->param();

		// dump($data);die;
		foreach ($data as $k => $v) {
			if(empty($data[$k])) {
				$this->error('有必填项未填!', 'add', '', 1);
			}
		}

		$gonggaod = array('sort'=>$data['sort'],'content'=>$data['content']);
		if(empty($data['id'])) {
			$gonggaod['addtime'] = time();
			$gonggaoinfo = Db::name('gonggao')->insert($gonggaod);
		} else {
            $gonggaoinfo = true;
            Db::name('gonggao')->where('id',$data['id'])->update($gonggaod);

		}
        
        if($gonggaoinfo) {
        	$this->success('操作公告信息成功', 'index', '', 1);
        } else {
        	$this->error('操作公告信息失败', 'add', '', 1);
        }
		
		
	}

    public function edit()
	{
		$id = request()->get('id');
		if(!$id) $this->redirect('index');
		$a = Db::name('gonggao')->where('id',$id)->find();
        $data = ['item'=>$a,'title'=>'公告信息编辑'];
        return view('edit',$data);
	}

	public function delete()
	{
		$id = request()->post('id');
		$e = Db::name('gonggao')->delete($id);
		if($e) {
			$this->success('删除公告成功', 'index', '', 1);
        } else {
        	$this->error('删除公告失败', 'index', '', 1);
        }
	}


}