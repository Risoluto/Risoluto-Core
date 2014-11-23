{*
This file is part of Risoluto( http://www.risoluto.org/ )
Risoluto is released under New BSD License( http://opensource.org/licenses/bsd-license.php )
(C) 2008-2014 Risoluto Developers / All Rights Reserved.
*}
{include file="$__RISOLUTO_APPS/common/header.tpl"}

{include file="$__RISOLUTO_APPS/common/admin_headmenu.tpl"}

{include file="$__RISOLUTO_APPS/common/admin_headtabs.tpl"}

{if $active_tab == 'user'}
    <h1>ユーザメニュー</h1>

    <div class="col-sm-6">
        <h2>メニュー1</h2>
        <button type="button" class="btn btn-default btn-lg btn-block">要素その1</button>
        <button type="button" class="btn btn-default btn-lg btn-block">要素その2</button>
    </div>
    <div class="col-sm-6">
        <h2>メニュー2</h2>
        <button type="button" class="btn btn-default btn-lg btn-block">要素その1</button>
        <button type="button" class="btn btn-default btn-lg btn-block">要素その2</button>
    </div>
{elseif $active_tab == 'admin'}
    <h1>管理メニュー</h1>

    <div class="col-sm-6">
        <h2>ユーザ／グループ管理</h2>
        <button type="button" class="btn btn-default btn-lg btn-block"
                onclick="location.href='?seq=Admin_UserMng_ListUsers'">ユーザ管理
        </button>
        <button type="button" class="btn btn-default btn-lg btn-block"
                onclick="location.href='?seq=Admin_GroupMng_ListGroups'">グループ管理
        </button>
    </div>
    <div class="col-sm-6">
        <h2>メニュー2</h2>
        <button type="button" class="btn btn-default btn-lg btn-block">要素その1</button>
        <button type="button" class="btn btn-default btn-lg btn-block">要素その2</button>
    </div>
{/if}

{include file="$__RISOLUTO_APPS/common/footer.tpl"}