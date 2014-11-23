{*
This file is part of Risoluto( http://www.risoluto.org/ )
Risoluto is released under New BSD License( http://opensource.org/licenses/bsd-license.php )
(C) 2008-2014 Risoluto Developers / All Rights Reserved.
*}
{include file="$__RISOLUTO_APPS/common/header.tpl"}

{include file="$__RISOLUTO_APPS/common/admin_headmenu.tpl"}

<h1>ユーザ情報変更（入力）</h1>
{foreach $entered.error.msg as $dat}
    {if $dat == 'invalid_userid'}
        <div class="alert alert-danger" role="alert">ユーザIDが不正かすでに存在しています</div>
    {/if}
    {if $dat == 'empty_userid'}
        <div class="alert alert-danger" role="alert">ユーザIDが入力されていません</div>
    {/if}
    {if $dat == 'invalid_username'}
        <div class="alert alert-danger" role="alert">ユーザ名が不正です</div>
    {/if}
    {if $dat == 'empty_username'}
        <div class="alert alert-danger" role="alert">ユーザ名が入力されていません</div>
    {/if}
    {if $dat == 'invalid_password'}
        <div class="alert alert-danger" role="alert">パスワードまたはパスワード（再入力）が不正です</div>
    {/if}
    {if $dat == 'empty_password'}
        <div class="alert alert-danger" role="alert">パスワードまたはパスワード（再入力）が入力されていません</div>
    {/if}
    {if $dat == 'invalid_groupno'}
        <div class="alert alert-danger" role="alert">所属グループが不正です</div>
    {/if}
    {if $dat == 'empty_groupno'}
        <div class="alert alert-danger" role="alert">所属グループが入力されていません</div>
    {/if}
    {if $dat == 'invalid_status'}
        <div class="alert alert-danger" role="alert">アカウントステータスが不正です</div>
    {/if}
    {if $dat == 'empty_status'}
        <div class="alert alert-danger" role="alert">アカウントステータスが入力されていません</div>
    {/if}
{/foreach}

<form action="?seq=Admin_UserMng_ModConfirm" method="post" role="form">
    {include file="entryuser_common.tpl"}

    <input type="hidden" id="no" name="no" value="{$entered.entered.no}">
    <input type="hidden" id="csrf_token" name="csrf_token" value="{$csrf_token}">

    <div class="btn-toolbar" role="toolbar">
        <div class="btn-group btn-group-lg">
            <button type="button" class="btn btn-default" onclick="location.href='?seq=Admin_UserMng_ListUsers'">&lt;&nbsp;一覧へ戻る</button>
        </div>
        <div class="btn-group btn-group-lg pull-right">
            <button type="submit" class="btn btn-default"">確認画面へ&nbsp;&gt;</button>
        </div>
    </div>
</form>

{include file="$__RISOLUTO_APPS/common/footer.tpl"}