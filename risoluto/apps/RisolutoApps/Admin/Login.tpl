{*
This file is part of Risoluto( http://www.risoluto.org/ )
Risoluto is released under New BSD License( http://opensource.org/licenses/bsd-license.php )
(C) 2008-2015 Risoluto Developers / All Rights Reserved.
*}
{include file="$__RISOLUTO_APPS/common/header.tpl"}
<h1>Risolutoへのログイン</h1>

{if $autherr == 'auth_failure'}
    <div class="alert alert-danger" role="alert">入力されたユーザIDとパスワードではログインできませんでした</div>
{elseif $autherr == 'invalid_access'}
    <div class="alert alert-info" role="alert">ユーザIDとパスワードを入力し、ログインボタンをクリックしてください</div>
{/if}

<form action="?seq=Admin_Auth" method="post" role="form">
    <div class="form-group">
        <label for="userid">ユーザID</label>
        <input type="text" class="form-control" id="userid" name="userid" placeholder="ユーザIDを入力してください">
        <label for="password">パスワード</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="パスワードを入力してください">
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-default btn-lg btn-block">ログイン</button>
    </div>
</form>
{include file="$__RISOLUTO_APPS/common/footer.tpl"}