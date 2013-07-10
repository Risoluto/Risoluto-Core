<?php
/**
 * Util
 *
 * ユーティリティファンクション群
 *
 * @package   risoluto
 * @author    Risoluto Developers
 * @license   http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright (C) 2008-2013 Risoluto Developers / All Rights Reserved.
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
     * GetBaseUrl()
     *
     * ベースURLを取得する
     *
     * @access    public
     * @param     void      なし
     * @return    string    自身のベースURL
     */
    public function GetBaseUrl()
    {
        //---スキーマ
        if($_SERVER['SERVER_PORT'] == '80') {
            $schema = 'http://';
        } else {
            $schema = 'https://';
        }

        //---ホスト名
        $host = $_SERVER['HTTP_HOST'];

        //---実行ファイル名（デフォルトの「index.php」が付いている場合は消す）
        $self = str_replace('index.php', '', $_SERVER['PHP_SELF']);

        return $schema . $host . $self;
    }

    /**
     * RedirectTo($target = null, $getkey = null, $getval = null)
     *
     * 指定された画面へリダイレクトする
     *
     * @access    public
     * @param     string    リダイレクト先の画面識別子
     * @param     array     リダイレクト時に付与するGETパラメタのキー部（配列指定）
     * @param     array     リダイレクト時に付与するGETパラメタのバリュー部（配列指定）
     * @return    void      なし
     */
    public function RedirectTo($target = null, $getkey = null, $getval = null)
    {
        // ベースURLを取得する
        $baseurl = $this->GetBaseUrl() . '?seq=' . $target;
        $otherparam = null;

        // 他のパラメタが指定されていたら、それをGetパラメタの形に生成
        if (!empty($getkey) and !empty($getval)) {
            $tmp_keys = explode(',', $getkey);
            $tmp_vals = explode(',', $getval);

            // 両方の要素数が合致しない場合は処理を行わない
            if (count($tmp_keys) == count($tmp_vals)) {
              for ($i = 0; $i < count($tmp_keys); $i++) {
                $otherParam .= '&' . $tmp_keys[$i] . '=' . $tmp_vals[$i];
              }
            }
        }

        // ヘッダを出力する
        header("Location: $baseurl$otherParam");
    }

    /**
     * StatChecker($target)
     *
     * 指定されたファイルやディレクトリのステータスをチェックする
     *
     * @access    public
     * @param     array    チェック対象の情報が格納された連想配列
     * @return    array    チェック結果が格納された連想配列
     */
    public function StatChecker($target)
    {
        // ローカル変数の初期化
        $result = array(
                         'path'     => 'unknown'
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
        switch($target['stat']) {
            // 読込可
            case 'readable':
                if (is_readable($target['path']) and !is_writable($target['path'])) {
                    // 結果をセット
                    $result['real']   = 'readable';
                    $result['result'] = 'OK';
                } else {
                    // 結果をセット
                    $result['real']   = 'writable';
                    $result['result'] = 'NG';
                }
                break;

            // 書込可
            case 'writable':
                if (is_writable($target['path'])) {
                    // 結果をセット
                    $result['real']   = 'writable';
                    $result['result'] = 'OK';
                } else {
                    // 結果をセット
                    $result['real']   = 'readable';
                    $result['result'] = 'NG';
                }
                break;
        }

        return $result;
    }

    /**
     * FileOperator($operation, $target, $destination = null, $prefix = null)
     *
     * 指定されたファイルやディレクトリに対し、作成/コピー/移動/削除等を行う
     *
     * @access    public
     * @param     string    処理内容を示す文字列(make/copy/move/unlink/mkdir/rmdir/symlink)
     * @param     string    対象となるパス
     * @param     string    コピー又は移動先となるパス
     * @param     string    ファイル中の「[[[_PREFIX]]]」を置換する文字列
     * @return    boolean   処理結果（true:成功/false:失敗）
     */
    public function FileOperator($operation, $target, $destination = null, $prefix = null)
    {
        // 処理結果の初期化
        $result = false;

        // operationの内容によって、処理を分ける
        switch($operation) {
            // make
            case 'make':
                if (@touch($target)) {
                    $result = true;
                }
                break;

            // copy
            case 'copy':
                if (@copy($target, $destination)) {
                    $result = true;
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
                    $result = true;
                }
                break;

            // move
            case 'move':
                if (@rename($target, $destination)) {
                    $result = true;
                }
                break;

            // unlink
            case 'unlink':
                if (@unlink($target)) {
                    $result = true;
                }
                break;

            // mkdir
            case 'mkdir':
                if (@mkdir($target, 0777, true)) {
                    $result = true;
                }
                break;

            // rmdir
            case 'rmdir':
                if (@rmdir($target)) {
                    $result = true;
                }
                break;

            // symlink
            case 'symlink':
                if (@symlink($target, $destination)) {
                    $result = true;
                }
                break;
        }

        return $result;
    }

    /**
     * AutoUrlLink($target, $newwindow = true, $extra=null)
     *
     * 引数で指定された文字列中の特定部分をリンクに変換する
     *
     * @access    public
     * @param     string    対象となる文字列
     * @param     boolean   新規ウィンドウモード:true(新規ウィンドウでオープン))
     * @param     string    リンクタグに付与するアトリビュート（デフォルト:null）
     * @return    string    変換後の文字列
     */
    public function AutoUrlLink($target, $newwindow = true, $extra=null)
    {
        // 一度、一時変数へ格納する
        $tmp_target = $target;

        // リンクタグのベースを組み立てる
        $tmp_replace_text = "<a href='$0' "
                          . ($newwindow ? "target='_blank'":"")
                          . (!empty($extra) ? $extra:"")
                          . ">$0</a>";

        // 文字列中の「http」又は「https」で始まる部分を、<a>タグに変換する
        $tmp_target = preg_replace("/(http|https)\:\/\/[[:alnum:]-_.!~*'();\/?:@&=+$,%#]+/i", $tmp_replace_text, $tmp_target);

        // タグの途中で改行が入っている場合、取り除く
        $tmp_target = preg_replace("/(\r|\n|\r\n)'>/i",    "'>",   $tmp_target);
        $tmp_target = preg_replace("/(\r|\n|\r\n)<\/a>/i", "</a>", $tmp_target);

        // <a>タグ以外のタグを消し去る
        $tmp_target = strip_tags($tmp_target, "<a>");

        return $tmp_target;
    }

    /**
     * IsEmailAddr($value)
     *
     * 引数で指定された値がメールアドレスのフォーマットと合致しているか判定する
     *
     * @access    public
     * @param     string     検査対象となる値
     * @return    boolean    判定結果（true/false）
     */
    public function IsEmailAddr($value)
    {
        return (preg_match('/^([a-z0-9_]|\-|\.|\+)+@(([a-z0-9_]|\-)+\.)+[a-z]{2,6}$/i', $value)) ? (true):(false);
    }

    /**
     * IsHalfWidth($value)
     *
     * 引数で指定された値が半角文字列のみで構成されているか判定する
     *
     * @access    public
     * @param     string     検査対象となる値
     * @return    boolean    判定結果（true/false）
     */
    function IsHalfWidth($value)
    {
        return (strlen($value) == mb_strlen($value)) ? (true):(false);
    }

    /**
     * IsLeapYear($value)
     *
     * 引数で指定された値が閏年であるか判定する
     *
     * @access    public
     * @param     string     検査対象となる値
     * @return    boolean    判定結果（true/false）
     */
    public function IsLeapYear($value)
    {
        // 引数が4桁の整数値でなければ無条件でfalseを返却する
        if ((strlen($value) != 4) and (!is_numeric($value))) {
            return false;
        }

        // 4で割り切れ、100で割り切れず、400で割り切れる場合のみうるう年とみなす
        if (($value % 4) == 0 and ($value % 100) != 0 and ($value % 400) == 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * IsBetween($value, $lowerval, $upperval)
     *
     * 引数で指定された値が引数で指定された下限値及び上限値の範囲内にあるかを判定する
     *
     * @access    public
     * @param     string     検査対象となる値
     * @param     string     下限値
     * @param     string     上限値
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
     * CnvYear($year)
     *
     * 西暦に対応する和暦を取得する
     *
     * @access    public
     * @param     integer    対象となる西暦年（4桁）
     * @return    string     引数に指定された西暦年に対応する和暦年（変換に失敗した場合はnullを返却）
     */
    public function CnvYear($year)
    {
        // 変数の初期化
        $retval = null;

        // 引数に指定された値が、1868年より以前か数字4桁でない場合はnullを返却する
        if (!is_numeric($year) or strlen($year) != 4 or $year < 1868) {
            return null;
        }

        // 明治（1868年1月25日〜1912年7月29日、明治45年まで）
        if ($this->IsBetween($year, 1868, 1912)) {
            // 算出する
            $tmp_val = ($year - 1869) + 1;

            // 1年の場合は元年として表示する
            if ($tmp_val == '1') {
                $retval = '明治元年';
            } else {
                // 年号を生成する
                $retval = '明治' . $tmp_val . '年';

                // 境界年の場合は、両方の年号を併記する
                if ($tmp_val == '45') {
                    $retval .= '/ 大正元年';
                }
            }
        // 大正（1912年7月30日〜1926年12月24日、大正15年まで）
        } elseif ($this->IsBetween($year, 1912, 1926)) {
            // 算出する
            $tmp_val = ($year - 1912) + 1;

            // 1年の場合は元年として表示する
            if ($tmp_val == '1') {
                $retval = '大正元年';
            // 年号を生成する
            } else {
                $retval = '大正' . $tmp_val . '年';

                // 境界年の場合は、両方の年号を併記する
                if ($tmp_val == '15') {
                    $retval .= '/ 明治元年';
                }
            }
        // 昭和（1926年12月25日〜1989年1月7日、昭和64年まで）
        } elseif ($this->IsBetween($year, 1926, 1989)) {
            // 算出する
            $tmp_val = ($year - 1926) + 1;

            // 1年の場合は元年として表示する
            if ($tmp_val == '1') {
                $retval = '昭和元年';
            // 年号を生成する
            } else {
                $retval = '昭和' . $tmp_val . '年';

                // 境界年の場合は、両方の年号を併記する
                if ($tmp_val == '64') {
                    $retval .= '/ 平成元年';
                }
            }
        // 平成（1989年1月8日〜）
        } else {
            // 算出する
            $tmp_val = ($year - 1989) + 1;

            // 1年の場合は元年として表示する
            if ($tmp_val == '1') {
                $retval = '平成元年';
            // 年号を生成する
            } else {
                $retval = '平成' . $tmp_val . '年';
            }
        }

        return $retval;
    }

    /**
     * GenYear($firsttype = false, $base = null, $limit = null, $mode = 0)
     *
     * 「年」の情報が格納された配列を生成する
     *
     * @access    public
     * @param     boolean    配列の先頭を「----」にするかどうか（デフォルトfalse、true:----をセットする/false:----をセットしない）
     * @param     integer    生成開始年（西暦指定、デフォルトは現在年 - 5）
     * @param     integer    生成年数（デフォルトは10）
     * @param     integer    返却する配列のタイプ(デフォルト西暦のみ、0:西暦のみ/1:和暦のみ/2:両方)
     * @return    array     「年」の情報が格納された配列
     */
    public function GenYear($firsttype = false, $base = null, $limit = null, $mode = 0)
    {
        // 配列を初期化
        $tmp_year = array();
        if ($firsttype) {
            $tmp_year["----"] = "----";
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

        // 配列を生成する
        for ($cnt = 0; $cnt <= $endYearCnt; $cnt++) {
            // 引数で指定された配列のタイプに合わせて値を作成する
            switch($mode) {
                // 両方の場合
                case 2:
                    $tmp_value = sprintf("%04d", $beginYear + $cnt) . '(' . $this->CnvYear(sprintf("%04d", $beginYear + $cnt)) . ')';
                    break;

                // 和暦のみの場合
                case 1:
                    $tmp_value = $this->CnvYear(sprintf("%04d", $beginYear + $cnt));
                    break;

                // 西暦のみの場合
                case 0: // FALL THRU
                default:
                    $tmp_value = sprintf("%04d", $beginYear + $cnt);
                    break;
            }

            // 配列に追加する
            $tmp_year[$beginYear + $cnt] = $tmp_value;
        }

        return $tmp_year;
    }

    /**
     * GenMonth($firsttype = false)
     *
     * 「月」の情報が格納された配列を生成する
     *
     * @access    public
     * @param     boolean    配列の先頭を「--」にするかどうか（デフォルトfalse、true: --をセットする / false: --をセットしない ）
     * @return    array     「月」の情報が格納された配列
     */
    public function GenMonth($firsttype = false)
    {
        // 配列を初期化
        $tmp_month = array();
        if ($firsttype) {
            $tmp_month["--"] = "--";
        }

        // 配列を生成する
        for ($cnt = 1; $cnt <= 12; $cnt++) {
            $tmp_month[sprintf("%02d", $cnt)] = sprintf("%02d", $cnt);
        }

        return $tmp_month;
    }

    /**
     * GenDay($firsttype = false, $targetmonth = null, $targetyear = null)
     *
     * 「日」の情報が格納された配列を生成する
     *
     * @access    public
     * @param     boolean    配列の先頭を「--」にするかどうか（デフォルトfalse、true:--をセットする/false:--をセットしない）
     * @param     integer    生成対象となる月（値を指定するとその月の日数に基づいた内容が返却される）
     * @param     integer    生成対象となる年（値を指定するとその年がうるう年かどうかを考慮する）
     * @return    array     「日」の情報が格納された配列
     */
    public function GenDay($firsttype = false, $targetmonth = null, $targetyear = null)
    {
        // 配列を初期化
        $tmp_day = array();
        if ($firsttype) {
            $tmp_day["--"] = "--";
        }

        // 月ごとに日数を決定する
        switch($targetmonth) {

            // 2月はうるう年考慮し、28又は29日まで生成
            case 2:
                $end_day = ($this->IsLeapYear($targetyear) ? 29:28);
                break;

            // 4,6,9,11月は30日まで生成
            case 4:  // FALL THRU
            case 6:  // FALL THRU
            case 9:  // FALL THRU
            case 11: // FALL THRU
                $end_day = 30;
                break;

            // 上記以外は31日まで生成するケース
            default:
                $end_day = 31;
                break;
        }

        // 配列を生成する
        for ($cnt = 1; $cnt <= $end_day; $cnt++) {
            $tmp_day[sprintf("%02d", $cnt)] = sprintf("%02d", $cnt);
        }

        return $tmp_day;
    }

    /**
     * GenHour($firsttype = false, $hourtype = true)
     *
     * 「時」の情報が格納された配列を生成する
     *
     * @access    public
     * @param     boolean    配列の先頭を「--」にするかどうか（デフォルトfalse、true:--をセットする/false:--をセットしない）
     * @param     boolean    表示を24時制にするかどうか（デフォルトtrue、true:24時制/false:12時制、数字の前に「午前」または「午後」がつく）
     * @return    array     「時」の情報が格納された配列
     */
    public function GenHour($firsttype = false, $hourtype = true)
    {
        // 配列を初期化
        $tmp_hour = array();
        if ($firsttype) {
            $tmp_hour["--"] = "--";
        }

        // 配列を生成する
        for ($cnt = 0; $cnt <= 23; $cnt++) {
            // 表示タイプによって生成方法を変える
            if ($hourtype) {
                $tmp_hour[sprintf("%02d", $cnt)] = sprintf("%02d", $cnt);
            } else {
                if ($cnt <= 11) {
                    $tmp_hour[sprintf("%02d", $cnt)] = sprintf("午前%d", $cnt);
                } else {
                    $tmp_hour[sprintf("%02d", $cnt)] = sprintf("午後%d", $cnt - 12);
                }
            }
        }

        return $tmp_hour;
    }

    /**
     * GenMinSec($firsttype = false)
     *
     * 「分」または「秒」の情報が格納された配列を生成する
     *
     * @access    public
     * @param     boolean    配列の先頭を「--」にするかどうか（デフォルトfalse、true:--をセットする/false:--をセットしない）
     * @return    array     「分」の情報が格納された配列
     */
    public function GenMinSec($firsttype = false)
    {
        // 配列を初期化
        $tmp_minsec = array();
        if ($firsttype) {
            $tmp_minsec["--"] = "--";
        }

        // 配列を生成する
        for ($cnt = 0; $cnt <= 59; $cnt++) {
            $tmp_minsec[sprintf("%02d", $cnt)] = sprintf("%02d", $cnt);
        }

        return $tmp_minsec;
    }
}
