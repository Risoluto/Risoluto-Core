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
        //---スキーマ（ポートの値でHTTP/HTTPSのどちらかを判定）
        switch ($target['SERVER_PORT']) {
            // スタンダードなHTTPS
            case '443': // FALL THRU
            case '8443': // FALL THRU
                $schema = 'https://';
                break;

            // デフォルト
            default:
                $schema = 'http://';
                break;
        }

        //---ポート（80と443以外なら「〜:PORTNUMBER」とする）
        $port = '';
        if ($target['SERVER_PORT'] != '80' and $target['SERVER_PORT'] != '443') {
            $port = ':' . $target['SERVER_PORT'];
        }

        //---ホスト名
        $host = $target['HTTP_HOST'];

        //---実行ファイル名（デフォルトの「index.php」が付いている場合は消す）
        $self = str_replace('index.php', '', $target['PHP_SELF']);

        return $schema . $host . $port . $self;
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
        // ベースURLを取得する
        $baseUrl    = $this->GetBaseUrl() . '?seq=' . $target;
        $otherParam = null;

        // 他のパラメタが指定されていたら、それをGETパラメタの形に生成
        if (!empty($getKey) and !empty($getVal)) {
            $tmp_keys = explode(',', $getKey);
            $tmp_vals = explode(',', $getVal);

            // 両方の要素数が合致する場合のみGETパラメタの形式に編集する
            if (count($tmp_keys) == count($tmp_vals)) {
                for ($i = 0; $i < count($tmp_keys); $i++) {
                    $otherParam .= '&' . $tmp_keys[$i] . '=' . $tmp_vals[$i];
                }
            }
        }

        // ヘッダを出力する
        header("Location: $baseUrl$otherParam");
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
        // ローカル変数の初期化
        $result = array(
            'path'   => 'unknown'
        , 'required' => 'unknown'
        , 'real'     => 'unknown'
        , 'result'   => 'unknown'
        );

        // 引数が配列でない場合は即時return
        if (!is_array($target)) {
            return $result;
        }

        // 共通情報はまとめてセット
        $result['path']     = $target['path'];
        $result['required'] = $target['stat'];

        // 対象が存在しない場合は「missing」をセットし、即時return
        clearstatcache();
        if (!file_exists($target['path'])) {
            // 結果をセット
            $result['real']   = 'missing';
            $result['result'] = 'NG';

            return $result;
        }

        // キャッシュステータスのクリア
        clearstatcache();
        // 判定を実施（defaultは書かない）
        // 評価項目を増やすにはここにcaseを追加してください
        switch ($target['stat']) {
            // 読込可
            case 'readable':
                $result['real']   = $target['stat'];
                $result['result'] = ((is_readable($target['path']) and !is_writable($target['path'])) ? 'OK' : 'NG');
                break;

            // 書込可
            case 'writable':
                $result['real']   = 'writable';
                $result['result'] = (is_writable($target['path']) ? 'OK' : 'NG');
                break;
        }

        return $result;
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
        // 処理結果の初期化
        $retVal = false;

        // operationの内容によって、処理を分ける
        switch ($operation) {
            // make
            case 'make':
                if (@touch($target)) {
                    $retVal = true;
                }
                break;

            // copy
            case 'copy':
                if (@copy($target, $destination)) {
                    $retVal = true;
                }
                break;

            // copy with replace
            case 'copy_with_replace':
                // ファイルの中身を一度すべて取得
                $text = @file_get_contents($target);

                // $prefixがセットされていたら置換処理を実施
                if (!empty($prefix)) {
                    $text = str_replace('[[[_PREFIX]]]', $prefix, $text);
                }

                // ファイルを出力
                if (@file_put_contents($destination, $text)) {
                    $retVal = true;
                }
                break;

            // move
            case 'move':
                if (@rename($target, $destination)) {
                    $retVal = true;
                }
                break;

            // unlink
            case 'unlink':
                if (@unlink($target)) {
                    $retVal = true;
                }
                break;

            // mkdir
            case 'mkdir':
                if (@mkdir($target, 0777, true)) {
                    $retVal = true;
                }
                break;

            // rmdir
            case 'rmdir':
                if (@rmdir($target)) {
                    $retVal = true;
                }
                break;

            // symlink
            case 'symlink':
                if (@symlink($target, $destination)) {
                    $retVal = true;
                }
                break;
        }

        return $retVal;
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
        // 一度、一時変数へ格納する
        $tmp_target = $target;

        // リンクタグのベースを組み立てる
        $tmp_replace_text = "<a href='$0'"
            . ($newWindow ? " target='_blank'" : "")
            . (!empty($extra) ? " " . $extra : "")
            . ">$0</a>";

        // 文字列中の「http」又は「https」で始まる部分を、<a>タグに変換する
        $tmp_target = preg_replace("/(http|https)\:\/\/[[:alnum:]-_.!~*'();\/?:@&=+$,%#]+/i", $tmp_replace_text, $tmp_target);

        // タグの途中で改行が入っている場合、取り除く
        $tmp_target = preg_replace("/(\r|\n|\r\n)'>/i", "'>", $tmp_target);
        $tmp_target = preg_replace("/(\r|\n|\r\n)<\/a>/i", "</a>", $tmp_target);

        return $tmp_target;
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
        return (preg_match('/^([a-z0-9_]|\-|\.|\+)+@(([a-z0-9_]|\-)+\.)+[a-z]{2,6}$/i', $value)) ? (true) : (false);
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
        return (strlen($value) == mb_strlen($value, 'UTF-8')) ? (true) : (false);
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
        // 引数が4桁の整数値でなければ無条件でfalseを返却する
        if ((strlen($value) != 4) or (!is_numeric($value))) {
            return false;
        }

        // 4で割り切れる年は閏年、100で割り切れる年は閏年じゃないが400で割り切れれば閏年
        if (($value % 4) == 0 and ($value % 100) != 0 or ($value % 400) == 0) {
            return true;
        } else {
            return false;
        }
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
        // 下限値から上限値の範囲内ならtrueを返却（下限値／上限値自体も範囲に含む）
        if (($lowerval <= $value) and ($upperval >= $value)) {
            return true;
        } else {
            return false;
        }
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
        // 引数に指定された値が、1868年より以前か数字4桁でない場合は空文字を返却する
        if (!is_numeric($year) or strlen($year) != 4 or $year < 1868) {
            return '';
        }

        // 明治（1868年1月25日〜1912年7月29日、明治45年まで）
        if ($this->IsBetween($year, 1868, 1912)) {
            // 算出する
            $retval = $this->GenEraName(($year - 1868) + 1, '明治', '大正', 45);

            // 大正（1912年7月30日〜1926年12月24日、大正15年まで）
        } elseif ($this->IsBetween($year, 1912, 1926)) {
            // 算出する
            $retval = $this->GenEraName(($year - 1912) + 1, '大正', '昭和', 15);

            // 昭和（1926年12月25日〜1989年1月7日、昭和64年まで）
        } elseif ($this->IsBetween($year, 1926, 1989)) {
            // 算出する
            $retval = $this->GenEraName(($year - 1926) + 1, '昭和', '平成', 64);

            // 平成（1989年1月8日〜）
        } else {
            // 算出する
            $retval = $this->GenEraName(($year - 1989) + 1, '平成');
        }

        return $retval;
    }

    /**
     * GenEraName
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
    private function GenEraName($year, $currentEraName, $nextEraName = "", $borderYear = "")
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
                $tmp_JIY = $this->CnvYear(sprintf("%04d", $currentYear));
                // 「両方」の場合は括弧でくくる
                $tmp_JIY = '(' . $tmp_JIY . ')';
            }

            // 配列に追加する
            $retVal[$currentYear] = $tmp_AD . $tmp_JIY;
        }

        return $retVal;
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
        // 配列を生成する
        $retVal = $this->GenNumberList(12, $firstType, $nonSelectedVal, $nonSelectedStr);

        return $retVal;
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
        // 配列を初期化
        $retVal = array();
        if ($firstType) {
            $retVal[$nonSelectedVal] = $nonSelectedStr;
        }

        // 月ごとに日数を決定する
        switch ($target['month']) {

            // 2月はうるう年考慮し、28又は29日まで生成
            case 2:
                $endDay = ((!empty($target['year']) and $this->IsLeapYear($target['year'])) ? 29 : 28);
                break;

            // 4,6,9,11月は30日まで生成
            case 4: // FALL THRU
            case 6: // FALL THRU
            case 9: // FALL THRU
            case 11: // FALL THRU
                $endDay = 30;
                break;

            // 上記以外は31日まで生成するケース
            default:
                $endDay = 31;
                break;
        }

        // 配列を生成する
        $retVal = $this->GenNumberList($endDay, $firstType, $nonSelectedVal, $nonSelectedStr);

        return $retVal;
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
        // 24時間表記の時はそのまま生成
        $retVal = $this->GenNumberList(23, $firstType, $nonSelectedVal, $nonSelectedStr, 0);

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
        // 配列を生成する
        $retVal = $this->GenNumberList(59, $firstType, $nonSelectedVal, $nonSelectedStr, 0);

        return $retVal;
    }

    /**
     * GenNumberList
     *
     * 月、日、時、分、秒用の数字のリストを生成する
     *
     * @access private
     *
     * @param integer $limit          生成する最大数
     * @param boolean $firstType      配列の先頭に未選択状態を示す要素をセットするか（デフォルト：false）
     * @param string  $nonSelectedVal 未選択状態を示す要素の要素値（デフォルト：''）
     * @param string  $nonSelectedStr 未選択状態を示す要素の配列値（デフォルト：''）
     * @param integer  $start          生成する数字の最小値（デフォルト：1）
     * @param string  $format         生成する数字のフォーマット（デフォルト：'$02d'）
     *
     * @return array 数値の配列
     */
    private function GenNumberList($limit, $firstType = false, $nonSelectedVal = '', $nonSelectedStr = '', $start = 1, $format = '%02d')
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