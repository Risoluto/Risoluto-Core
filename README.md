# Risoluto-Core

[![Build Status](https://travis-ci.org/Risoluto/Risoluto-Core.svg?branch=master)](https://travis-ci.org/Risoluto/Risoluto-Core)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Risoluto/Risoluto-Core/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Risoluto/Risoluto-Core/?branch=master)
[![Code Climate](https://codeclimate.com/github/Risoluto/Risoluto-Core.png)](https://codeclimate.com/github/Risoluto/Risoluto-Core)

## Risolutoとは

Risolutoは「シンプルで軽い」をコンセプトに開発されたPHPフレームワークです。既存のフレームワークは、その言語自体に加え、フレームワーク 自体について理解しなければいけないことが多くありますが、Risolutoは、極力「PHPを理解していればつかえる」ように作られていますので、初めてフレームワークを使う方や既存のフレームワークほどの機能が不要な方に最適です。

オフィシャルサイト： http://www.risoluto.org/

## Risoluto-Coreとは

Risoluto2の中核部分です。Risoluto2のブートストラップといくつかのクラスが含まれており、Risoluto2の最小環境です。

## Risoluto2をつかうには

### ドキュメント

Risoluto2に関するドキュメントは[GitHubのWiki](https://github.com/Risoluto/Risoluto-Core/wiki)にまとめてあります

### 動作環境

Risoluto2は下記の環境で動作します

* GNU/Linux
* PHP5.5.0以降

また、下記の外部プロダクトを利用しているため、それらの動作環境を満たす必要があります。ただし、下記の一部は将来使用する事が想定されているものや他のRisoluto関連プロジェクトで使用を予定しているものが含まれています。貴方のプロジェクトで不要なのであれば使用せずに済ますことができます。また、貴方のプロジェクトで必要なものが他にある場合は、それを追加することもできます。

* Composer（ http://getcomposer.org/ ）
* Smarty（ http://www.smarty.net/ ）
* Mobile-Detect（ http://mobiledetect.net/ ）
* PHPoAuthLib（ https://github.com/Lusitanian/PHPoAuthLib ）
* PHP Markdown Lib（ http://michelf.ca/projects/php-markdown/ ）
* PHPMailer（ https://github.com/PHPMailer/PHPMailer ）
* PHPUnit（ http://www.phpunit.de/ ）
* jQuery（ http://jquery.com/ ）
* jQuery UI（ http://jqueryui.com/ ）
* jQuery Mobile（ http://jquerymobile.com/ ）

### インストール手順

下記の手順でインストールできます。

1. Risoluto-Coreのリリースパッケージを取得する（ https://github.com/hayakawa/Risoluto-Core/releases ）
2. 「1.」を展開する
3. 展開して出来た「public_html」ディレクトリがドキュメントルートとなるよう、Webサーバを設定する
4. 「3.」で設定したURLにアクセスする
5. ブラウザ上に詳細な手順が表示されるのでそれに従う

### アンインストール手順

リリースパッケージを展開した際に作成されたファイルとディレクトリを削除してください。Risoluto-Coreは、リリースパッケージ中に含まれるディレクトリ以外の場所にファイル等を作成することはありません。

### アップデート／アップグレード手順

現在、これを簡単に行う方法は提供されていません。

はじめに、コンフィグ、ヘッダやフッタ、CSSなど、個別に用意したものやカスタマイズを加えたファイルをバックアップしてください。続いて、最新のリリースパッケージを取得し、更新のあったファイルを入れ替えてください。更新があったファイルの一覧は、git（GitHub）で確認できますが、分からなければ全ファイルが更新されたものとして扱ってください。その後、バックアップしておいたファイルを必要に応じて再配置してください。

もし、カスタマイズされたファイルが最新のリリースパッケージで修正されている場合は、修正箇所を確認した上で何らかの方法でマージする必要があります。また、composer.jsonが更新されている場合は、「php composer.phar update  -o --no-dev」（「php composer.phar self-update」も同時にしておくと安心です）を実行して環境を更新する必要があります。
