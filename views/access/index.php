<?php
/**
 * Created by PhpStorm.
 * user: trina
 * Date: 18-9-25
 * Time: 上午11:15
 */
use yii\helpers\Url;
use yii\helpers\Json;

$this->title = '权限列表'
?>
<div class="access-index">
    <!--标题与面包屑导航-->
    <div class="head clearfix">
        <div class="pull-left">
            <h3>权限列表</h3>
        </div>
        <div class="pull-right">
            <ul class="breadcrumb">
                <li><a href="/">首页</a></li>
                <li class="active">权限列表</li>
            </ul>
        </div>
    </div>
    <div class="main">
        <div class="button clearfix">
            <div class="pull-right">
                <a href="/access/add" class="btn btn-primary">添加权限</a>
            </div>
        </div>
        <div class="list" style="margin-top:10px">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>权限</th>
                    <th>Urls</th>
                    <th>操作</th>
                </tr>
                <?php if ($models):?>
                    <?php foreach ($models as $model):?>
                        <tr>
                            <td><?= $model->title?></td>
                            <td><?= str_replace("\n", "<br>", $model->urls)?></td>
                            <td>
                                <a href="<?= Url::to(['edit', 'id' => $model->id])?>">编辑</a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                <?php endif;?>
            </table>
            <ul class="pager">
                <li class="previous">
                    <a href="#">&larr; 上一页</a>
                </li>
                <li class="next">
                    <a href="#">下一页 &rarr;</a>
                </li>
            </ul>
        </div>
    </div>
</div>
