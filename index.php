<?php

/** ----------------------------------------------------------------------------
 * 【基本設定】
 * ・管理者のメールアドレス先
 * ・自動返信するメールアドレス先
 * ・各メールのタイトル
 *--------------------------------------------------------------------------- */

//複数設置を考慮してフォームの識別名
define('FORM_NAME', 'contact_form');

//通知するメールアドレス
define('ADMIN_EMAIL', 'd_ishii@alta.co.jp');
define('ADMIN_NAME', '通知メールです');

//差出人
define('FROM_EMAIL', 'd_ishii@alta.co.jp');
define('FROM_NAME', '差出人からのメールです');

//「Bcc」はココ
//define('BCC_EMAIL', 'abcdefg@gmail.com');
//define('BCC_EMAIL', 'hijklmn@gmail.com');
//define('BCC_EMAIL', 'opqrstu@gmail.com');

//各メール管理者宛のメールタイトル
define('MAIL_TITLE', '【申込】HPから申込がありました');
define('THANKSMAIL_TITLE', '【申込】HPからのお申込ありがとうございました');

//セッション
if (defined('FORM_NAME')) {
    session_name(FORM_NAME);
}
ini_set('session.gc_maxlifetime', 1000);

//アプリケーションフォルダ
define('APPLICATION_PATH', __DIR__);

//テンプレートフォルダ
$template_dir = APPLICATION_PATH . '/contact_form/template/';

//メールアドレスログ保存用。その回が終わったら中身を空にすると管理しやすい
define('MAIL_LOG', APPLICATION_PATH . '/contact_form/maillog.dat');

//問合わせナンバリングするなら入力
define('MAIL_COUNT', APPLICATION_PATH . '/contact_form/count.dat');
// define('MAIL_COUNT', '');




/** ----------------------------------------------------------------------------
 * PHP動作設定
 * サーバーの環境に合わせて設定
 * --------------------------------------------------------------------------- */
//エラー処理
error_reporting(E_ERROR | E_WARNING | E_PARSE);

mb_language("Japanese");

//エンコード
mb_internal_encoding("utf-8");

//本番ではOFFにする
// On | Off
ini_set('display_errors', 'Off');

/* * *****************************************************************************
 * 入力フォーム内容
 *
 * 【Validators】 = 入力チェック(バリデーションを入れたい時に使う)
 * 【Required】 = true|false（「必須」か「任意」の選択）
 * 【Report】 = falseにすると確認画面データが渡りません。（例：E-mail(確認)⇒email_match）
 *
 * **************************************************************************** */
$elements = array(
    'name01' => array(
        'Label' => '姓',
        'Required' => true,
    ),
    'name02' => array(
        'Label' => '名',
        'Required' => true,
    ),
    'name' => array(
        'Label' => '氏名',
        'Required' => true,
    ),
    'name03' => array(
        'Label' => '氏名フリガナ',
        'Required' => true,
    ),
    'zipcode' => array(
        'Label' => '郵便番号',
        'Required' => true,
        'Validators' => array(
            'zipcode'
        ),
        'description' => '例)131-8634(ハイフンを入力してください)'
    ),
    'address01' => array(
        'Label' => '住所',
        'Required' => true,
    ),
    'address02' => array(
        'Label' => '住所フリガナ',
        'Required' => true,
    ),
    'tel' => array(
        'Label' => '電話番号',
        'Required' => true,
        'Validators' => array(
            'tel'
        )
    ),
    'email' => array(
        'Label' => 'E-mail',
        'Required' => true,
        'Validators' => array(
            'email'
        )
    ),
    'email_match' => array(
        'Label' => 'E-mail(確認)',
        'Required' => true,
        'Validators' => array(
            'match' => array('email')
        ),
        'Report' => false
        // 「'Report' => false」により確認画面に表示されません
    ),
    'age' => array(
        'Label' => '年齢',
        'Required' => true,
        'Validators' => array(
            'age'
        ),
    ),
    'affiliation' => array(
        'Label' => '所属',
        'Required' => true,
    ),
    'multiplecheck' => array(
        'Label' => 'チェックボックス選択項目',
        'Required' => true,
        'Options' => array(
            1 => 'チェックボックス選択項目1',
            2 => 'チェックボックス選択項目2',
            3 => 'チェックボックス選択項目3',
            4 => 'チェックボックス選択項目4'
        )
    ),
    'radiobutton' => array(
        'Label' => 'ラジオボタンボタン',
        'Required' => true,
        'Options' => array(
            1 => 'ラジオボタンボタン1',
            2 => 'ラジオボタンボタン2',
            3 => 'ラジオボタンボタン3',
            4 => 'ラジオボタンボタン4'
        )
    ),
    'kiyaku' => array(
        'Label' => '規約に同意',
        'Required' => true,
        'Options' => array(
            1 => '同意します',
        )
    ),
    'select' => array(
        'Label' => 'TRUE or False',
        'Required' => false,
        'Options' => array(
            1 => 'TRUE',
            2 => 'False'
        )
    ),
    'color' => array(
        'Label' => '希望する内容です',
        'Required' => false,
    ),
    'size' => array(
        'Label' => 'ラジオボタンの選択項目',
        'Required' => false,
        'Options' => array(
            1 => 'ラジオボタンの選択項目1',
            2 => 'ラジオボタンの選択項目2',
            3 => 'ラジオボタンの選択項目3',
            4 => 'ラジオボタンの選択項目4',
            5 => 'ラジオボタンの選択項目5',
            6 => 'ラジオボタンの選択項目6'
        )
    ),
    'comment' => array(
        'Label' => '質問や要望など',
        'Required' => false,
    ),
);

/** ----------------------------------------------------------------------------
 * テンプレートビューの設定
 * --------------------------------------------------------------------------- */

// 必要なファイルを読み込み
require_once APPLICATION_PATH . '/contact_form/template.php';

// テンプレートオブジェクトを生成してパスを設定
$view = new Template();
$view->set_path($template_dir);


/** ----------------------------------------------------------------------------
 * 実行
 * --------------------------------------------------------------------------- */

// 必要なファイルを読み込み
require_once APPLICATION_PATH . '/contact_form/contact_form.php';

// セッションを開始
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// contact_form オブジェクトを生成
$contactform = new contactform();

// ビューを設定
$contactform->setView($view);

// ディスパッチ処理を実行
$contactform->dispatch($elements);

// 基本出力を実行
$contactform->render();

// 携帯用出力の例（コメントアウトのまま残す）
// $contactform->mobileRender();
