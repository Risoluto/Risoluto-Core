# Risoluto-Core

## Risolutoとは

Risolutoは「シンプルで軽い」をコンセプトに開発されたPHPフレームワークです。既存のフレームワークは、その言語自体に加え、フレームワーク 自体について理解しなければいけないことが多くありますが、Risolutoは、極力「PHPを理解していればつかえる」ように作られていますので、初め てフレームワークを使う方や既存のフレームワークほどの機能が不要な方に最適です。

オフィシャルサイト： http://www.risoluto.org/

## Risoluto-Coreとは

Risoluto2の中核部分です。Risoluto2のブートストラップといくつかのクラスが含まれており、Risoluto2の最小環境です。

## Risoluto2をつかうには

### 動作環境

Risoluto2は下記の環境で動作します

* GNU/Linux
* PHP5.5.0以降

また、下記の外部プロダクトを利用しているため、それらの動作環境を満たす必要があります。ただし、下記の一部は必須ではありませんし、将来使用する事が想定されているものや他のRisoluto関連プロジェクトで使用を予定しているものが含まれています。貴方のプロジェクトで不要なのであれば使用せずに済ますことができます。

#### 必須の外部プロダクト

* Composer（ http://getcomposer.org/ ）
* Smarty（ http://www.smarty.net/ ）

#### 任意の外部プロダクト

* Mobile-Detect（ http://mobiledetect.net/ ）
* PHPoAuthLib（ https://github.com/Lusitanian/PHPoAuthLib ）
* PHP Markdown Lib（ http://michelf.ca/projects/php-markdown/ ）
* pear-core-min（ https://github.com/rsky/pear-core-min ）
* pear-pager（ https://github.com/rsky/pear-pager ）
* PHPUnit（ http://www.phpunit.de/ ）
* jQuery（ http://jquery.com/ ）
* jQuery UI（ http://jqueryui.com/ ）
* jQuery Mobile（ http://jquerymobile.com/ ）

### インストール手順

下記の手順でインストールできます。

1. Risoluto-Coreのリリースを取得する（ https://github.com/hayakawa/Risoluto-Core/releases ）
2. 「1.」を展開する
3. 展開して出来た「public_html」ディレクトリがドキュメントルートとなるよう、Webサーバを設定する
4. 「3.」で設定したURLにアクセスする
5. ブラウザ上に詳細な手順が表示されるのでそれに従う
