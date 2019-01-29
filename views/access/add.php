<?php
/**
 * Created by PhpStorm.
 * user: trina
 * Date: 18-9-25
 * Time: 上午11:22
 */
$this->title = '添加权限';
?>
<div class="access-add">
    <!--标题与面包屑导航-->
    <div class="head clearfix">
        <div class="pull-left">
            <h3>添加权限</h3>
        </div>
        <div class="pull-right">
            <ul class="breadcrumb">
                <li><a href="/">首页</a></li>
                <li><a href="/access/index">权限列表</a></li>
                <li class="active">添加权限</li>
            </ul>
        </div>
    </div>
    <div class="main">
        <form role="form" class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-2 control-label">权限标题</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="title">
                    <div class="help-block"></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Urls</label>
                <div class="col-sm-8">
                    <textarea class="form-control" name="url" placeholder="一行一个url" rows="5"></textarea>
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
            let flag = 0;
            //权限标题验证
            const title = $("input[name='title']").val();
            if (!title) {
                $.error("title", "权限标题不能为空。");
                flag++;
            }
            //Urls验证
            const selector = $("textarea[name='url']");
            const url = selector.val();
            if (!url) {
                selector.next(".help-block").empty().append("urls不能为空。");
                selector.parents(".form-group").addClass("has-error");
                flag++;
            }
            if (flag) {
                return false;
            }

            $.ajax({
                url: "/access/add",
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