<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
 <!-- Begin Head Section -->
 <head>
  <meta http-equiv = "Content-Type"        content = "text/html; charset=UTF-8" />
  <meta http-equiv = "Content-Style-Type"  content = "text/css" />
  <meta http-equiv = "Content-Script-Type" content = "text/javascript" />
  <meta http-equiv = "Cache-Control"       content = "no-cache" />
  <meta http-equiv = "pragma"              content = "no-cache" /> 
  <meta http-equiv = "Expires"             content = "0" />
{if $header.robots != ''}
  <meta name = "robots"                    content = "{$header.robots|strip_tags|escape}" />
{/if}
{if $header.description != ''}
  <meta name = "Description"               content = "{$header.description|strip_tags|escape}" />
{/if}
{if $header.keywords != ''}
  <meta name = "Keywords"                  content = "{$header.keywords|strip_tags|escape}" />
{/if}
{if $header.author != ''}
  <meta name = "Author"                    content = "{$header.author|strip_tags|escape}" />
{/if}
{foreach from=$header.css item=css_item}
{if $css_item != ''}
  <link href = "{$css_item|strip_tags|escape}" rel = "stylesheet" type = "text/css" />
{/if}
{/foreach}
{foreach from=$header.javascript item=js_item}
{if $js_item != ''}
  <script language = "JavaScript" src = "{$js_item|strip_tags|escape}"></script>
{/if}
{/foreach}
{if $header.favicon != ''}
  <link rel="shortcut icon" href = "{$header.favicon|strip_tags|escape}" />
  <link rel="icon"          href = "{$header.favicon|strip_tags|escape}" />
{/if}
  <title>{$header.title|strip_tags|escape}</title>
 </head>
 <!-- E n d Head Section -->
 <!-- Begin Body Section -->
 <body>
  <!-- Begin Header -->
  <div class = "header_left">
   <a href = "index.php">
    <img src   = "img/risoluto_logo.png"
         alt   = "Logo Image"
         width = "400" height = "120" />
   </a>
  </div>
  <div class = "header_right">
    &nbsp;
   <br class = "clear" />
  </div>
  <!-- E n d Header -->



  <!-- Begin Body -->



  <!-- Begin Body Left Side -->
  <div class = "content_left">
