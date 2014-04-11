{*
This file is part of Risoluto( http://www.risoluto.org/ )
Risoluto is released under New BSD License( http://opensource.org/licenses/bsd-license.php )
(C) 2008-2014 Risoluto Developers / All Rights Reserved.
*}
</div>
<!-- E n d Body Left Side -->

<!-- Begin Body Right Side -->
<div class="content_right">
    {if isset($menubar) and !empty($menubar)}
        {$menubar}
    {/if}
    <div class="content_header">
        LINK
    </div>
    <div class="content_content">
        <dl>
            <dt>Powered by Risoluto</dt>
            <dd>
                <a href="http://www.risoluto.org" target="_blank">
                    <img src="outboards/{$header.outboards}/img/risoluto_banner.png"
                         alt="Build on Risoluto"
                         width="81" height="31">
                </a>
            </dd>
        </dl>
    </div>
</div>
<!-- E n d Body Right Side -->

<!-- Begin Footer -->
<p><br class="clear"></p>

<hr/>

{include file="$__RISOLUTO_APPS/common/copyrights.tpl"}
</body>
</html>
