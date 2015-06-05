{*
This file is part of Risoluto( http://www.risoluto.org/ )
Risoluto is released under New BSD License( http://opensource.org/licenses/bsd-license.php )
(C) 2008-2015 Risoluto Developers / All Rights Reserved.
*}
{include file="$__RISOLUTO_APPS/common/header.tpl"}

{include file="$__RISOLUTO_APPS/common/admin_headmenu.tpl"}

<h1>グループ情報変更（入力）</h1>
{nocache}
{foreach $entered.error.msg as $dat}
    {if $dat == 'invalid_groupid'}
        <div class="alert alert-danger" role="alert">グループIDが不正かすでに存在しています</div>
    {/if}
    {if $dat == 'empty_groupid'}
        <div class="alert alert-danger" role="alert">グループIDが入力されていません</div>
    {/if}
    {if $dat == 'invalid_groupname'}
        <div class="alert alert-danger" role="alert">グループ名が不正です</div>
    {/if}
    {if $dat == 'empty_groupname'}
        <div class="alert alert-danger" role="alert">グループ名が入力されていません</div>
    {/if}
    {if $dat == 'invalid_status'}
        <div class="alert alert-danger" role="alert">ステータスが不正です</div>
    {/if}
    {if $dat == 'empty_status'}
        <div class="alert alert-danger" role="alert">ステータスが入力されていません</div>
    {/if}
{/foreach}
{/nocache}

<form action="?seq=Admin_GroupMng_ModConfirm" method="post" role="form">
    {include file="entrygroup_common.tpl"}

    {nocache}
    <input type="hidden" id="no" name="no" value="{$entered.entered.no}">
    <input type="hidden" id="csrf_token" name="csrf_token" value="{$csrf_token}">
    {/nocache}

    <div class="btn-toolbar" role="toolbar">
        <div class="btn-group btn-group-lg">
            <button type="button" class="btn btn-default" onclick="location.href='?seq=Admin_GroupMng_ListGroups'">&lt;&nbsp;一覧へ戻る</button>
        </div>
        <div class="btn-group btn-group-lg pull-right">
            <button type="submit" class="btn btn-default">確認画面へ&nbsp;&gt;</button>
        </div>
    </div>
</form>

{include file="$__RISOLUTO_APPS/common/footer.tpl"}