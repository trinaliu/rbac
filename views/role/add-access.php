<?php
/**
 * Created by PhpStorm.
 * user: trina
 * Date: 18-10-26
 * Time: 上午10:34
 */
$this->title = "设置权限";
?>
<div class="add-access">
    <!--标题与面包屑导航-->
    <div class="head clearfix">
        <div class="pull-left">
            <h3>为xxx设置权限</h3>
        </div>
        <div class="pull-right">
            <ul class="breadcrumb">
                <li><a href="/">首页</a></li>
                <li><a href="/role/index">角色列表</a></li>
                <li class="active">设置权限</li>
            </ul>
        </div>
    </div>
    <div class="main">
        <div class="button clearfix">
            <div class="pull-right">
                <a href="javaScript:;" class="btn btn-primary save">保存</a>
            </div>
        </div>
        <div class="list" style="margin-top:10px">
            <table class="table table-bordered table-striped table-responsive">
                <tr>
                    <th><input type="checkbox" name="checkAll"></th>
                    <th>标题</th>
                    <th>Urls</th>
                </tr>
                <?php foreach ($access as $value) :?>
                    <tr>
                        <td>
                            <input type="checkbox" name="check" data-access-id="<?= $value->id ?>"
                                <?php if (in_array($value->id, $data)): ?> checked <?php endif; ?>
                            >
                        </td>
                        <td><?= $value->title ?></td>
                        <td><?= str_replace("\n", '<br>', $value->urls) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <input type="hidden" name="roleId" value="<?=$id?>">
        </div>
    </div>
</div>
<script src="/js/jquery.min.js"></script>
<script>
    $(function () {
        //checkbox全选
        $("input[name='checkAll']").on("click", function () {
            if (this.checked) {
                $("input[name='check']").prop("checked", true);
            } else {
                $("input[name='check']").prop("checked", false);
            }
        });
        //保存
        $(".save").on("click", function () {
            let accessIds = [];
            const roleId = $("input[name='roleId']").val();
            $("input[name='check']").each(function(){
                if (this.checked) {
                    accessIds.push($(this).data("access-id"))
                }
            });
            if (accessIds.length === 0) {
                alert("请选择权限。");
                return false;
            }
            $.ajax({
                type: "POST",
                url: "/role/add-access?id="+roleId,
                dataType: "Json",
                data: {
                    accessIds: accessIds
                },
                success: function (response) {
                    alert(response.message);
                    if (response.status) {
                        window.location.reload();
                    }
                }

            })
        })
    })
</script>
