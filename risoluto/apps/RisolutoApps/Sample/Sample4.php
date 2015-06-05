<?php
/**
 * Sample4
 *
 * Sample画面を実現するためのクラス
 *
 * @package           risoluto
 * @author            Risoluto Developers
 * @license           http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright     (C) 2008-2015 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace RisolutoApps\Sample;

//------------------------------------------------------//
// クラス定義
//------------------------------------------------------//
class Sample4 extends \Risoluto\RisolutoControllerBase implements \Risoluto\RisolutoControllerInterface
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
        // ユーザ定義のライブラリコール例
        \RisolutoUserLibs\SampleLibs::sampleMethod();

        //--- DB関連の操作（ここから）
        // モデルインスタンスを作成する
        $model = new Sample4Model();

        // モデルの初期処理を実行
        $dat = '';
        if ($model->begin()) {

            // 全データを取得する
            $dat = $model->getAll();

            // モデルの最終処理を実行
            $model->end();
        }
        //--- DB関連の操作（ここまで）

        // ヘッダ情報のセット
        $header = $this->getDefaultHeader();
        $header = $this->replaceHeader( $header, 'robots', 'NOINDEX,NOFOLLOW' );

        // テンプレートエンジン関連の処理
        $assign_value = [ 'header' => $header, 'dat' => $dat ];
        $this->risolutoView( $assign_value );
    }
}