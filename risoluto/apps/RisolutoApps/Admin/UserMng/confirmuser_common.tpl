{*
This file is part of Risoluto( http://www.risoluto.org/ )
Risoluto is released under New BSD License( http://opensource.org/licenses/bsd-license.php )
(C) 2008-2015 Risoluto Developers / All Rights Reserved.
*}
{nocache}
<div class="table-responsive">
    <table class="table">
        <tr>
            <th>ユーザID</th>
            <td>{$entered.entered.userid}</td>
        </tr>
        <tr>
            <th>ユーザ名</th>
            <td>{$entered.entered.username}</td>
        </tr>
        <tr>
            <th>パスワード</th>
            <td>（セキュリティ上の理由により表示されません）</td>
        </tr>
        <tr>
            <th>所属グループ</th>
            <td>{$groups[$entered.entered.groupno].name}</td>
        </tr>
        <tr>
            <th>ステータス</th>
            <td>{if $entered.entered.status == 1}有効{else}無効{/if}</td>
        </tr>
    </table>
</div>
{/nocache}