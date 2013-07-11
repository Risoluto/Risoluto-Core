<?php
/**
 * ServiceStop
 *
 * サービスストップ画面を実現するためのクラス
 *
 * @package   risoluto
 * @author    Risoluto Developers
 * @license   http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright (C) 2008-2013 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
Use \Base;
Use \Smarty;

//------------------------------------------------------//
// クラス定義
//------------------------------------------------------//
class ServiceStop extends Base
{
    /**
     * Play()
     *
     * 主処理を行う
     *
     * @access    public
     * @param     void    なし
     * @return    void    なし
     */
    public function Play()
    {
        // Smartyオブジェクトの作成と初期設定
        $smarty                = new Smarty;
        $smarty->template_dir  = RISOLUTO_APPS . '';
        $smarty->config_dir    = RISOLUTO_APPS . '';
        $smarty->compile_dir   = RISOLUTO_CACHE;
        $smarty->cache_dir     = RISOLUTO_CACHE;
        $smarty->caching       = false;
        $smarty->debugging     = false;
        $smarty->force_compile = true;
        $smarty->compile_check = true;

        // ヘッダ情報のセットとアサイン
        $header = array(
                           // ROBOTS
                           'robots' => 'NOINDEX,NOFOLLOW',

                           // Description
                           'Description' => 'Risolutoのサービスストップページです',

                           // Keywords
                           'keywords' => 'Risoluto',

                           // Author
                           'author' => 'Risoluto',

                           // CSS
                           'css' => array(
                                             'outboards/vendor/css/common.css'
//                                         ,   'http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css'
                                         ),

                           // JavaScript
                           'js' => array(
                                            'outboards/vendor/js/common.js'
//                                        ,   'http://code.jquery.com/jquery-2.0.3.min.js'
//                                        ,   'http://code.jquery.com/ui/1.10.3/jquery-ui.min.js'
//                                        ,   'http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js'
                                        ),

                           // タイトル
                           'title' => '現在サービスを停止しています！'
                       );

        $smarty->assign( 'header', $header );

        // 画面の表示
        $smarty->display( 'ServiceStop.tpl' );
        return true;
    }
}
