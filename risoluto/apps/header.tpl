<!DOCTYPE html>
<html lang="ja">
    <!-- Begin Head Section -->
    <head>
        <meta charset="UTF-8">
        <meta name = "robots" content = "{$header.robots|strip_tags|escape|default:'INDEX,FOLLOW'}">
        <meta name = "Description" content = "{$header.description|strip_tags|escape|default:'Risoluto Works!'}">
        <meta name = "Keywords" content = "{$header.keywords|strip_tags|escape|default:'Risoluto'}">
        <meta name = "Author" content = "{$header.author|strip_tags|escape|default:'Risoluto User'}">
        <link href = "outboards/vendor/css/common.css" rel = "stylesheet" type = "text/css">
        <link href = "http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" rel = "stylesheet" type = "text/css">
        {foreach from=$header.css item=css_item}
        <link href = "{$css_item|strip_tags|escape}" rel = "stylesheet" type = "text/css">
        {/foreach}
        <script language = "JavaScript" src = "outboards/vendor/js/common.js"></script>
        <script language = "JavaScript" src = "http://code.jquery.com/jquery-2.0.3.min.js"></script>
        <script language = "JavaScript" src = "http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
        <script language = "JavaScript" src = "http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
        {foreach from=$header.javascript item=js_item}
        <script language = "JavaScript" src = "{$js_item|strip_tags|escape}"></script>
        {/foreach}
        <link rel="icon"          href = "{$header.favicon|strip_tags|escape|default:'outboards/vendor/img/favicon.ico'}" />
        <title>{$header.title|strip_tags|escape|default:'Risoluto Works!'}</title>
    </head>
    <!-- E n d Head Section -->
    <!-- Begin Body Section -->
    <body>
        <!-- Begin Body -->
        <div class="header_left">
            <a href="/">
                <img src="outboards/vendor/img/risoluto_logo.png" alt="Logo Image" width="200" height="60" style="padding-top: 15px; padding-left: 15px;">
            </a>
        </div>
        <div class="header_right">
            &nbsp;
        </div>
        <br class="clear">

        <!-- Begin Body Left Side -->
        <div class="content_left">
