<?php
/**
 * Risoluto起動ルーチン
 *
 * Risolutoコアクラスインスタンスを作成し、実行する
 *
 * @package   risoluto
 * @author    Risoluto Developers
 * @license   http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright (C) 2008-2013 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace Risoluto;

//------------------------------------------------------//
// 動作環境チェック
//------------------------------------------------------//
// PHPバージョンが指定された以前のものであれば強制終了
if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    exit('Risoluto requires PHP 5.5.0 or later...');
}

// // OPTIONAL: URLの正規化
// if (isset($_SERVER['SERVER_NAME']) and !preg_match('/^www.*/i', $_SERVER['SERVER_NAME'])) {
//     header('Location: ' . ((isset($_SERVER['HTTPS']) and !empty($_SERVER['HTTPS'])) ? 'https' : 'http')
//                         . '://www.' $_SERVER[ 'SERVER_NAME' ] . $_SERVER[ 'REQUEST_URI' ], true, 301);
//     exit;
// }

//------------------------------------------------------//
// 定数定義
//------------------------------------------------------//
define('RISOLUTODIR', dirname(dirname(__FILE__)));

define('RISOLUTO_DOCROOT', dirname(__FILE__));
define('RISOLUTO_SYSROOT', RISOLUTODIR . '/risoluto/');

define('RISOLUTO_APPS', RISOLUTODIR . '/risoluto/apps/');
define('RISOLUTO_CLI',  RISOLUTODIR . '/risoluto/cli/');
define('RISOLUTO_CONF', RISOLUTODIR . '/risoluto/conf/');
define('RISOLUTO_DATA', RISOLUTODIR . '/risoluto/data/');
define('RISOLUTO_LIB',  RISOLUTODIR . '/risoluto/lib/');

define('RISOLUTO_CACHE',  RISOLUTO_DATA . 'cache/');
define('RISOLUTO_LOGS',   RISOLUTO_DATA . 'logs/');
define('RISOLUTO_SESS',   RISOLUTO_DATA . 'sess/');
define('RISOLUTO_UPLOAD', RISOLUTO_DATA . 'upload/');

define('RISOLUTO_LIB_USR',    RISOLUTO_LIB . 'usr/');
define('RISOLUTO_LIB_3RD',    RISOLUTO_LIB . '3rd/');
define('RISOLUTO_LIB_VENDOR', RISOLUTO_LIB . 'vendor/');

//------------------------------------------------------//
// インクルードパスの変更
//------------------------------------------------------//
set_include_path(RISOLUTO_LIB_3RD    . PATH_SEPARATOR
               . RISOLUTO_LIB_USR    . PATH_SEPARATOR
               . RISOLUTO_LIB_VENDOR . PATH_SEPARATOR
               . RISOLUTO_APPS       . PATH_SEPARATOR
               . get_include_path());

//------------------------------------------------------//
// オートローダ読み込みと設定
//------------------------------------------------------//
$autoloader = RISOLUTO_LIB_3RD . 'SplClassLoader.php';

clearstatcache(true);
if(file_exists($autoloader) and is_file($autoloader) and is_readable($autoloader)) {
    // オートローダが存在すれば読み込む
    require_once($autoloader);
} else {
    // 存在しなければ強制終了
    die('[Risoluto:FATAL ERROR]Cannot find and/or load auto loader.');
}

// 3rd Partyライブラリの読み込み設定
$cl_3rd = new SplClassLoader('', RISOLUTO_LIB_3RD);
$cl_3rd->register();

// ユーザライブラリの読み込み設定
$cl_usr = new SplClassLoader('RisolutoUsrLib', RISOLUTO_LIB_USR);
$cl_usr->register();

// Vendorライブラリの読み込み設定
$cl_vendor = new SplClassLoader('Vendor', RISOLUTO_LIB_VENDOR);
$cl_vendor->register();

// Risolutoライブラリの読み込み設定
$cl_risoluto = new SplClassLoader('Risoluto', RISOLUTO_LIB_VENDOR . 'Risoluto');
$cl_risoluto->register();

// Risolutoアプリケーションの読み込み設定
$cl_apps = new SplClassLoader('RisolutoApps', RISOLUTO_APPS);
$cl_apps->register();

//------------------------------------------------------//
// Risolutoコアクラスインスタンスの生成と実行
//------------------------------------------------------//
$risoluto_instance = new Risoluto\Core;
$risoluto_instance->Perform();
