<?php
/**
 * Sample2
 *
 * Sample2画面を実現するためのクラス
 *
 * @package           risoluto
 * @author            Risoluto Developers
 * @license           http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright     (C) 2008-2014 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace RisolutoApps\Sample;

//------------------------------------------------------//
// クラス定義
//------------------------------------------------------//
class Sample2 extends \Risoluto\RisolutoControllerBase
{
    /**
     * Play()
     *
     * 主処理を行う
     *
     * @access    public
     *
     * @param     void なし
     *
     * @return    void    なし
     */
    public function Play()
    {
        // ヘッダ情報のセット
        $header = $this->GetDefaultHeader();

        $header['robots'] = 'NOINDEX,NOFOLLOW';

        // テンプレートエンジン関連の処理
        $smarty = $this->InitTemplate('Sample/');
        $this->AssignTemplate($smarty, array('header' => $header, 'param' => $this->GetParam(), 'get' => $_GET, 'post' => $_POST, 'server' => $_SERVER));
        $this->DispTemplate($smarty, str_replace(array(__NAMESPACE__, '\\'), '', __CLASS__) . '.tpl');

        return true;
    }
}