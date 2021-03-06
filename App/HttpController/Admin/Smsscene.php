<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/8
 * Time: 下午8:00
 *
 */

namespace App\HttpController\Admin;

use App\Utils\Code;

class Smsscene extends Admin
{
	/**
	 * 短信场景列表
	 */
	public function list()
	{
		$list  = \App\Model\SmsScene::init()->getSmsSceneList( [], '*', 'id asc', [1,1000] );
		return $this->send( Code::success, [
			'list' => $list,
		] );
	}

	/**
	 * 短信场景设置
	 * @param string $name                 场景名称
	 * @param string $sign                 唯一标识
	 * @param string $signature            签名
	 * @param string $provider_template_id 短信提供商的模板id
	 * @param string $provider_type        短信提供商
	 * @param string $body                 短信内容
	 */
	public function edit()
	{
		if( $this->validator( $this->post, 'Admin/SmsScene.edit' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$result = \App\Model\SmsScene::init()->editSmsScene( ['sign' => $this->post['sign']], [
				'name'                 => $this->post['name'],
				'signature'            => $this->post['signature'],
				'provider_template_id' => $this->post['provider_template_id'],
				'provider_type'        => $this->post['provider_type'],
				'body'                 => $this->post['body'],
			] );
			if( $result ){
				$this->send( Code::success );
			} else{
				$this->send( Code::error );
			}
		}
	}

	/**
	 * 短信场景详情
	 * @param string $sign 唯一标识
	 */
	public function info()
	{
		if( $this->validator( $this->get, 'Admin/SmsScene.info' ) !== true ){
			 $this->send( Code::error, $this->getValidator()->getError() );
		} else{
			$info = \App\Model\SmsScene::init()->getSmsSceneInfo( ['sign' => $this->get['sign']] );
			 $this->send( Code::success, ['info' => $info] );
		}
	}
}