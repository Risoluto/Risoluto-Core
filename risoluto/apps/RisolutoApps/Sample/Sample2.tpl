{*
This file is part of Risoluto( http://www.risoluto.org/ )
Risoluto is released under New BSD License( http://opensource.org/licenses/bsd-license.php )
(C) 2008-2014 Risoluto Developers / All Rights Reserved.
*}
{include file="$__RISOLUTO_APPS/common/header.tpl"}
<h1>Risolutoサンプル #2</h1>
<h2>アプリケーションへの値の受け渡し方法について</h2>
<ul>
    <li>アプリケーションに値を渡す際には「.」を使用し、「http://example.com/?seq=Foo_Bar.param1.param2」のように指定します。</li>

    <li>もちろん「http://example.com/?seq=Foo_Bar.param1.param2&amp;param3=param4」のような指定も可能です。</li>

    <li>GETだけではなくPOSTで値を渡すことももちろん可能です。

    <li>$_SERVERなど、PHPで参照できるものについてはRisolutoを使っていても普通に参照できます。</li>
</ul>


<h3>指定された値の表示（Risoluto方式）</h3>
{if !empty($param)}
    <ol>
        {foreach $param as $key => $val}
            <li>{$key|escape:'htmlall':'UTF-8'} -> {$val|escape:'htmlall':'UTF-8'}</li>
        {/foreach}
    </ol>
{else}
    <p>
        このアプリケーションをパラメタを指定して呼び出すと、ここにそのパラメタの内容が表示されます。
    </p>
{/if}

<h3>指定された値の表示（通常のGETパラメタ）</h3>
{if !empty($get)}
    <ol>
        {foreach $get as $key => $val}
            <li>{$key|escape:'htmlall':'UTF-8'} -> {$val|escape:'htmlall':'UTF-8'}</li>
        {/foreach}
    </ol>
{else}
    <p>
        このアプリケーションをGETパラメタを指定して呼び出すと、ここにそのパラメタの内容が表示されます。
    </p>
{/if}

<h3>POSTで渡された値の表示</h3>
<p>
    下のフォームからこのアプリケーションにPOSTすると、ここにその内容が表示されます。
</p>
<form action="?seq=Sample_Sample2" method="POST" class="form-inline" role="form">
    <div class="form-group">
        <label for="form_1">アプリケーションに渡す文字列の指定</label>
        <input type="text" class="form-control" id="post_sample" name="post_sample" placeholder="POSTしたい値を入力">
        <button type="submit" class="btn btn-default">Postする</button>
    </div>
</form>
{if !empty($post)}
    <ol>
        {foreach $post as $key => $val}
            <li>{$key|escape:'htmlall':'UTF-8'} -> {$val|escape:'htmlall':'UTF-8'}</li>
        {/foreach}
    </ol>
{/if}


<h3>その他取得可能な情報の表示（$_SERVER）</h3>
{if !empty($server)}
    <ol>
        {foreach $server as $key => $val}
            <li>{$key|escape:'htmlall':'UTF-8'} -> {$val|escape:'htmlall':'UTF-8'}</li>
        {/foreach}
    </ol>
{else}
    <p>
        このアプリケーションが取得可能な情報はありません。
    </p>
{/if}

{include file="$__RISOLUTO_APPS/common/footer.tpl"}