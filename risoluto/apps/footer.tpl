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
          <a href="http://www.risoluto.org" onclick="window.open('http://www.risoluto.org');return false;">
            <img src   = "img/risoluto_banner.png"
                 alt   = "Build on Risoluto"
                 width = "81" height = "31" />
          </a>
        </dd>
        <dt>Risoluto is hosted by SourceForge.jp</dt>
        <dd>
          <a href = "http://sourceforge.jp/" onclick="window.open('http://sourceforge.jp/');return false;">
            <img src   = "http://sourceforge.jp/sflogo.php?group_id=4106&amp;type=1"
                 alt   = "SourceForge.JP"
                 width = "96" height = "31" />
          </a>
        </dd>
        <dt>All pages are valid XHTML 1.0 Strict</dt>
        <dd>
          <a href = "http://validator.w3.org/check?uri=referer" onclick="window.open('http://validator.w3.org/check?uri=referer');return false;">
            <img src   = "http://www.w3.org/Icons/valid-xhtml10-blue"
                 alt   = "Valid XHTML 1.0 Strict"
                 width = "88" height = "31" />
          </a>
        </dd>
        <dt>All CSSs are valid CSS2.1</dt>
        <dd>
          <a href = "http://jigsaw.w3.org/css-validator/check/referer" onclick="window.open('http://jigsaw.w3.org/css-validator/check/referer');return false;">
            <img style="border:0;width:88px;height:31px"
                 src   = "http://jigsaw.w3.org/css-validator/images/vcss-blue"
                 alt = "正当なCSSです!" />
          </a>
        </dd>
      </dl>
    </div>

  </div>
  <!-- E n d Body Right Side -->

  <!-- Begin Footer -->

  <p><br class = "clear" /></p>

  <hr />

  {assign var="tpl_dir" value=$smarty.const.RISOLUTO_USERLAND}
  {include file="$tpl_dir/common/copyrights.tpl"}
 </body>
</html>
