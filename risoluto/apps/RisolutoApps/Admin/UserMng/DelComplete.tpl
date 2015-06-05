{*
This file is part of Risoluto( http://www.risoluto.org/ )
Risoluto is released under New BSD License( http://opensource.org/licenses/bsd-license.php )
(C) 2008-2015 Risoluto Developers / All Rights Reserved.
*}
{include file="$__RISOLUTO_APPS/common/header.tpl"}

{include file="$__RISOLUTO_APPS/common/admin_headmenu.tpl"}

<h1>ユーザ情報削除（完了）</h1>

{nocache}
{if $result}
    <div class="alert alert-success" role="alert">
        ユーザ情報を削除しました（<a href="?seq=Admin_UserMng_ListUsers">ユーザ一覧画面はこちら</a>）
    </div>
{else}
    <div class="alert alert-danger" role="alert">
        ユーザ情報の削除に失敗しました（<a href="?seq=Admin_UserMng_ListUsers">ユーザ一覧画面はこちら</a>）
    </div>
{/if}
{/nocache}

{include file="$__RISOLUTO_APPS/common/footer.tpl"}