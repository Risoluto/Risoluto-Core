{*
This file is part of Risoluto( http://www.risoluto.org/ )
Risoluto is released under New BSD License( http://opensource.org/licenses/bsd-license.php )
(C) 2008-2014 Risoluto Developers / All Rights Reserved.
*}
{include file="$__RISOLUTO_APPS/common/header.tpl"}

{include file="$__RISOLUTO_APPS/common/admin_headmenu.tpl"}

<h1>グループ管理</h1>

<div class="btn-toolbar" role="toolbar">
    <div class="btn-group btn-group-lg pull-right">
        <button type="button" class="btn btn-default" onclick="location.href='?seq=Admin_GroupMng_AddEntry'">新規グループ追加</button>
    </div>
</div>

{if $list}
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>グループID</th>
                <th>グループ名</th>
                <th>状態</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$list item=dat}
                <tr>
                    <td>{$dat.groupid}</td>
                    <td>{$dat.groupname}</td>
                    <td {if $dat.status == 1}class="bg-success" {else}class="bg-danger"{/if}>
                        {if $dat.status == 1}有効{else}無効{/if}
                    </td>
                    <td>
                        <div class="btn-toolbar" role="toolbar">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm"
                                        onclick="location.href='?seq=Admin_GroupMng_ModPreload.{$dat.no}'">変更
                                </button>
                            </div>
                            {if $dat.no != '1'}
                                <div class="btn-group pull-right">
                                    <button type="button" class="btn btn-danger btn-sm"
                                            onclick="location.href='?seq=Admin_GroupMng_DelConfirm.{$dat.no}'">削除
                                    </button>
                                </div>
                            {/if}
                        </div>
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
{else}
    <div class="alert alert-warning" role="alert">グループが登録されていません</div>
{/if}
{include file="$__RISOLUTO_APPS/common/footer.tpl"}