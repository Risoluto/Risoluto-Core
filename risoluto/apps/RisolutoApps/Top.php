<?php
/**
 * Top
 *
 * デフォルト画面を実現するためのクラス
 *
 * @package           risoluto
 * @author            Risoluto Developers
 * @license           http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright     (C) 2008-2014 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace RisolutoApps;

//------------------------------------------------------//
// クラス定義
//------------------------------------------------------//
class Top extends \Risoluto\RisolutoControllerBase implements \Risoluto\RisolutoControllerInterface
{
    // View関連の処理を使用する
    use \Risoluto\RisolutoViewTrait;

    /**
     * Play()
     *
     * 主処理を行う
     *
     * @access    public
     *
     * @param     void
     *
     * @return    void    なし
     */
    public function Play()
    {
        // ヘッダ情報のセット
        $header = $this->GetDefaultHeader();
        $header = $this->ReplaceHeader($header, 'robots', 'NOINDEX,NOFOLLOW');

        // テンプレートエンジン関連の処理
        $assign_value = array('header' => $header);
        $this->RisolutoView($assign_value);
    }
}