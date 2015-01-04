{*
This file is part of Risoluto( http://www.risoluto.org/ )
Risoluto is released under New BSD License( http://opensource.org/licenses/bsd-license.php )
(C) 2008-2015 Risoluto Developers / All Rights Reserved.
*}
<!DOCTYPE html>
<html lang="ja">
<!-- Begin Head Section -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="{$header.robots|strip_tags|escape|upper|default:'INDEX,FOLLOW'}">
    <meta name="Description" content="{$header.description|strip_tags|escape|default:'Risoluto'}">
    <meta name="Keywords" content="{$header.keywords|strip_tags|escape|default:'Risoluto'}">
    <meta name="Author" content="{$header.author|strip_tags|escape|default:'Risoluto User'}">
    {if count($header.css)}
        {foreach from=$header.css item=css_item}
            <link href="{$css_item|strip_tags|escape}" rel="stylesheet" type="text/css">
        {/foreach}
    {/if}
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    {if count($header.js)}
        {foreach from=$header.js item=js_item}
            <script src="{$js_item|strip_tags|escape}"></script>
        {/foreach}
    {/if}
    <link rel="icon" href="{$header.favicon|strip_tags|escape|default:'outboards/vendor/img/favicon.ico'}"/>
    <title>{$header.title|strip_tags|escape|default:'Risoluto Works!'}</title>
</head>
<!-- E n d Head Section -->
<!-- Begin Body Section -->
<body>
<!-- Begin Body -->
<header class="container-fluid">
    <div class="col-sm-8">
        <a href="/">
            <img src="/outboards/{$header.outboards}/img/risoluto_logo.png" alt="Logo Image" class="img-responsive">
        </a>
    </div>
    <div class="col-sm-4">
        &nbsp;
    </div>
</header>

<!-- Begin Body Left Side -->
<section class="container-fluid">
    <div class="col-sm-8">