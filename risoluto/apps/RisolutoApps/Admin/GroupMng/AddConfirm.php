<?php
/**
 * AddConfirm
 *
 * グループ追加画面（確認）を実現するためのクラス
 *
 * @package           risoluto
 * @author            Risoluto Developers
 * @license           http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright     (C) 2008-2015 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace RisolutoApps\Admin\GroupMng;

//------------------------------------------------------//
// クラス定義
//------------------------------------------------------//
class AddConfirm extends \Risoluto\RisolutoControllerBase implements \Risoluto\RisolutoControllerInterface
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
        // セッションをスタート
        $sess = new \Risoluto\Session();
        $sess->start();

        // 共通処理クラスを呼び出し
        $common = new \RisolutoApps\Admin\AdminCommon;
        $detail = $common->loginCheck( $sess, true );
        $entered = $common->checkEnteredGroupData( $_POST, $sess->load( 'csrf_token' ) );

        // 入力情報はセッションに保存
        $sess->store( 'form', $entered );

        // エラー情報があった場合は入力画面に戻る
        if (!empty( $entered[ 'error' ][ 'msg' ] ) or !empty( $entered[ 'error' ][ 'form_crit' ] )) {
            \Risoluto\Url::redirectTo( 'Admin_GroupMng_AddEntry' );
            exit;
        }

        // ヘッダ情報のセット
        $header = $this->getDefaultHeader();
        $header = $this->replaceHeader( $header, 'robots', 'NOINDEX,NOFOLLOW' );

        // テンプレートエンジン関連の処理
        $assign_value = [
            'header' => $header,
            'detail' => $detail,
            'entered' => $entered,
            'csrf_token' => $sess->load( 'csrf_token' )
        ];
        $this->risolutoView( $assign_value );
    }
}