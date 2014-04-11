{*
This file is part of Risoluto( http://www.risoluto.org/ )
Risoluto is released under New BSD License( http://opensource.org/licenses/bsd-license.php )
(C) 2008-2014 Risoluto Developers / All Rights Reserved.
*}
<!DOCTYPE html>
<html lang="ja">
<!-- Begin Head Section -->
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="{$header.robots|strip_tags|escape|default:'INDEX,FOLLOW'}">
    <meta name="Description" content="{$header.description|strip_tags|escape|default:'Risoluto'}">
    <meta name="Keywords" content="{$header.keywords|strip_tags|escape|default:'Risoluto'}">
    <meta name="Author" content="{$header.author|strip_tags|escape|default:'Risoluto User'}">
    {if count($header.css)}
        {foreach from=$header.css item=css_item}
            <link href="{$css_item|strip_tags|escape}" rel="stylesheet" type="text/css">
        {/foreach}
    {/if}
    {if count($header.js)}
        {foreach from=$header.js item=js_item}
            <script language="JavaScript" src="{$js_item|strip_tags|escape}"></script>
        {/foreach}
    {/if}
    <link rel="icon" href="{$header.favicon|strip_tags|escape|default:'outboards/vendor/img/favicon.ico'}"/>
    <title>{$header.title|strip_tags|escape|default:'Risoluto Works!'}</title>
</head>
<!-- E n d Head Section -->
<!-- Begin Body Section -->
<body>
<!-- Begin Body -->
<div class="header_left">
    <a href="/">
        <img src="outboards/vendor/img/risoluto_logo.png" alt="Logo Image" width="467" height="128"
             style="padding-top: 15px; padding-left: 15px;">
    </a>
</div>
<div class="header_right">
    &nbsp;
</div>
<br class="clear">

<!-- Begin Body Left Side -->
<div class="content_left">
