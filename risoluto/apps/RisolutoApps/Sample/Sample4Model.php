<?php
/**
 * Sample4Model
 *
 * Sample4用のModelを実現するためのクラス
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
class Sample4Model extends \Risoluto\RisolutoModelBase
{
    /**
     * Begin()
     *
     * モデルの初期処理を行う
     *
     * @access    public
     *
     * @param     void
     *
     * @return    処理結果（true: 成功 / false: 失敗）
     */
    public function Begin()
    {
        // コンフィグから接続情報を取得する
        $db_conf = new \Risoluto\Conf;
        $db_conf->Parse(RISOLUTO_CONF . 'risoluto_db.ini');

        // DBへ接続する
        return $this->db->Connect($db_conf->GetIni('DB'));
    }

    /**
     * GetAll()
     *
     * テーブル中の全データを取得する
     *
     * @access    public
     *
     * @param     void
     *
     * @return    string テーブル中の全データ
     */
    public function GetAll()
    {
        return $this->db->DoQuery("SELECT id, column1, column2 FROM risoluto_db_test;");
    }

    /**
     * End()
     *
     * モデルの最終処理を行う
     *
     * @access    public
     *
     * @param     void
     *
     * @return    void    なし
     */
    public function End()
    {
        // DB接続を解除する
        $this->db->DisConnect();
    }
}