{*
This file is part of Risoluto( http://www.risoluto.org/ )
Risoluto is released under New BSD License( http://opensource.org/licenses/bsd-license.php )
(C) 2008-2014 Risoluto Developers / All Rights Reserved.
*}
{include file="$__RISOLUTO_APPS/common/header.tpl"}
<script type="application/javascript">
    $(function () {
        $("#risoluto_menu").menu(
                {
                    position: {
                        my: "center",
                        at: "right+4 bottom+45"
                    }
                }
        );
    });
</script>
<ul id="risoluto_menu" class="risoluto_menu">
    <li class="ui-state-disabled"><a href="#">メニュー1</a></li>
    <li><a href="#">メニュー2</a></li>
    <li><a href="#">メニュー3</a></li>
    <li>
        <a href="#">メニュー4</a>
        <ul>
            <li class="ui-state-disabled"><a href="#">メニュー4-1</a></li>
            <li><a href="#">メニュー4-2</a></li>
            <li><a href="#">メニュー4-3</a></li>
        </ul>
    </li>
    <li>
        <a href="#">メニュー5</a>
        <ul>
            <li><a href="#">メニュー5-1</a></li>
            <li><a href="#">メニュー5-2</a></li>
            <li>
                <a href="#">メニュー5-3</a>
                <ul>
                    <li class="ui-state-disabled"><a href="#">メニュー5-3-1</a></li>
                    <li><a href="#">メニュー5-3-2</a></li>
                    <li><a href="#">メニュー5-3-3</a></li>
                </ul>
            </li>
        </ul>
    </li>
    <li>
        <a href="#">メニュー6</a>
        <ul>
            <li><a href="#">メニュー6-1</a></li>
            <li><a href="#">メニュー6-2</a></li>
            <li>
                <a href="#">メニュー6-3</a>
                <ul>
                    <li><a href="#">メニュー6-3-1</a></li>
                    <li><a href="#">メニュー6-3-2</a></li>
                    <li>
                        <a href="#">メニュー6-3-3</a>
                        <ul>
                            <li class="ui-state-disabled"><a href="#">メニュー6-3-3-1</a></li>
                            <li><a href="#">メニュー6-3-3-2</a></li>
                            <li><a href="#">メニュー6-3-3-3</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
</ul>

<hr>

<h1>RisolutoのCSS確認用(h1)</h1>

<h2>RisolutoのCSS確認用(h2)</h2>

<h3>RisolutoのCSS確認用(h3)</h3>

<h4>RisolutoのCSS確認用(h4)</h4>

<h5>RisolutoのCSS確認用(h5)</h5>

<h6>RisolutoのCSS確認用(h6)</h6>

<hr>

<p>
    RisolutoのCSS確認用(p)
    <a href="#">RisolutoのCSS確認用(p &gt; a)</a>
</p>

<div>
    RisolutoのCSS確認用(div)
    <a href="#">RisolutoのCSS確認用(div &gt; a)</a>
</div>

<pre>
    RisolutoのCSS確認用(pre)
    <a href="#">RisolutoのCSS確認用(pre &gt; a)</a>
</pre>

<blockquote>
    RisolutoのCSS確認用(blockquote)
    <a href="#">RisolutoのCSS確認用(blockquote &gt; a)</a>
</blockquote>

<hr>

<table>
    <thead>
    <tr>
        <th>RisolutoのCSS確認用(th)</th>
        <th>RisolutoのCSS確認用(th)</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>RisolutoのCSS確認用(td)</td>
        <td><strong>RisolutoのCSS確認用(td)</strong></td>
    </tr>

    <tr>
        <td class="ok">RisolutoのCSS確認用(td、ok)</td>
        <td class="ok"><strong>RisolutoのCSS確認用(td、ok、storong)</strong></td>
    </tr>

    <tr>
        <td class="warning">RisolutoのCSS確認用(td、warning)</td>
        <td class="warning"><strong>RisolutoのCSS確認用(td、warning、storong)</strong></td>
    </tr>

    <tr>
        <td class="critical">RisolutoのCSS確認用(td、critical)</td>
        <td class="critical"><strong>RisolutoのCSS確認用(td、critical、storong)</strong></td>
    </tr>
    </tbody>
</table>

<hr>

<ul>
    <li>RisolutoのCSS確認用(ul &gt; li)</li>
    <li>RisolutoのCSS確認用(ul &gt; li)</li>
    <li>RisolutoのCSS確認用(ul &gt; li)</li>
</ul>

<ol>
    <li>RisolutoのCSS確認用(ol &gt; li)</li>
    <li>RisolutoのCSS確認用(ol &gt; li)</li>
    <li>RisolutoのCSS確認用(ol &gt; li)</li>
</ol>

<dl>
    <dt>RisolutoのCSS確認用(dl &gt; dt)</dt>
    <dd>RisolutoのCSS確認用(dl &gt; dd)</dd>

    <dt>RisolutoのCSS確認用(dl &gt; dt)</dt>
    <dd>RisolutoのCSS確認用(dl &gt; dd)</dd>

    <dt>RisolutoのCSS確認用(dl &gt; dt)</dt>
    <dd>RisolutoのCSS確認用(dl &gt; dd)</dd>
</dl>
{include file="$__RISOLUTO_APPS/common/footer.tpl"}