<?php
/**
 * DelConfirm
 *
 * ユーザ削除画面（確認）を実現するためのクラス
 *
 * @package           risoluto
 * @author            Risoluto Developers
 * @license           http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright     (C) 2008-2015 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace RisolutoApps\Admin\UserMng;

//------------------------------------------------------//
// クラス定義
//------------------------------------------------------//
class DelConfirm extends \Risoluto\RisolutoControllerBase implements \Risoluto\RisolutoControllerInterface
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
        $groups = $common->getGroupList( 'id_and_name' );

        $param = $this->getParam();
        if (is_numeric( $param[ 0 ] )) {
            // 引数値がセットされていれば、それを元に登録情報を呼び出す
            $target = \Risoluto\Auth::callProviderMethod( 'showUserByNo', [ 'no' => $param[ 0 ] ] );
            if (empty( $target )) {
                // 情報が取得できなかった場合も例外をThrow
                Throw new \Exception( 'Cannot load user data' );
            }
        } else {
            // 指定されていなければ例外をThrowする
            Throw new \Exception( 'Require args not found' );
        }

        // 情報が取得できたら整形してセッションに保存する
        $getVals[ 'entered' ] = [
            'no' => $target[ 0 ][ 'no' ],
            'userid' => $target[ 0 ][ 'userid' ],
            'username' => $target[ 0 ][ 'username' ],
            'password' => '',
            'password_confirm' => '',
            'groupno' => $target[ 0 ][ 'groupno' ],
            'status' => $target[ 0 ][ 'status' ]
        ];
        $sess->store( 'form', $getVals );

        // ヘッダ情報のセット
        $header = $this->getDefaultHeader();
        $header = $this->replaceHeader( $header, 'robots', 'NOINDEX,NOFOLLOW' );

        // テンプレートエンジン関連の処理
        $assign_value = [
            'header' => $header,
            'detail' => $detail,
            'groups' => $groups,
            'entered' => $getVals,
            'csrf_token' => $sess->load( 'csrf_token' )
        ];
        $this->risolutoView( $assign_value );
    }
}