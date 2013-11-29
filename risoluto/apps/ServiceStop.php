<?php
/**
 * ServiceStop
 *
 * サービスストップ画面を実現するためのクラス
 *
 * @package       risoluto
 * @author        Risoluto Developers
 * @license       http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright (C) 2008-2013 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
Use \Smarty;

//------------------------------------------------------//
// クラス定義
//------------------------------------------------------//
class ServiceStop extends \Risoluto\RisolutoControllerBase
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

        $header['robots'] = 'noindex,nofollow';
        $header['title']  = '現在サービスを停止しています';

        // テンプレートエンジン関連の処理
        $smarty = $this->InitTemplate();
        $this->AssignTemplate($smarty, array('header' => $header));
        $this->DispTemplate($smarty, 'ServiceStop.tpl');

        return true;
    }
}
