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
class Sample2 extends \Risoluto\RisolutoControllerBase implements \Risoluto\RisolutoControllerInterface
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
        // ユーザ定義のライブラリコール例
        \RisolutoUserLibs\SampleLibs::SampleMethod();

        // ヘッダ情報のセット
        $header = $this->GetDefaultHeader();
        $header = $this->ReplaceHeader($header, 'robots', 'NOINDEX,NOFOLLOW');


        // テンプレートエンジン関連の処理
        $assign_value = array(
            'header' => $header,
            'param'  => $this->GetParam(),
            'get'    => $_GET,
            'post'   => $_POST,
            'server' => $_SERVER
        );
        $this->RisolutoView($assign_value);
    }
}