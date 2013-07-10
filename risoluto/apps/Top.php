<?php
/**
 * Top
 *
 * デフォルト画面を実現するためのクラス
 *
 * @package   risoluto
 * @author    Risoluto Developers
 * @license   http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright (C) 2008-2013 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace RisolutoApps;

Use RisolutoApps\Base;
Use Smarty;

//------------------------------------------------------//
// クラス定義
//------------------------------------------------------//
class Top extends Base
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
        $smarty                = new Smarty;
        $smarty->template_dir  = RISOLUTO_APPS . '';
        $smarty->config_dir    = RISOLUTO_APPS . '';
        $smarty->compile_dir   = RISOLUTO_CACHE;
        $smarty->cache_dir     = RISOLUTO_CACHE;
        $smarty->caching       = false;
        $smarty->debugging     = false;
        $smarty->force_compile = true;
        $smarty->compile_check = true;
        $smarty->display( 'Top.tpl' );
        return true;
    }
}
