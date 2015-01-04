{*
This file is part of Risoluto( http://www.risoluto.org/ )
Risoluto is released under New BSD License( http://opensource.org/licenses/bsd-license.php )
(C) 2008-2015 Risoluto Developers / All Rights Reserved.
*}
{include file="$__RISOLUTO_APPS/common/header.tpl"}

{include file="$__RISOLUTO_APPS/common/admin_headmenu.tpl"}

<h1>ユーザ情報変更（確認）</h1>

<p>
    この内容でよろしいですか？
</p>

{include file="confirmuser_common.tpl"}

<div class="btn-toolbar" role="toolbar">
    <div class="btn-group btn-group-lg">
        <button type="button" class="btn btn-default" onclick="location.href='?seq=Admin_UserMng_ModEntry'">&lt;&nbsp;入力画面へ戻る</button>
    </div>
    <div class="btn-group btn-group-lg pull-right">
        <button type="button" class="btn btn-default" onclick="location.href='?seq=Admin_UserMng_ModComplete'">この内容に変更する&nbsp;&gt;</button>
    </div>
</div>

{include file="$__RISOLUTO_APPS/common/footer.tpl"}