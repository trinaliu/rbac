<?php
/**
 * Created by PhpStorm.
 * User: trina
 * Date: 18-9-20
 * Time: 上午11:12
 */
$this->title = "编辑角色";
?>
<div class="role-edit">
    <!--标题与面包屑导航-->
    <div class="head clearfix">
        <div class="pull-left">
            <h3>编辑角色</h3>
        </div>
        <div class="pull-right">
            <ul class="breadcrumb">
                <li><a href="/">首页</a></li>
                <li><a href="/role/index">角色列表</a></li>
                <li class="active">编辑角色</li>
            </ul>
        </div>
    </div>
    <div class="main">
        <form role="form" class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-2 control-label">角色</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="name" value="<?=$model->name?>" data-id="<?=$model->id?>">
                    <div class="help-block"></div>
                </div>
                <div class="col-sm-2">
                    <button type="button" class="btn btn-info submit">提交</button>
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
            const selector = $("input[name='name']");
            const name = selector.val();
            const id = selector.data('id');
            if (!name) {
                $.error("name", "角色名称不能为空。");
                return false;
            }

            $.ajax({
                url: "/role/edit?id="+id,
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

