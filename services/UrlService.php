<?php
/**
 * Created by PhpStorm.
 * User: trina
 * Date: 18-9-18
 * Time: 上午11:25
 */

namespace app\services;

use yii\helpers\Url;

/**
 * 统一管理连接，并规范书写
 * Class UrlService
 * @package app\services
 * User: trina
 */
class UrlService
{
    /**
     * 返回一个内部链接
     * @param $url
     * @param array $param
     * @return string
     * User: trina
     */
    public static function buildUrl($url, $param = [])
    {
        return Url::toRoute(array_merge([$url], $param));
    }

    /**
     * 返回一个空链接
     * @return string
     * User: trina
     */
    public static function buildNullUrl()
    {
        return 'javascript:void(0);';
    }
}