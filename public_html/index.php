<?php
/**
 * コントローラ起動ルーチン
 *
 * コントローラのクラスインスタンスを作成し、実行する
 *
 * @package   risoluto
 * @author    Risoluto Developers
 * @license   http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright (C) 2008-2013 Risoluto Developers / All Rights Reserved.
 */

  //------------------------------------------------------//
  // 動作環境チェック
  //------------------------------------------------------//
  // PHPバージョンが5.0.0以前であれば強制終了
  if ( version_compare( PHP_VERSION, '5.0.0', '<' ) )
  {
    exit( 'Risoluto requires PHP 5.0.0 or later...' );
  } // end of if

  // php.iniの設定値が動作上支障を及ぼす可能性がある場合強制終了
  if (
          ini_get( 'magic_quotes_gpc' )
       or ini_get( 'magic_quotes_runtime' )
       or ini_get( 'magic_quotes_sybase' )
       or ini_get( 'register_globals' )
       or ini_get( 'register_long_arrays' )
       or ini_get( 'safe_mode' )
     )
  {
    exit( 'magic_quotes_gpc/magic_quotes_runtime/magic_quotes_sybase/register_globals/register_long_arrays/safe_mode are MUST be off.' );
  } // end of if

  // OPTIONAL: URLの正規化
//  if ( isset( $_SERVER[ 'SERVER_NAME' ] ) and ! preg_match( '/^www.*/i', $_SERVER[ 'SERVER_NAME' ] ) )
//  {
//    if ( isset( $_SERVER[ 'HTTPS' ] ) and !empty( $_SERVER[ 'HTTPS' ] ) )
//    {
//      header( 'Location: https://www.' . $_SERVER[ 'SERVER_NAME' ] . $_SERVER[ 'REQUEST_URI' ], true, 301 );
//    } // end of if
//    else
//    {
//      header( 'Location: http://www.' . $_SERVER[ 'SERVER_NAME' ] . $_SERVER[ 'REQUEST_URI' ], true, 301 );
//    } // end of else
//    exit;
//  } // end of if

  //------------------------------------------------------//
  // 定数定義
  //------------------------------------------------------//
  define( 'RISOLUTODIR',       dirname( dirname ( __FILE__ ) )     );
  define( 'RISOLUTO_DOCROOT',  dirname ( __FILE__ )                );
  define( 'RISOLUTO_SYSROOT',  RISOLUTODIR . '/risoluto/'          );
  define( 'RISOLUTO_BATCH',    RISOLUTODIR . '/risoluto/batch/'    );
  define( 'RISOLUTO_CACHE',    RISOLUTODIR . '/risoluto/cache/'    );
  define( 'RISOLUTO_CONF',     RISOLUTODIR . '/risoluto/conf/'     );
  define( 'RISOLUTO_DATA',     RISOLUTODIR . '/risoluto/data/'     );
  define( 'RISOLUTO_EXTLIB',   RISOLUTODIR . '/risoluto/extlib/'   );
  define( 'RISOLUTO_FUNC',     RISOLUTODIR . '/risoluto/func/'     );
  define( 'RISOLUTO_LOGS',     RISOLUTODIR . '/risoluto/logs/'     );
  define( 'RISOLUTO_SESS',     RISOLUTODIR . '/risoluto/sess/'     );
  define( 'RISOLUTO_UPLOAD',   RISOLUTODIR . '/risoluto/upload/'   );
  define( 'RISOLUTO_USERLAND', RISOLUTODIR . '/risoluto/userland/' );

  //------------------------------------------------------//
  // インクルードパスの変更
  //------------------------------------------------------//
  set_include_path(                 RISOLUTO_EXTLIB . 'PEAR' 
                 . PATH_SEPARATOR . RISOLUTO_EXTLIB . 'Smarty/libs'
                 . PATH_SEPARATOR . get_include_path() );

  //------------------------------------------------------//
  // コントローラクラスの読み込み
  //------------------------------------------------------//
  require_once( RISOLUTO_FUNC . 'risoluto_core.php' );

  //------------------------------------------------------//
  // コントローラクラスインスタンスの生成と実行
  //------------------------------------------------------//
  $risoluto_instance = RisolutoCore::singleton();
  $risoluto_instance->run();
?>
