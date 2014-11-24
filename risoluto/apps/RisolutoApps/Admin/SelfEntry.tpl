{*
This file is part of Risoluto( http://www.risoluto.org/ )
Risoluto is released under New BSD License( http://opensource.org/licenses/bsd-license.php )
(C) 2008-2014 Risoluto Developers / All Rights Reserved.
*}
{include file="$__RISOLUTO_APPS/common/header.tpl"}

{include file="$__RISOLUTO_APPS/common/admin_headmenu.tpl"}

<h1>ユーザ情報変更（入力）</h1>
{foreach $entered.error.msg as $dat}
    {if $dat == 'invalid_current_password'}
        <div class="alert alert-danger" role="alert">現在のパスワードが不正です</div>
    {/if}
    {if $dat == 'empty_current_password'}
        <div class="alert alert-danger" role="alert">現在のパスワードが入力されていません</div>
    {/if}
    {if $dat == 'invalid_password'}
        <div class="alert alert-danger" role="alert">変更後のパスワードまたは変更後のパスワード（再入力）が不正です</div>
    {/if}
    {if $dat == 'empty_password'}
        <div class="alert alert-danger" role="alert">変更後のパスワードまたは変更後のパスワード（再入力）が入力されていません</div>
    {/if}
{/foreach}

<form action="?seq=Admin_SelfComplete" method="post" role="form">

    <div class="form-group{if in_array('current_password', $entered.error.form_crit)} has-error has-feedback{/if}">
        <label for="current_password">現在のパスワード&nbsp;<span class="label label-info">必須</span></label>
        <input type="password" class="form-control" id="current_password" name="current_password" placeholder="現在のパスワードを入力してください">
        {if in_array('current_password', $entered.error.form_crit)}
            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
        {/if}
    </div>

    <div class="form-group{if in_array('password', $entered.error.form_crit)} has-error has-feedback{/if}">
        <label for="password">変更後のパスワード&nbsp;<span class="label label-info">必須</span></label>
        <input type="password" class="form-control" id="password" name="password" placeholder="変更後のパスワードを入力してください">
        {if in_array('password', $entered.error.form_crit)}
            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
        {/if}
    </div>

    <div class="form-group{if in_array('password', $entered.error.form_crit)} has-error has-feedback{/if}">
        <label for="password_confirm">変更後のパスワード（再入力）&nbsp;<span class="label label-info">必須</span></label>
        <input type="password" class="form-control" id="password_confirm" name="password_confirm"
               placeholder="変更後のパスワードを再度入力してください">
        {if in_array('password', $entered.error.form_crit)}
            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
        {/if}
    </div>

    <input type="hidden" id="csrf_token" name="csrf_token" value="{$csrf_token}">

    <div class="btn-toolbar" role="toolbar">
        <div class="btn-group btn-group-lg">
            <button type="button" class="btn btn-default" onclick="location.href='?seq=Admin_Menu'">&lt;&nbsp;メニューへ戻る</button>
        </div>
        <div class="btn-group btn-group-lg pull-right">
            <button type="submit" class="btn btn-default">変更する&nbsp;&gt;</button>
        </div>
    </div>
</form>

{include file="$__RISOLUTO_APPS/common/footer.tpl"}