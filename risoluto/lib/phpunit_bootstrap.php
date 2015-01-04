<?php
/**
 * phpunit_bootstrap.php
 *
 * PHPUnitによるテストを実行する
 *
 * @package           risoluto
 * @author            Risoluto Developers
 * @license           http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright     (C) 2008-2015 Risoluto Developers / All Rights Reserved.
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
if (!defined('RISOLUTODIR')) {
    define('RISOLUTODIR', dirname(dirname(dirname(__FILE__))));
}
if (!defined('RISOLUTO_DOCROOT')) {
    define('RISOLUTO_DOCROOT', RISOLUTODIR . 'public_html');
}
if (!defined('RISOLUTO_SYSROOT')) {
    define('RISOLUTO_SYSROOT', RISOLUTODIR . '/risoluto/');
}
if (!defined('RISOLUTO_APPS')) {
    define('RISOLUTO_APPS', RISOLUTO_SYSROOT . 'apps/');
}
if (!defined('RISOLUTO_CLI')) {
    define('RISOLUTO_CLI', RISOLUTO_SYSROOT . 'cli/');
}
if (!defined('RISOLUTO_CONF')) {
    define('RISOLUTO_CONF', RISOLUTO_SYSROOT . 'conf/');
}
if (!defined('RISOLUTO_DATA')) {
    define('RISOLUTO_DATA', RISOLUTO_SYSROOT . 'data/');
}
if (!defined('RISOLUTO_LIB')) {
    define('RISOLUTO_LIB', RISOLUTO_SYSROOT . 'lib/');
}
if (!defined('RISOLUTO_CACHE')) {
    define('RISOLUTO_CACHE', RISOLUTO_DATA . 'cache/');
}
if (!defined('RISOLUTO_LOGS')) {
    define('RISOLUTO_LOGS', RISOLUTO_DATA . 'logs/');
}
if (!defined('RISOLUTO_SESS')) {
    define('RISOLUTO_SESS', RISOLUTO_DATA . 'sess/');
}
if (!defined('RISOLUTO_UPLOAD')) {
    define('RISOLUTO_UPLOAD', RISOLUTO_DATA . 'upload/');
}
if (!defined('RISOLUTO_LIB_VENDOR')) {
    define('RISOLUTO_LIB_VENDOR', RISOLUTO_LIB . 'vendor/');
}
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
