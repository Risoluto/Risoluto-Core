<?php
/**
 * Text
 *
 * テキスト操作のためのファンクション群
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

class Text
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
     * autoUrlLink($target, $newWindow = true, $extra = null)
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
    public static function autoUrlLink($target, $newWindow = true, $extra = null)
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
}