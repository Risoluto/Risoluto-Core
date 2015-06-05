<?php
/**
 * Error
 *
 * エラー画面を実現するためのクラス
 *
 * @package           risoluto
 * @author            Risoluto Developers
 * @license           http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright     (C) 2008-2015 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace RisolutoApps;

//------------------------------------------------------//
// クラス定義
//------------------------------------------------------//
class Error extends \Risoluto\RisolutoControllerBase implements \Risoluto\RisolutoControllerInterface
{
    // View関連の処理を使用する
    use \Risoluto\RisolutoViewTrait;

    /**
     * play()
     *
     * 主処理を行う
     *
     * @access    public
     *
     * @param     void
     *
     * @return    void    なし
     */
    public function play()
    {
        // ヘッダ情報のセット
        $header = $this->getDefaultHeader();
        $header = $this->replaceHeader( $header, 'robots', 'NOINDEX,NOFOLLOW' );
        $header = $this->replaceHeader( $header, 'title', 'エラーが発生しました' );

        // テンプレートエンジン関連の処理
        $assign_value = [ 'header' => $header ];
        $this->risolutoView( $assign_value );
    }
}