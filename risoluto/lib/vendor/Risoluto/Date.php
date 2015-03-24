<?php
/**
 * Date
 *
 * 日付操作のためのファンクション群
 *
 * @package           risoluto
 * @author            Risoluto Developers
 * @license           http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright     (C) 2008-2015 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace Risoluto;

class Date
{
    //------------------------------------------------------//
    // クラスメソッド定義
    //------------------------------------------------------//
    /**
     * __construct()
     *
     * コンストラクタ
     */
    private function __construct()
    {
    }

    /**
     * cnvYear($year)
     *
     * 西暦に対応する和暦を取得する
     *
     * @access    public
     *
     * @param     integer $year 対象となる西暦年（4桁）
     *
     * @return    string  引数に指定された西暦年に対応する和暦年（変換に失敗した場合は空文字を返却）
     */
    public static function cnvYear($year)
    {
        // 引数に指定された値が、1868年より以前か数字4桁でない場合は空文字を返却する
        if (!is_numeric($year) or strlen($year) != 4 or $year < 1868) {
            return '';
        }

        // 明治（1868年1月25日〜1912年7月29日、明治45年まで）
        if (Validate::isBetween($year, 1868, 1912)) {
            // 算出する
            $retval = self::genEraName(($year - 1868) + 1, '明治', '大正', 45);

            // 大正（1912年7月30日〜1926年12月24日、大正15年まで）
        } elseif (Validate::isBetween($year, 1912, 1926)) {
            // 算出する
            $retval = self::genEraName(($year - 1912) + 1, '大正', '昭和', 15);

            // 昭和（1926年12月25日〜1989年1月7日、昭和64年まで）
        } elseif (Validate::isBetween($year, 1926, 1989)) {
            // 算出する
            $retval = self::genEraName(($year - 1926) + 1, '昭和', '平成', 64);

            // 平成（1989年1月8日〜）
        } else {
            // 算出する
            $retval = self::genEraName(($year - 1989) + 1, '平成');
        }

        return $retval;
    }

    /**
     * genEraName($year, $currentEraName, $nextEraName = '', $borderYear = '')
     *
     * @access private
     *
     * @param integer $year           年
     * @param string  $currentEraName 和暦年号
     * @param string  $nextEraName    次の和暦年号
     * @param string  $borderYear     次の和暦年号との境界年
     *
     * @return string 生成された和暦年号表記
     */
    private static function genEraName($year, $currentEraName, $nextEraName = '', $borderYear = '')
    {
        // 1年の場合は元年として表示する
        if ($year == '1') {
            $retval = $currentEraName . '元年';
        } else {
            // 年号を生成する
            $retval = $currentEraName . $year . '年';

            // 境界年の場合は、両方の年号を併記する
            if (!empty($nextEraName) and !empty($borderYear) and $year == $borderYear) {
                $retval .= ' / ' . $nextEraName . '元年';
            }
        }

        return $retval;
    }

    /**
     * genYear($firstType = false, $nonSelectedVal = '', $nonSelectedStr = '', $base = null, $limit = null, $mode = 0)
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
    public static function genYear($firstType = false, $nonSelectedVal = '', $nonSelectedStr = '', $base = null, $limit = null, $mode = 0)
    {
        // 配列を初期化
        $retVal = array();
        if ($firstType) {
            $retVal[$nonSelectedVal] = $nonSelectedStr;
        }

        // 生成開始年の設定
        $beginYear = date('Y') - 5;
        if (is_numeric($base) and strlen($base) == 4) {
            $beginYear = $base;
        }

        // 生成年数の設定
        $endYearCnt = 10;
        if (is_numeric($limit) and $limit > 0) {
            $endYearCnt = $limit;
        }

        // 引数で指定された配列のタイプに合わせて年のリストを作成する
        for ($cnt = 0; $cnt < $endYearCnt; $cnt++) {
            //--- 処理中の年
            $currentYear = $beginYear + $cnt;

            //--- 「和暦のみ」以外の時は西暦表示を生成
            $tmp_AD = '';
            if ($mode != '1') {
                $tmp_AD = sprintf("%04d", $currentYear);
            }

            //--- 「西暦のみ」以外の時は和暦表示を生成
            $tmp_JIY = '';
            if ($mode != '0') {
                $tmp_JIY = self::CnvYear(sprintf("%04d", $currentYear));
                // 「両方」の場合は括弧でくくる
                $tmp_JIY = '(' . $tmp_JIY . ')';
            }

            // 配列に追加する
            $retVal[$currentYear] = $tmp_AD . $tmp_JIY;
        }

        return $retVal;
    }

    /**
     * genMonth($firstType = false, $nonSelectedVal = '', $nonSelectedStr = '')
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
    public static function genMonth($firstType = false, $nonSelectedVal = '', $nonSelectedStr = '')
    {
        // 配列を生成する
        $retVal = self::genNumberList(12, $firstType, $nonSelectedVal, $nonSelectedStr);

        return $retVal;
    }

    /**
     * genDay($firstType = false, $nonSelectedVal = '', $nonSelectedStr = '', $target = array('month' => '', 'year' => ''))
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
    public static function genDay($firstType = false, $nonSelectedVal = '', $nonSelectedStr = '', $target = array('month' => '', 'year' => ''))
    {
        // 配列を初期化
        $retVal = array();
        if ($firstType) {
            $retVal[$nonSelectedVal] = $nonSelectedStr;
        }

        // 月ごとに日数を決定する
        $endDay = date("t", mktime(0, 0, 0, $target['month'], 1, $target['year']));

        // 配列を生成する
        $retVal = self::genNumberList($endDay, $firstType, $nonSelectedVal, $nonSelectedStr);

        return $retVal;
    }

    /**
     * genHour($firstType = false, $nonSelectedVal = '', $nonSelectedStr = '', $hourType = true)
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
    public static function genHour($firstType = false, $nonSelectedVal = '', $nonSelectedStr = '', $hourType = true)
    {
        // 24時間表記の時はそのまま生成
        $retVal = self::genNumberList(23, $firstType, $nonSelectedVal, $nonSelectedStr, 0);

        //12時間表記の時は午前／午後表記に変更する
        if (!$hourType) {
            foreach ($retVal as $key => $val) {
                if ($key != $nonSelectedVal) {
                    $retVal[$key] = (($key <= 11) ? sprintf("午前%02d", $val) : sprintf("午後%02d", $val - 12));
                }
            }
        }

        return $retVal;
    }

    /**
     * genMinSec($firstType = false, $nonSelectedVal = '', $nonSelectedStr = '')
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
    public static function genMinSec($firstType = false, $nonSelectedVal = '', $nonSelectedStr = '')
    {
        // 配列を生成する
        $retVal = self::genNumberList(59, $firstType, $nonSelectedVal, $nonSelectedStr, 0);

        return $retVal;
    }

    /**
     * genNumberList($limit, $firstType = false, $nonSelectedVal = '', $nonSelectedStr = '', $start = 1, $format = '%02d')
     *
     * 月、日、時、分、秒用の数字のリストを生成する
     *
     * @access private
     *
     * @param integer $limit          生成する最大数
     * @param boolean $firstType      配列の先頭に未選択状態を示す要素をセットするか（デフォルト：false）
     * @param string  $nonSelectedVal 未選択状態を示す要素の要素値（デフォルト：''）
     * @param string  $nonSelectedStr 未選択状態を示す要素の配列値（デフォルト：''）
     * @param integer $start          生成する数字の最小値（デフォルト：1）
     * @param string  $format         生成する数字のフォーマット（デフォルト：'$02d'）
     *
     * @return array 数値の配列
     */
    private static function genNumberList($limit, $firstType = false, $nonSelectedVal = '', $nonSelectedStr = '', $start = 1, $format = '%02d')
    {
        // 引数に応じて配列の先頭を制御
        $retVal = array();
        if ($firstType) {
            $retVal[$nonSelectedVal] = $nonSelectedStr;
        }

        // 配列を生成する
        for ($cnt = $start; $cnt <= $limit; $cnt++) {
            $tmpVal          = sprintf($format, $cnt);
            $retVal[$tmpVal] = $tmpVal;
        }

        return $retVal;
    }
}