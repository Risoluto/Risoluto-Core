{*
This file is part of Risoluto( http://www.risoluto.org/ )
Risoluto is released under New BSD License( http://opensource.org/licenses/bsd-license.php )
(C) 2008-2015 Risoluto Developers / All Rights Reserved.
*}
<div class="form-group{if in_array('userid', $entered.error.form_crit)} has-error has-feedback{/if}">
    <label for="userid">ユーザID&nbsp;<span class="label label-info">必須</span></label>
    <input type="text" class="form-control" id="userid" name="userid" placeholder="ユーザIDを入力してください"
           value="{$entered.entered.userid}">
    {if in_array('userid', $entered.error.form_crit)}
        <span class="glyphicon glyphicon-remove form-control-feedback"></span>
    {/if}
</div>

<div class="form-group{if in_array('username', $entered.error.form_crit)} has-error has-feedback{/if}">
    <label for="username">ユーザ名&nbsp;<span class="label label-info">必須</span></label>
    <input type="text" class="form-control" id="username" name="username" placeholder="ユーザ名を入力してください"
           value="{$entered.entered.username}">
    {if in_array('username', $entered.error.form_crit)}
        <span class="glyphicon glyphicon-remove form-control-feedback"></span>
    {/if}
</div>

<div class="form-group{if in_array('password', $entered.error.form_crit)} has-error has-feedback{/if}">
    <label for="password">パスワード&nbsp;<span class="label label-info">必須</span></label>
    <input type="password" class="form-control" id="password" name="password" placeholder="パスワードを入力してください">
    {if in_array('password', $entered.error.form_crit)}
        <span class="glyphicon glyphicon-remove form-control-feedback"></span>
    {/if}
</div>

<div class="form-group{if in_array('password', $entered.error.form_crit)} has-error has-feedback{/if}">
    <label for="password_confirm">パスワード（再入力）&nbsp;<span class="label label-info">必須</span></label>
    <input type="password" class="form-control" id="password_confirm" name="password_confirm"
           placeholder="パスワードを再度入力してください">
    {if in_array('password', $entered.error.form_crit)}
        <span class="glyphicon glyphicon-remove form-control-feedback"></span>
    {/if}
</div>

<div class="form-group{if in_array('groupno', $entered.error.form_crit)} has-error has-feedback{/if}">
    <label for="groupid">所属グループ&nbsp;<span class="label label-info">必須</span></label>
    <select class="form-control" id="groupno" name="groupno">
        {foreach $groups as $key => $val}
            <option value="{$key}" {if $key == $entered.entered.groupno}selected{/if}>{$val}</option>
        {/foreach}
    </select>
    {if in_array('groupno', $entered.error.form_crit)}
        <span class="glyphicon glyphicon-remove form-control-feedback"></span>
    {/if}
</div>

<div class="form-group{if in_array('status', $entered.error.form_crit)} has-error has-feedback{/if}">
    <label for="status">アカウントステータス&nbsp;<span class="label label-info">必須</span></label>
    <select class="form-control" id="status" name="status">
        <option value="1" {if $entered.entered.status == 1}selected{/if}>有効</option>
        <option value="0" {if $entered.entered.status == 0}selected{/if}>無効</option>
    </select>
    {if in_array('status', $entered.error.form_crit)}
        <span class="glyphicon glyphicon-remove form-control-feedback"></span>
    {/if}
</div>
