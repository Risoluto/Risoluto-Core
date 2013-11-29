<?php
/**
 * Risoluto起動ルーチン
 *
 * Risolutoコアクラスインスタンスを作成し、実行する
 *
 * @package       risoluto
 * @author        Risoluto Developers
 * @license       http://opensource.org/licenses/bsd-license.php new BSD license
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

//------------------------------------------------------//
// 定数定義
//------------------------------------------------------//
define('RISOLUTODIR', dirname(dirname(dirname(__FILE__))));

define('RISOLUTO_DOCROOT', RISOLUTODIR . 'public_html');
define('RISOLUTO_SYSROOT', RISOLUTODIR . '/risoluto/');

define('RISOLUTO_APPS', RISOLUTO_SYSROOT . 'apps/');
define('RISOLUTO_CLI', RISOLUTO_SYSROOT . 'cli/');
define('RISOLUTO_CONF', RISOLUTO_SYSROOT . 'conf/');
define('RISOLUTO_DATA', RISOLUTO_SYSROOT . 'data/');
define('RISOLUTO_LIB', RISOLUTO_SYSROOT . 'lib/');

define('RISOLUTO_CACHE', RISOLUTO_DATA . 'cache/');
define('RISOLUTO_LOGS', RISOLUTO_DATA . 'logs/');
define('RISOLUTO_SESS', RISOLUTO_DATA . 'sess/');
define('RISOLUTO_UPLOAD', RISOLUTO_DATA . 'upload/');

define('RISOLUTO_LIB_VENDOR', RISOLUTO_LIB . 'vendor/');

//------------------------------------------------------//
// インクルードパスの変更
//------------------------------------------------------//
set_include_path(RISOLUTO_LIB_VENDOR . PATH_SEPARATOR
    . RISOLUTO_APPS . PATH_SEPARATOR
    . get_include_path());

//------------------------------------------------------//
// オートローダ読み込みと設定
//------------------------------------------------------//
$autoloader = RISOLUTO_LIB_VENDOR . 'autoload.php';

clearstatcache(true);
if (file_exists($autoloader) and is_file($autoloader) and is_readable($autoloader)) {
    // オートローダが存在すれば読み込む
    require_once($autoloader);
} else {
    // 存在しなければ強制終了
    die('autoloader.php was not found');
}
