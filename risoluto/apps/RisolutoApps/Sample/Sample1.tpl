{*
This file is part of Risoluto( http://www.risoluto.org/ )
Risoluto is released under New BSD License( http://opensource.org/licenses/bsd-license.php )
(C) 2008-2015 Risoluto Developers / All Rights Reserved.
*}
{include file="$__RISOLUTO_APPS/common/header.tpl"}
<h1>Risolutoサンプル #1</h1>
<h2>URLの指定方法</h2>
<ul>
    <li>アプリケーションを明示的に呼び出すには「http://example.com/Foo」または「http://example.com/?seq=Foo」のように指定します。</li>

    <li>〜/risoluto/apps/RisolutoAppsディレクトリ内のサブディレクトリに格納している場合は、ディレクトリセパレタとして「_」を使用し、
        「http://example.com/Foo_Bar」または「http://example.com/?seq=Foo_Bar」のように指定します。
    </li>
</ul>
{include file="$__RISOLUTO_APPS/common/footer.tpl"}