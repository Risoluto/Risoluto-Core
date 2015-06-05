<?php
/**
 * Pagenation
 *
 * ページネーションのためのファンクション群
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

//------------------------------------------------------//
// クラス定義
//------------------------------------------------------//
class Pagenation
{
    //------------------------------------------------------//
    // クラス変数定義
    //------------------------------------------------------//
    /**
     * $separatorText
     * @access private
     * @var    string    セパレータのテキスト
     */
    private $separatorText = '&nbsp;|&nbsp;';
    /**
     * $firstLinkText
     * @access private
     * @var    string    「最初へ」のテキスト
     */
    private $firstLinkText = '&lt;&lt;First';
    /**
     * $prevLinkText
     * @access private
     * @var    string    「前へ」のテキスト
     */
    private $prevLinkText = '&lt;Prev';
    /**
     * $nextLinkText
     * @access private
     * @var    string    「次へ」のテキスト
     */
    private $nextLinkText = 'Next&gt;';
    /**
     * $lastLinkText
     * @access private
     * @var    string    「最後へ」のテキスト
     */
    private $lastLinkText = 'Last&gt;&gt;';

    /**
     * $classLink
     * @access private
     * @var    string    リンクになっている文字列のスタイルが定義されたクラス名
     */
    private $classLink = 'pagenation_link';
    /**
     * $classNoLink
     * @access private
     * @var    string    リンクになっていない文字列のスタイルが定義されたクラス名
     */
    private $classNoLink = 'pagenation_nolink';

    //------------------------------------------------------//
    // クラスメソッド定義
    //------------------------------------------------------//
    /**
     * genLinkUrl($page)
     *
     * PagenationのリンクURLを生成する
     *
     * @access    private
     *
     * @param     integer $page ページ番号
     *
     * @return    string ベースとなるURL
     */
    private function genLinkUrl( $page )
    {
        // 生成したベースURLを返却
        return str_replace( array ( '/&', '//' ), array ( '/?', '/' ),
            preg_replace( '/(&|\?)page=\d{1,}/', '', $_SERVER[ 'REQUEST_URI' ] ) . '&page=' . $page );
    }

    /**
     * genPagenation($current_page, $total_page, $max_pager_number = 10)
     *
     * Pagenationリンクテキストを生成する
     *
     * @access    private
     *
     * @param     integer $current_page 現在のページ数
     * @param     integer $total_page 合計ページ数
     * @param     integer $max_pager_number Pagenationリンクとして表示する最大数
     *
     * @return    array Pagenationリンク情報
     */
    private function genPagenation( $current_page, $total_page, $max_pager_number = 10 )
    {
        // Pagenationリンク情報を格納する変数を初期化
        $pager_link = '';

        // 「最初へ」リンクを生成
        $pager_link .= $this->genFirst( $current_page );
        // 「前へ」リンクを生成
        $pager_link .= $this->genPrev( $current_page, $total_page );
        // 数値リンクを生成
        $pager_link .= $this->genNum( $current_page, $total_page, $max_pager_number );
        // 「次へ」リンクを生成
        $pager_link .= $this->genNext( $current_page, $total_page );
        // 「最後へ」リンクを生成
        $pager_link .= $this->genLast( $current_page, $total_page );

        // 生成したリンクを返却
        return $pager_link;
    }

    /**
     * genFirst($current_page)
     *
     * 「最初へ」リンクを生成する
     *
     * @access    private
     *
     * @param     integer $current_page 現在のページ数
     *
     * @return    array Pagenationリンク情報
     */
    private function genFirst( $current_page )
    {
        if ($current_page <= 1) {
            // 現在のページが1以下だったら通常のテキストを返却する
            $retval = '<span class="' . $this->classNoLink . '">' . $this->$firstLinkText . '</span>';
        } else {
            // そうでなければリンクテキストを返却する
            $retval = '<a href="' . $this->genLinkUrl( 1 ) . '" class="' . $this->classLink . '">' . $this->$firstLinkText . '</a>';
        }

        return $retval . $this->separatorText;
    }

    /**
     * genPrev($current_page, $total_page)
     *
     * 「前へ」リンクを生成する
     *
     * @access    private
     *
     * @param     integer $current_page 現在のページ数
     * @param     integer $total_page 合計ページ数
     *
     * @return    array Pagenationリンク情報
     */
    private function genPrev( $current_page, $total_page )
    {
        if ($current_page <= 1 or $total_page <= 1) {
            // 現在のページが1以下または合計ページ数が1だったら通常のテキストを返却する
            $retval = '<span class="' . $this->classNoLink . '">' . $this->prevLinkText . '</span>';
        } else {
            // そうでなければリンクテキストを返却する
            $retval = '<a href="' . $this->genLinkUrl( $current_page - 1 ) . '" class="' . $this->classLink . '">' . $this->prevLinkText . '</a>';
        }

        return $retval . $this->separatorText;
    }

    /**
     * genNum($current_page, $total_page, $max_pager_number = 10)
     *
     * 数値リンクを生成する
     *
     * @access    private
     *
     * @param     integer $current_page 現在のページ数
     * @param     integer $total_page 合計ページ数
     * @param     integer $max_pager_number Pagenationリンクとして表示する最大数
     *
     * @return    array Pagenationリンク情報
     */
    private function genNum( $current_page, $total_page, $max_pager_number = 10 )
    {
        $retval[ ] = '';

        // 比較基準となる数値の計算を実施
        $threshold = ceil( $max_pager_number / $current_page );
        $fix_num = round( $max_pager_number / 2 );

        if ($total_page == $max_pager_number) {
            $begin_number = 1;
            $end_number = $max_pager_number;
        } else {
            if ($total_page < $max_pager_number) {
                $begin_number = 1;
                $end_number = $total_page;
            } else {
                // 最大ページが最大表示数より大きければスタート位置を調整する
                if ($current_page <= $threshold + ceil( $fix_num / 2 )) {
                    // 現在ページが1～（最大表示数/2）までの時
                    $begin_number = 1;
                    $end_number = $max_pager_number;
                } else {
                    if (( $total_page - $current_page ) < $fix_num) {
                        // 現在ページがn～最大ページの時
                        $begin_number = $total_page - $max_pager_number;
                        $end_number = $total_page;
                    } else {
                        // それ以外
                        $begin_number = $current_page - $fix_num;
                        $end_number = $current_page + $fix_num - 1;
                    }
                }
            }
        }

        // Pagenationの数値リンクを生成
        for ($i = $begin_number; $i <= $end_number; $i++) {
            if ($i == $current_page) {
                $retval[ ] = '<span class="' . $this->classNoLink . '">' . $i . '</span>';
            } else {
                // そうでなければリンクテキストを返却する
                $retval[ ] = '<a href="' . $this->genLinkUrl( $i ) . '" class="' . $this->classLink . '">' . $i . '</a>';
            }
        }

        return implode( $this->separatorText, $retval );
    }

    /**
     * genNext($current_page, $total_page)
     *
     * 「次へ」リンクを生成する
     *
     * @access    private
     *
     * @param     integer $current_page 現在のページ数
     * @param     integer $total_page 合計ページ数
     *
     * @return    array Pagenationリンク情報
     */
    private function genNext( $current_page, $total_page )
    {
        if ($current_page >= $total_page) {
            // 現在のページが最大ページ以上だったら通常のテキストを返却する
            $retval = '<span class="' . $this->classNoLink . '">' . $this->nextLinkText . '</span>';
        } else {
            // そうでなければリンクテキストを返却する
            $retval = '<a href="' . $this->genLinkUrl( $current_page + 1 ) . '" class="' . $this->classLink . '">' . $this->nextLinkText . '</a>';
        }

        return $this->separatorText . $retval;
    }

    /**
     * genLast($current_page, $total_page)
     *
     * 「最後へ」リンクを生成する
     *
     * @access    private
     *
     * @param     integer $current_page 現在のページ数
     * @param     integer $total_page 合計ページ数
     *
     * @return    array Pagenationリンク情報
     */
    private function genLast( $current_page, $total_page )
    {
        if ($current_page >= $total_page) {
            // 現在のページが最大ページ以上だったら通常のテキストを返却する
            $retval = '<span class="' . $this->classNoLink . '">' . $this->lastLinkText . '</span>';
        } else {
            // そうでなければリンクテキストを返却する
            $retval = '<a href="' . $this->genLinkUrl( $total_page ) . '" class="' . $this->classLink . '">' . $this->lastLinkText . '</a>';
        }

        return $this->separatorText . $retval;
    }

    /**
     * setSeparatorText($text)
     *
     * セパレータテキストをセットする
     *
     * @access    public
     *
     * @param     string $text 設定するテキスト
     *
     * @return    void
     */
    public function setSeparatorText( $text )
    {
        $this->separatorText = $text;
    }

    /**
     * setFirstLinkText($text)
     *
     * 「最初へ」のテキストをセットする
     *
     * @access    public
     *
     * @param     string $text 設定するテキスト
     *
     * @return    void
     */
    public function setFirstLinkText( $text )
    {
        $this->firstLinkText = $text;
    }

    /**
     * setPrevLinkText($text)
     *
     * 「前へ」のテキストをセットする
     *
     * @access    public
     *
     * @param     string $text 設定するテキスト
     *
     * @return    void
     */
    public function setPrevLinkText( $text )
    {
        $this->prevLinkText = $text;
    }

    /**
     * setNextLinkText($text)
     *
     * 「次へ」のテキストをセットする
     *
     * @access    public
     *
     * @param     string $text 設定するテキスト
     *
     * @return    void
     */
    public function setNextLinkText( $text )
    {
        $this->nextLinkText = $text;
    }

    /**
     * setLastLinkText($text)
     *
     * 「最後へ」のテキストをセットする
     *
     * @access    public
     *
     * @param     string $text 設定するテキスト
     *
     * @return    void
     */
    public function setLastLinkText( $text )
    {
        $this->lastLinkText = $text;
    }

    /**
     * setClassLink($text)
     *
     * リンクになっている文字列のスタイルが定義されたクラス名をセットする
     *
     * @access    public
     *
     * @param     string $text 設定するテキスト
     *
     * @return    void
     */
    public function setClassLink( $text )
    {
        $this->classLink = $text;
    }

    /**
     * setClassNoLink($text)
     *
     * リンクになっていない文字列のスタイルが定義されたクラス名をセットする
     *
     * @access    public
     *
     * @param     string $text 設定するテキスト
     *
     * @return    void
     */
    public function setClassNoLink( $text )
    {
        $this->classNoLink = $text;
    }

    /**
     * getPagenation($current_page, $total_count, $per_page, $max_pager_number = 10)
     *
     * Pagenationを生成する
     *
     * @access    public
     *
     * @param     integer $current_page 現在のページ数
     * @param     integer $total_count 合計件数
     * @param     integer $per_page 1ページあたりの件数
     * @param     integer $max_pager_number Pagenationリンクとして表示する最大数
     *
     * @return    array Pagenationに関する情報が格納された連想配列
     */
    public function getPagenation( $current_page, $total_count, $per_page, $max_pager_number = 10 )
    {
        // 合計ページ数を算出
        $total_page = ceil( $total_count / $per_page );

        // 現在ページが合計ページを超過していたら、現在ページを合計ページにする
        if ($current_page > $total_page) {
            $current_page = $total_page;
        }

        // 取得結果を返却
        return [
            'PagerLink' => str_replace(
                $this->separatorText . $this->separatorText,
                $this->separatorText,
                $this->genPagenation( $current_page, $total_page, $max_pager_number )
            ),
            'CurrentPage' => $current_page,
            'TotalPage' => $total_page,
        ];
    }
}