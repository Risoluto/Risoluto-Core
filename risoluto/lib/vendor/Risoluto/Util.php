<?php
/**
 * Util
 *
 * ユーティリティファンクション群
 *
 * @package           risoluto
 * @author            Risoluto Developers
 * @license           http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright     (C) 2008-2014 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace Risoluto;

class Util
{
    //------------------------------------------------------//
    // クラスメソッド定義
    //------------------------------------------------------//
    /**
     * GetBaseUrl
     *
     * ベースURLを取得する
     *
     * @access    public
     *
     * @param array $target
     *
     * @internal  param array $_SERVER 相当の情報が格納された配列
     *
     * @return    string    自身のベースURL
     */
    public function GetBaseUrl($target = array('HTTP_HOST' => 'localhost', 'SERVER_PORT' => '80', 'PHP_SELF' => '/'))
    {
        Url::GetBaseUrl($target);
    }

    /**
     * RedirectTo
     *
     * 指定された画面へリダイレクトする
     *
     * @access    public
     *
     * @param     string $target リダイレクト先の画面識別子
     * @param     array  $getKey リダイレクト時に付与するGETパラメタのキー部（配列指定）
     * @param     array  $getVal リダイレクト時に付与するGETパラメタのバリュー部（配列指定）
     *
     * @return    void      なし
     */
    public function RedirectTo($target = null, $getKey = null, $getVal = null)
    {
        Url::RedirectTo($target, $getKey, $getVal);
    }

    /**
     * StatChecker
     *
     * 指定されたファイルやディレクトリのステータスをチェックする
     *
     * @access    public
     *
     * @param     array $target チェック対象の情報が格納された連想配列
     *
     * @return    array    チェック結果が格納された連想配列
     */
    public function StatChecker($target)
    {
        File::StatChecker($target);
    }

    /**
     * FileOperator
     *
     * 指定されたファイルやディレクトリに対し、作成/コピー/移動/削除等を行う
     *
     * @access    public
     *
     * @param     string $operation   処理内容を示す文字列(make/copy/move/unlink/mkdir/rmdir/symlink)
     * @param     string $target      対象となるパス
     * @param     string $destination コピー又は移動先となるパス
     * @param     string $prefix      ファイル中の「[[[_PREFIX]]]」を置換する文字列
     *
     * @return    boolean   処理結果（true:成功/false:失敗）
     */
    public function FileOperator($operation, $target, $destination = null, $prefix = null)
    {
        File::FileOperator($operation, $target, $destination, $prefix);
    }

    /**
     * AutoUrlLink
     *
     * 引数で指定された文字列中の特定部分をリンクに変換する
     *
     * @access    public
     *
     * @param     string  $target    対象となる文字列
     * @param     boolean $newWindow 新規ウィンドウモード:true(新規ウィンドウでオープン))
     * @param     string  $extra     リンクタグに付与するアトリビュート（デフォルト:null）
     *
     * @return    string    変換後の文字列
     */
    public function AutoUrlLink($target, $newWindow = true, $extra = null)
    {
        Text::AutoUrlLink($target, $newWindow, $extra);
    }

    /**
     * IsEmailAddr
     *
     * 引数で指定された値がメールアドレスのフォーマットと合致しているか判定する
     *
     * @access    public
     *
     * @param     string $value 検査対象となる値
     *
     * @return    boolean    判定結果（true/false）
     */
    public function IsEmailAddr($value)
    {
        Validate::IsEmailAddr($value);
    }

    /**
     * IsHalfWidth
     *
     * 引数で指定された値が半角文字列のみで構成されているか判定する
     *
     * @access    public
     *
     * @param     string $value 検査対象となる値
     *
     * @return    boolean    判定結果（true/false）
     */
    function IsHalfWidth($value)
    {
        Validate::IsHalfWidth($value);
    }

    /**
     * IsLeapYear
     *
     * 引数で指定された値が閏年であるか判定する
     *
     * @access    public
     *
     * @param     string $value 検査対象となる値
     *
     * @return    boolean    判定結果（true/false）
     */
    public function IsLeapYear($value)
    {
        Validate::IsLeapYear($value);
    }

    /**
     * IsBetween
     *
     * 引数で指定された値が引数で指定された下限値及び上限値の範囲内にあるかを判定する
     *
     * @access    public
     *
     * @param     string $value    検査対象となる値
     * @param     string $lowerval 下限値
     * @param     string $upperval 上限値
     *
     * @return    boolean    判定結果（true/false）
     */
    public function IsBetween($value, $lowerval, $upperval)
    {
        Validate::IsBetween($value, $lowerval, $upperval);
    }

    /**
     * CnvYear
     *
     * 西暦に対応する和暦を取得する
     *
     * @access    public
     *
     * @param     integer $year 対象となる西暦年（4桁）
     *
     * @return    string  引数に指定された西暦年に対応する和暦年（変換に失敗した場合は空文字を返却）
     */
    public function CnvYear($year)
    {
        Date::CnvYear($year);
    }

    /**
     * GenYear
     *
     * 「年」の情報が格納された配列を生成する
     *
     * @access    public
     *
     * @param boolean $firstType      配列の先頭に未選択状態を示す要素をセットするか（デフォルト：false）
     * @param string  $nonSelectedVal 未選択状態を示す要素の要素値（デフォルト：''）
     * @param string  $nonSelectedStr 未選択状態を示す要素の配列値（デフォルト：''）
     * @param integer $base           生成開始年（西暦指定、デフォルトは現在年 - 5）
     * @param integer $limit          生成年数（デフォルトは10）
     * @param integer $mode           返却する配列のタイプ(デフォルト西暦のみ、0:西暦のみ/1:和暦のみ/2:両方)
     *
     * @return    array     「年」の情報が格納された配列
     */
    public function GenYear($firstType = false, $nonSelectedVal = '', $nonSelectedStr = '', $base = null, $limit = null, $mode = 0)
    {
        Date::GenYear($firstType, $nonSelectedVal, $nonSelectedStr, $base, $limit, $mode);
    }

    /**
     * GenMonth
     *
     * 「月」の情報が格納された配列を生成する
     *
     * @access    public
     *
     * @param boolean $firstType      配列の先頭に未選択状態を示す要素をセットするか（デフォルト：false）
     * @param string  $nonSelectedVal 未選択状態を示す要素の要素値（デフォルト：''）
     * @param string  $nonSelectedStr 未選択状態を示す要素の配列値（デフォルト：''）
     *
     * @return    array     「月」の情報が格納された配列
     */
    public function GenMonth($firstType = false, $nonSelectedVal = '', $nonSelectedStr = '')
    {
        Date::GenMonth($firstType, $nonSelectedVal, $nonSelectedStr);
    }

    /**
     * GenDay
     *
     * 「日」の情報が格納された配列を生成する
     *
     * @access    public
     *
     * @param boolean $firstType      配列の先頭に未選択状態を示す要素をセットするか（デフォルト：false）
     * @param string  $nonSelectedVal 未選択状態を示す要素の要素値（デフォルト：''）
     * @param string  $nonSelectedStr 未選択状態を示す要素の配列値（デフォルト：''）
     * @param array   $target         生成対象となる月と年の連想配列（デフォルト：array('month' => '', year => '')、monthを指定するとその月の日数に基づいた内容が返却され、monthが"2"の場合でyearがセットされていると閏年判定を行う）
     *
     * @return    array     「日」の情報が格納された配列
     */
    public function GenDay($firstType = false, $nonSelectedVal = '', $nonSelectedStr = '', $target = array('month' => '', 'year' => ''))
    {
        Date::GenDay($firstType, $nonSelectedVal, $nonSelectedStr, $target);
    }

    /**
     * GenHour
     *
     * 「時」の情報が格納された配列を生成する
     *
     * @access    public
     *
     * @param boolean $firstType      配列の先頭に未選択状態を示す要素をセットするか（デフォルト：false）
     * @param string  $nonSelectedVal 未選択状態を示す要素の要素値（デフォルト：''）
     * @param string  $nonSelectedStr 未選択状態を示す要素の配列値（デフォルト：''）
     * @param boolean $hourType       表示を24時制にするかどうか（デフォルトtrue、true:24時制/false:12時制、数字の前に「午前」または「午後」がつく）
     *
     * @return    array     「時」の情報が格納された配列
     */
    public function GenHour($firstType = false, $nonSelectedVal = '', $nonSelectedStr = '', $hourType = true)
    {
        Date::GenHour($firstType, $nonSelectedVal, $nonSelectedStr, $hourType);
    }

    /**
     * GenMinSec
     *
     * 「分」または「秒」の情報が格納された配列を生成する
     *
     * @access    public
     *
     * @param boolean $firstType      配列の先頭に未選択状態を示す要素をセットするか（デフォルト：false）
     * @param string  $nonSelectedVal 未選択状態を示す要素の要素値（デフォルト：''）
     * @param string  $nonSelectedStr 未選択状態を示す要素の配列値（デフォルト：''）
     *
     * @return    array     「分」の情報が格納された配列
     */
    public function GenMinSec($firstType = false, $nonSelectedVal = '', $nonSelectedStr = '')
    {
        Date::GenMinSec($firstType, $nonSelectedVal, $nonSelectedStr);
    }
}