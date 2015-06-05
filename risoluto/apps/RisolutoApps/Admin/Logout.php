<?php
/**
 * Logout
 *
 * ログアウト画面を実現するためのクラス
 *
 * @package           risoluto
 * @author            Risoluto Developers
 * @license           http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright     (C) 2008-2015 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace RisolutoApps\Admin;

//------------------------------------------------------//
// クラス定義
//------------------------------------------------------//
class Logout extends \Risoluto\RisolutoControllerBase implements \Risoluto\RisolutoControllerInterface
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

        if (!$sess->isThere( 'Auth' )) {
            // 認証情報がない場合は、ログイン画面へ遷移する
            $sess->store( 'AuthError', 'invalid_access' );
            \Risoluto\Url::redirectTo( 'Admin_Login' );
            exit;
        }

        if ($sess->isThere( 'Auth' )) {
            // セッション情報を破棄する
            $sess->revoke( 'Auth' );
        }

        // ヘッダ情報のセット
        $header = $this->getDefaultHeader();
        $header = $this->replaceHeader( $header, 'robots', 'NOINDEX,NOFOLLOW' );

        // テンプレートエンジン関連の処理
        $assign_value = [ 'header' => $header ];
        $this->risolutoView( $assign_value );
    }
}