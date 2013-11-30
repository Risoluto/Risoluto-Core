{include file="$__RISOLUTO_APPS/common/header.tpl"}
<h1>Risolutoサンプル #1</h1>
<h2>URLの指定方法</h2>
<ul>
    <li>アプリケーションを明示的に呼び出すには「http://example.com/?seq=Foo」のように指定します。</li>

    <li>〜/risoluto/apps/RisolutoAppsディレクトリ内のサブディレクトリに格納している場合は、ディレクトリセパレタとして「_」を使用し、
        「http://example.com/?seq=Foo_Bar」のように指定します。
    </li>

    <li>アプリケーションにパラメタを渡す際には「.」を使用し、「http://example.com/?seq=Foo_Bar.param1.param2」のように指定します。</li>

    <li>もちろん「http://example.com/?seq=Foo_Bar.param1.param2&param3=param4」のような指定も可能です。</li>
</ul>
{include file="$__RISOLUTO_APPS/common/footer.tpl"}