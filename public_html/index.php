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
set_include_path(RISOLUTO_LIB_USR    . PATH_SEPARATOR
               . RISOLUTO_LIB_3RD    . PATH_SEPARATOR
               . RISOLUTO_LIB_VENDOR . PATH_SEPARATOR
               . get_include_path());

//------------------------------------------------------//
// Risolutoコアクラスの読み込み
//------------------------------------------------------//
require_once(RISOLUTO_LIB_VENDOR . 'RisolutoCore.php');

//------------------------------------------------------//
// Risolutoコアクラスインスタンスの生成と実行
//------------------------------------------------------//
$risoluto_instance = new RisolutoCore;
$risoluto_instance->run();
