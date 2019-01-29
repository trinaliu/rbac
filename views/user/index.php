<?php
/**
 * Created by PhpStorm.
 * user: trina
 * Date: 18-9-21
 * Time: 下午2:27
 */
use yii\helpers\Url;

$this->title = '用户列表'
?>
<div class="user-index">
    <!--标题与面包屑导航-->
    <div class="head clearfix">
        <div class="pull-left">
            <h3>用户列表</h3>
        </div>
        <div class="pull-right">
            <ul class="breadcrumb">
                <li><a href="/">首页</a></li>
                <li class="active">用户列表</li>
            </ul>
        </div>
    </div>
    <div class="main">
        <div class="button clearfix">
            <div class="pull-right">
                <a href="/user/add" class="btn btn-primary">添加用户</a>
            </div>
        </div>
        <div class="list" style="margin-top:10px">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>姓名</th>
                    <th>邮箱</th>
                    <th>操作</th>
                </tr>
                <?php if ($models):?>
                    <?php foreach ($models as $model):?>
                        <tr>
                            <td><?= $model->name?></td>
                            <td><?= $model->email?></td>
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
