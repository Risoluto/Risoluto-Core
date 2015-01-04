{*
This file is part of Risoluto( http://www.risoluto.org/ )
Risoluto is released under New BSD License( http://opensource.org/licenses/bsd-license.php )
(C) 2008-2015 Risoluto Developers / All Rights Reserved.
*}
<div class="form-group{if in_array('groupid', $entered.error.form_crit)} has-error has-feedback{/if}">
    <label for="userid">グループID&nbsp;<span class="label label-info">必須</span></label>
    <input type="text" class="form-control" id="groupid" name="groupid" placeholder="グループIDを入力してください"
           value="{$entered.entered.groupid}">
    {if in_array('userid', $entered.error.form_crit)}
    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
    {/if}
</div>

<div class="form-group{if in_array('groupname', $entered.error.form_crit)} has-error has-feedback{/if}">
    <label for="username">グループ名&nbsp;<span class="label label-info">必須</span></label>
    <input type="text" class="form-control" id="groupname" name="groupname" placeholder="グループ名を入力してください"
           value="{$entered.entered.groupname}">
    {if in_array('username', $entered.error.form_crit)}
        <span class="glyphicon glyphicon-remove form-control-feedback"></span>
    {/if}
</div>

<div class="form-group{if in_array('status', $entered.error.form_crit)} has-error has-feedback{/if}">
    <label for="status">グループステータス&nbsp;<span class="label label-info">必須</span></label>
    <select class="form-control" id="status" name="status">
        <option value="1" {if $entered.entered.status == 1}selected{/if}>有効</option>
        <option value="0" {if $entered.entered.status == 0}selected{/if}>無効</option>
    </select>
    {if in_array('status', $entered.error.form_crit)}
        <span class="glyphicon glyphicon-remove form-control-feedback"></span>
    {/if}
</div>
