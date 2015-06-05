{*
This file is part of Risoluto( http://www.risoluto.org/ )
Risoluto is released under New BSD License( http://opensource.org/licenses/bsd-license.php )
(C) 2008-2015 Risoluto Developers / All Rights Reserved.
*}
{nocache}
<ul class="nav nav-tabs nav-justified">
    <li {if $active_tab == 'user'}class="active"{/if}><a href="?seq=Admin_Menu.user">ユーザメニュー</a></li>
    {if $allow_admintab}
        <li {if $active_tab == 'admin'}class="active"{/if}><a href="?seq=Admin_Menu.admin">管理者メニュー</a></li>
    {/if}
</ul>
{/nocache}