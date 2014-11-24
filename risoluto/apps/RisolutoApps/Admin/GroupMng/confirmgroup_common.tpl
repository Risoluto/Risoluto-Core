{*
This file is part of Risoluto( http://www.risoluto.org/ )
Risoluto is released under New BSD License( http://opensource.org/licenses/bsd-license.php )
(C) 2008-2014 Risoluto Developers / All Rights Reserved.
*}
<div class="table-responsive">
    <table class="table">
        <tr>
            <th>グループID</th>
            <td>{$entered.entered.groupid}</td>
        </tr>
        <tr>
            <th>グループ名</th>
            <td>{$entered.entered.groupname}</td>
        </tr>
        <tr>
            <th>ステータス</th>
            <td>{if $entered.entered.status == 1}有効{else}無効{/if}</td>
        </tr>
    </table>
</div>

