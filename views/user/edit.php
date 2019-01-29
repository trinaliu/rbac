<?php
/**
 * Created by PhpStorm.
 * user: trina
 * Date: 18-9-21
 * Time: 下午5:00
 */
$this->title = '编辑用户';
?>
<div class="user-edit">
    <!--标题与面包屑导航-->
    <div class="head clearfix">
        <div class="pull-left">
            <h3>编辑用户</h3>
        </div>
        <div class="pull-right">
            <ul class="breadcrumb">
                <li><a href="/">首页</a></li>
                <li><a href="/user/index">用户列表</a></li>
                <li class="active">编辑用户</li>
            </ul>
        </div>
    </div>
    <div class="main">
        <form role="form" class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-2 control-label">姓名</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="name" value="<?=$model->name?>">
                    <input type="hidden" name="id" data-id="<?=$model->id?>">
                    <div class="help-block"></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">邮箱</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="email" value="<?=$model->email?>">
                    <div class="help-block"></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">所属角色</label>
                <div class="col-sm-8">
                    <?php if ($roleModels):?>
                        <?php foreach ($roleModels as $roleModel):?>
                            <lable class="checkbox-inline">
                                <input type="checkbox" name="role[]" value="<?=$roleModel->id?>" <?php if (in_array($roleModel->id, $roleId)):?>checked <?php endif;?>><?=$roleModel->name?>
                            </lable>
                        <?php endforeach;?>
                    <?php endif;?>
                    <div class="help-block"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1 col-sm-offset-9">
                    <button type="button" class="btn btn-primary submit">提交</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="/js/jquery.min.js"></script>
<script src="/js/form-error.js"></script>
<script>
    $(function(){
        $(".submit").on("click", function(){
            const id = $("input[name='id']").data("id");
            let flag = 0;
            //姓名验证
            const name = $("input[name='name']").val();
            if (!name) {
                $.error("name", "姓名不能为空。");
                flag++;
            }
            //邮箱验证
            const email = $("input[name='email']").val();
            const isEmail = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
            if (!email) {
                $.error("email", "邮箱不能为空。");
                flag++;
            } else if (email && !isEmail.test(email)) {
                $.error("email", "邮箱格式不正确。");
                flag++;
            }
            if (flag) {
                return false;
            }

            $.ajax({
                url: "/user/edit?id=" + id,
                type: "POST",
                dataType: "JSON",
                data: $("form").serialize(),
                success: function(response) {
                    if (!response.status && Object.keys(response.data).length) {
                        for (let key in response.data) {
                            if(!response.data.hasOwnProperty(key)) continue;
                            $.error(key, response.data[key]);
                        }
                        return false;
                    }
                    alert(response.message);
                    if (response.status) {
                        window.location.reload();
                    }
                }
            })
        })
    });
</script>
