<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<!--导航条-->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-md-2" style="background: black">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#" style="color:white;">RBAC</a>
                </div>
            </div>
            <div class="col-sm-9 col-md-10 ">
                <?php if (isset($this->params['current_user'])):?>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="name">
                            <a href="#" style="cursor: auto; color: white;">Hi， <?=$this->params['current_user']['name']?></a>
                        </li>
                        <li class="active"><a href="#">退出登录</a></li>
                    </ul>
                <?php endif;?>
            </div>
        </div>
    </div>
</nav>
<!--菜单栏和内容区域-->
<div class="container-fluid">
    <div class="col-sm-2 col-md-2 col-lg-2 sidebar">
        <ul class="nav nav-sidebar" id="nav">
            <li >权限演示页面</li>
            <li><a href="<?= Url::to(['/test/page-one'])?>">测试页面一</a></li>
            <li><a href="<?= Url::to(['/test/page-two'])?>">测试页面二</a></li>
            <li><a href="<?= Url::to(['/test/page-three'])?>">测试页面三</a></li>
            <li><a href="<?= Url::to(['/test/page-four'])?>">测试页面四</a></li>
            <li>系统设置</li>
            <li><a href="<?= Url::to(['/user/index'])?>">用户管理</a></li>
            <li><a href="<?= Url::to(['/role/index'])?>">角色管理</a></li>
            <li><a href="<?= Url::to(['/access/index'])?>">权限管理</a></li>
        </ul>
    </div>
    <div class="col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2 col-lg-10 col-lg-offset-2">
        <?=$content?>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<script>
    $(function(){
        $('#nav li').each(function(){
            let url = window.location.href;
            //获取当前页面的绝对路径
            url = url.split("//")[1].split("/")[1];
            //判断index
            url = "/" + url + "/index";
            const aUrl = $(this).find("a").attr("href");
            if (url === aUrl) {
                $(this).find("a").parents("li").addClass("active")
                    .siblings().removeClass("active");
            }
        })
    })
</script>
