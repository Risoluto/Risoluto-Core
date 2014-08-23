{*
This file is part of Risoluto( http://www.risoluto.org/ )
Risoluto is released under New BSD License( http://opensource.org/licenses/bsd-license.php )
(C) 2008-2014 Risoluto Developers / All Rights Reserved.
*}
    </div>
<!-- E n d Body Left Side -->

<!-- Begin Body Right Side -->
    <div class="col-sm-4">
        {if isset($menubar) and !empty($menubar)}
            {$menubar}
        {/if}

        <div class="panel panel-default">
            <div class="panel-heading">Link</div>
            <div class="panel-body">
                <dl>
                    <dt>Powered by Risoluto</dt>
                    <dd>
                        <a href="http://www.risoluto.org" target="_blank">
                            <img src="/outboards/{$header.outboards}/img/risoluto_banner.png"
                                 alt="Build on Risoluto" class="img-responsive">
                        </a>
                    </dd>


                    <dt>Risoluto2.x project core member using PhpStorm(Open Source License)</dt>
                    <dd>
                        <a href="http://www.jetbrains.com/phpstorm/" style="display:block; background:#5854b5 url(http://www.jetbrains.com/phpstorm/documentation/phpstorm_banners/phpstorm1/phpstorm234x60_violet.gif) no-repeat 0 0; border:solid 1px #5854b5; margin:0;padding:0;text-decoration:none;text-indent:0;letter-spacing:-0.001em; width:252px; height:58px" alt="Smart IDE for PHP development with HTML, CSS &amp; JavaScript support" title="Smart IDE for PHP development with HTML, CSS &amp; JavaScript support" target="_blank"><span style="margin: 0px 0 0 59px;padding: 0;float: left;font-size: 10px;cursor:pointer;  background-image:none;border:0;color: #fff; font-family: trebuchet ms,arial,sans-serif;font-weight: normal;text-align:left;">Developed with</span><span style="margin:36px 0 0 7px;padding:0 0 2px 0; line-height:10px;font-size:11px;cursor:pointer;  background-image:none;border:0;display:block;width:240px; color:#fff; font-family:trebuchet ms,arial,sans-serif;font-weight: normal;text-align:left;">Smart IDE for PHP development with HTML, CSS &amp; JavaScript support</span></a><br />
                    </dd>

                    <dt>Risoluto2.x project resources are hosted by GitHub</dt>
                    <dd>
                        <a href = "https://github.com/Risoluto/" target="_blank">GitHub</a>
                    </dd>

                    <dt>Risoluto1.x project resources are hosted by SourceForge.jp</dt>
                    <dd>
                        <a href = "http://sourceforge.jp/" target="_blank">
                            <img src   = "http://sourceforge.jp/sflogo.php?group_id=4106&amp;type=1"
                                 alt   = "SourceForge.JP"
                                 width = "96" height = "31" />
                        </a>
                    </dd>

                    <dt>Website is hosted by CloudCore VPS</dt>
                    <dd>
                        <div style="width:150px; height:80px; margin:0; padding:0;"><a href="http://www.cloudcore.jp/vps/?utm_source=ad&utm_medium=ad&utm_content=dev&utm_campaign=vps" target="_blank" rel="nofollow"><img src="http://www.cloudcore.jp/vps/develop/links/images/150x80_white.gif" alt="CloudCore" style="border:0; margin-bottom:4px;" /></a></div>
                    </dd>
                </dl>
            </div>
        </div>

        {literal}
        <div class="panel panel-default">
            <div class="panel-heading">Follow me!</div>
            <div class="panel-body">
                <a class="twitter-timeline" href="https://twitter.com/risoluto_dev" data-widget-id="406385397602582528">@risoluto_dev からのツイート</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

                <iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FRisoluto%2F184154274969159&width=292&height=
290&colorscheme=light&show_faces=true&border_color&stream=false&header=true&appId=187417324641052" scrolling="no" frameborder="0" style="border:none;
overflow:hidden; width:292px; height:290px;" allowTransparency="true"></iframe>
            </div>
        </div>
        {/literal}
    </div>
</section>
<!-- E n d Body Right Side -->

<!-- Begin Footer -->
<hr/>
<footer class="container-fluid">
    {include file="$__RISOLUTO_APPS/common/copyrights.tpl"}
</footer>
</body>
</html>
