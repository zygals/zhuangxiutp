<?php

namespace app\back\controller;

use app\back\model\Admin;
use app\back\model\Article;
use app\back\model\Base;
use app\back\model\Good;
use app\back\model\Shop;

use app\back\model\Cate;

use app\back\model\ShopAddress;
use think\Request;


class ShopController extends BaseController{
	/**
	 * 显示资源列表
	 *.
	 * 0
	 * @return \think\Response
	 */
	public function index(Request $request){
		$data = $request->param();
		$list_ = Shop::getList( $data );
		$page_str = $list_->render();
		$page_str = Base::getPageStr( $data , $page_str );
		$url = $request->url();
		$list_cate = Cate::getAllCateByType( 1 );
		$isShopAdmin = Admin::isShopAdmin();
		return $this->fetch( 'index' , ['list_' => $list_ , 'isShopAdmin' => $isShopAdmin , 'url' => $url , 'list_cate' => $list_cate , 'page_str' => $page_str] );
	}

	/**
	 * 显示创建资源表单页.
	 *
	 * @return \think\Response
	 */
	public function create(){
		$list_cate = Cate::getAllCateByType( 1 );
		return $this->fetch( '' , ['title' => '添加商户' , 'act' => 'save' , 'list_cate' => $list_cate] );

	}

	/**
	 * 保存新建的资源
	 *
	 * @param  \think\Request $request
	 *
	 * @return \think\Response
	 */
	public function save(Request $request){

		$data = $request->param();

		$res = $this->validate( $data , 'ShopValidate' );
		if ( $res !== true ) {
			$this->error( $res );
		}


		$file = $request->file( 'img' );
		$file2 = $request->file( 'logo' );
		$file3 = $request->file( 'qrcode' );

		if ( empty( $file ) || empty( $file2 ) ) {
			$this->error( '请上传图片或检查图片大小！' );
		}
		$size = $file->getSize();
		$size2 = $file2->getSize();
		if ( $size > config( 'upload_size' ) || $size2 > config( 'upload_size' )  ) {
			$this->error( '图片大小超过限定！' );
		}
		$path_name = 'shop';
		$arr = $this->dealImg( $file , $path_name );
		$arr2 = $this->dealImg( $file2 , $path_name );
		$data['img'] = $arr['save_url_path'];
		$data['logo'] = $arr2['save_url_path'];

		if ( !empty( $file3 ) ) {
			$size3 = $file3->getSize();
			if ( $size3 > config( 'upload_size' ) ) {
				$this->error( '图片大小超过限定！' );
			}
			$arr3 = $this->dealImg( $file3 , $path_name );
			$data['qrcode'] = $arr3['save_url_path'];
		}
		if ( !empty( $data['cate_ids'] ) ) {
			$data['cate_ids'] = implode( ',' , $data['cate_ids'] );
		}
		if ( $data['info'] == '' ) {
			$data['info'] = '暂无描述';
		}
		$shop = new Shop();
		$shop->save( $data );
		$this->success( '添加成功' , 'index' , '' , 1 );
	}
	//add shop_address


	/**
	 * 显示编辑资源表单页.
	 *
	 * @param  int $id
	 *
	 * @return \think\Response
	 */
	public function edit(Request $request){
		$data = $request->param();
		$row_ = $this->findById( $data['id'] , new Shop() );
		// dump($row_->type);exit;
		$list_cate = Cate::getAllCateByType( 1 );
		$list_address = ShopAddress::getAddressByShop( $row_->id );

		$referer = $request->header()['referer'];
		return $this->fetch( '' , ['row_' => $row_ , 'list_cate' => $list_cate , 'list_address' => $list_address , 'title' => '修改商户：' . $row_->name , 'act' => 'update' , 'referer' => $referer] );
	}

	/**
	 * 保存更新的资源
	 *
	 * @param  \think\Request $request
	 * @param  int $id
	 *
	 * @return \think\Response
	 */
	public function update(Request $request){
//        dump($request->param());exit;
		$data = $request->param();
		$referer = $data['referer'];
		unset( $data['referer'] );
		$res = $this->validate( $data , 'ShopValidate' );
		if ( $res !== true ) {
			$this->error( $res );
		}

		$row_ = $this->findById( $data['id'] , new Shop() );
//        dump($row_);exit;
		if ( $data['cate_id'] != $row_['cate_id'] ) {
			$good = new Good;
			$good->where( 'shop_id' , $row_['id'] )
				->update( ['cate_id' => $data['cate_id']] );
		}
//        dump($row_);exit;
		$file = $request->file( 'img' );
		$file2 = $request->file( 'logo' );
		$file3 = $request->file( 'qrcode' );
		$path_name = 'shop';


		if ( !empty( $file ) ) {
			$size = $file->getSize();
			if ( $size > config( 'upload_size' ) ) {
				$this->error( '图片大小超过限定！' );
			}
			$this->deleteImg( $row_->img );
			$arr = $this->dealImg( $file , $path_name );
			$data['img'] = $arr['save_url_path'];
		}
		if ( !empty( $file2 ) ) {
			$size = $file2->getSize();
			if ( $size > config( 'upload_size' ) ) {
				$this->error( '图片大小超过限定！' );
			}
			$this->deleteImg( $row_->logo );
			$arr = $this->dealImg( $file2 , $path_name );
			$data['logo'] = $arr['save_url_path'];
		}
		if ( !empty( $file3 ) ) {
			$size = $file3->getSize();
			if ( $size > config( 'upload_size' ) ) {
				$this->error( '图片大小超过限定！' );
			}
			$this->deleteImg( $row_->qrcode );
			$arr = $this->dealImg( $file3 , $path_name );
			$data['qrcode'] = $arr['save_url_path'];
		}
		if ( $this->saveById( $data['id'] , new Shop() , $data ) ) {

			$this->success( '编辑成功' , $referer , '' , 1 );
		} else {
			$this->error( '没有修改内容' , $referer , '' , 1 );
		}
	}

	/**
	 * soft-delete 指定资源
	 *
	 * @param  int $id
	 *
	 * @return \think\Response
	 */
	public function delete(Request $request){
		$data = $request->param();
		$list_good = Good::getListByshopId( $data['id'] );
		if ( $list_good ) {
			$this->error( '商户下有商品，不允许删除' );
		}

		if ( $ret = $this->deleteStatusById( $data['id'] , new Shop() ) ) {
			//同时删除管理员
			$this->deleteStatusById( $ret->admin_id , new Admin() );
			$this->success( '删除成功' , $data['url'] , '' , 1 );
		} else {
			$this->error( '删除失败' , $data['url'] , '' , 3 );
		}
	}

	//add shop address
	public function add_address(Request $request){
		$data = $request->param();
		$row_shop = $this->findById( $data['id'] , new Shop() );
		if ( $row_shop->is_add_address == 1 ) {
			$this->error( '已添加过地址' );

		}
		$referer = $request->header()['referer'];
//        return $referer;

		return $this->fetch( '' , ['referer' => $referer , 'shop_id' => $row_shop->id , 'title' => '添加 ' . $row_shop->name . ' 门店地址' , 'act' => 'save_address'] );
	}

	public function save_address(Request $request){
		$data = $request->param();

		$res = $this->validate( $data , 'ShopAddressValidate' );
		if ( $res !== true ) {
			$this->error( $res );
		}
		$row_shop = $this->findById( $data['shop_id'] , new Shop() );
		if ( empty( $data['name_'][0] ) || empty( $data['truename_'][0] ) || empty( $data['address_'][0] ) || empty( $data['mobile_'][0] ) ) {
			$this->error( '门店地址不能为空' );
		}
		$referer = $data['referer'];
		unset( $data['referer'] );
		//add shop_address
		( new ShopAddress() )->saveAddress( $data );
		$row_shop->is_add_address = 1;
		$row_shop->save();
		$this->success( '添加成功' , $referer , '' , 1 );
	}

	public function edit_address(Request $request){
		$data = $request->param();
		$row_shop = $this->findById( $data['id'] , new Shop() );
		$list_address = ShopAddress::getAddressByShop( $data['id'] );


		$referer = $request->header()['referer'];
		return $this->fetch( '' , ['referer' => $referer , 'shop_id' => $row_shop->id , 'list_address' => $list_address , 'title' => '修改 ' . $row_shop->name . ' 门店地址' , 'act' => 'update_address'] );
	}

	public function update_address(Request $request){
		$data = $request->param();
		$res = $this->validate( $data , 'ShopAddressValidate' );
		if ( $res !== true ) {
			$this->error( $res );
		}
		if ( empty( $data['name_'][0] ) || empty( $data['truename_'][0] ) || empty( $data['address_'][0] ) || empty( $data['mobile_'][0] ) ) {
			$this->error( '门店地址不能为空' );
		}

		( new ShopAddress() )->saveAddress( $data , 2 );

		$referer = $data['referer'];
		unset( $data['referer'] );
		$this->success( '修改成功' , $referer , '' , 1 );

	}
	/*
	 * 关商家
	 * zhuangxiu-zyg
	 * */
    public function edit_guan(Request $request) {
        $data=$request->get();
        $back = $request->header()['referer'];
        $row_=$this->findById($data['id'],new shop());
        $row_->st=2; //不显示前台
        $row_->save();
        $this->success( '修改成功' , $back, '' , 1 );
	}


}
