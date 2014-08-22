{*
This file is part of Risoluto( http://www.risoluto.org/ )
Risoluto is released under New BSD License( http://opensource.org/licenses/bsd-license.php )
(C) 2008-2014 Risoluto Developers / All Rights Reserved.
*}
{include file="$__RISOLUTO_APPS/common/header.tpl"}
<h1>Risolutoサンプル #4</h1>
<h2>Dbクラスを使ったモデルの作成</h2>
<ul>
    <li>RisolutoではDbを使ったプログラムのために、PDOをラップしたものを中心としたメソッドを含んだDbクラスを用意しています。</li>

    <li>ユーザアプリケーションでModelを作成するために、RisolutoModelBaseというAbstructクラスを用意しています。</li>

    <li>このサンプルでは、それらを使ったアプリケーション例となっています。</li>

    <li>動作させるにはrisoluto/conf/risoluto_db.iniに適切な情報がセットされている必要があります。</li>
</ul>
<h2>Dbの情報を出力</h2>
{if !empty($dat)}
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>column1</th>
            <th>column2</th>
        </tr>
        </thead>
        <tbody>
        {foreach $dat as $dbdat}
            <tr>
                <td>{$dbdat['id']|escape:'htmlall':'UTF-8'}</td>
                <td>{$dbdat['column1']|escape:'htmlall':'UTF-8'}</td>
                <td>{$dbdat['column2']|escape:'htmlall':'UTF-8'}</td>
            </tr>
        {/foreach}
        </tbody>
    </table>
{else}
    <h3>DB接続関連の処理に失敗したか、データがありません</h3>
    <p>
        このサンプルを正常に動作させるには、Risolutoが標準で提供しているPHPUnitがエラーなく終了する環境であることが前提となっています。
    </p>
    <p>
        もし、このサンプルが正常に動作しない場合は、下記の点をチェックしてみてください。
        場合によっては、「risoluto/conf/risoluto_db.ini」やサンプルプログラム自体の修正が必要になることがあります。
    </p>
    <ul>
        <li>MySQLがこのコンピュータにインストールされており、正常に起動するよう構成されていること</li>
        <li>MySQLが起動していること</li>
        <li>MySQLにrootユーザでログインでき、rootユーザにはパスワードが設定されていないこと</li>
        <li>「risoluto_db_test」というDBが存在しており、「risoluto_db_test」というテーブルが作成されていること</li>
        <li>「risoluto_db_test」というテーブルには「id」、「column1」、「column2」の3つのカラムが存在していること</li>
    </ul>
{/if}
{include file="$__RISOLUTO_APPS/common/footer.tpl"}