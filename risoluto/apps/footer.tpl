        </div>
        <!-- E n d Body Left Side -->

        <!-- Begin Body Right Side -->
        <div class = "content_right">
            {$menubar|default:"&nbsp;"}
            <div class = "content_header">
                リンク
            </div>
            <div class = "content_content">
                <dl>
                    <dt>Powered by Risoluto</dt>
                    <dd>
                        <a href="http://www.risoluto.org" target="_blank">
                            <img src   = "img/risoluto_banner.png"
                                 alt   = "Build on Risoluto"
                                 width = "81" height = "31">
                        </a>
                    </dd>
                </dl>
            </div>
        </div>
        <!-- E n d Body Right Side -->

        <!-- Begin Footer -->
        <p><br class = "clear"></p>

        <hr />

        {assign var="tpl_dir" value=$smarty.const.RISOLUTO_APPS}
        {include file="$tpl_dir/copyrights.tpl"}
    </body>
</html>
