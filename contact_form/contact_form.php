<?php

class contactform
{

    var $_view;
    var $_elements;
    var $_validates = [];
    var $_template = 'input';

    // セキュリティ対策として、テンプレート名をバリデートするためのメソッド
    public function setTemplate($template)
    {
        // 許可されたテンプレート名かどうかをチェック
        $allowedTemplates = ['input', 'form', 'output']; // 許可されているテンプレートのリスト
        if (in_array($template, $allowedTemplates)) {
            $this->_template = $template;
        } else {
            // 不正なテンプレート名が入力された場合の処理
            throw new Exception('Invalid template name');
        }
    }


    function dispatch($elements)
    {
        // Elementsをクラスプロパティにセット
        $this->_elements = $elements;

        // POSTデータをUTF-8に変換
        $post = $_POST;
        mb_convert_variables('utf-8', 'auto', $post);

        // thanksフラグがセットされているかを確認
        if ($_SESSION['thanks']) {
            $action = 'thanks';
            unset($_SESSION['thanks']);
        } else {
            // POSTからactionを取得
            $action = isset($post['action']) ? $post['action'] : '';
        }

        // Actionの種類に応じて処理を分岐
        switch ($action) {
            case 'confirm':
                // セッションにPOSTデータを保存し、エラーチェック
                $this->setSession($post);
                $error = $this->check($post);

                // エラーがあればinputに戻す
                if ($error) {
                    $action = 'input';
                }
                break;

            case 'last':
                // 再チェックを行いエラーがなければlastへ
                $error = $this->check($_SESSION);
                if (!$error) {
                    $action = 'last';
                }
                break;
        }

        // 実際の画面処理
        switch ($action) {
            case 'confirm':
                // 確認フォームの処理
                $this->_template = 'confirm';
                $this->_view->assign('confirm', $this->getValues());
                $this->_view->assign('element', $this->_elements);
                break;

            case 'last':
                // メール送信処理
                $this->sendmail();

                // thanksページのフラグをセット
                $_SESSION['thanks'] = true;

                // リダイレクト処理
                $this->redirect();
                break;

            case 'thanks':
                // サンクスページの処理
                $this->_template = 'thanks';
                $this->clearSession();
                break;

            case 'input':
            default:
                // 入力画面のデータ取得
                $input = $this->getSession();

                // セッションがなければデフォルト値を設定
                if (!$input) {
                    foreach ($this->_elements as $key => $elem) {
                        if (!isset($input[$key]) && isset($elem['Default'])) {
                            $input[$key] = $elem['Default'];
                        }
                        $error[$key] = null;
                    }
                }

                // テンプレートにデータを割り当て
                $this->_view->assign('input', $input);
                $this->_view->assign('error', $error);
                $this->_view->assign('element', $this->_elements);
        }

        return $this;
    }

    // シンプルテンプレートエンジンの初期化
    function setView($view)
    {
        $this->_view = $view;
        return $this;
    }

    // 入力チェック表示用
    function getValues()
    {
        $confirm = array();
        $inputs = $this->getSession();

        // 各要素を確認し、必要に応じて値を変換
        foreach ($this->_elements as $key => $element) {
            // Reportがfalseならスキップ
            if (isset($element['Report']) && $element['Report'] === false) {
                continue;
            }

            // Optionsが設定されている場合は表示用に変換
            if (isset($element['Options'])) {
                if (is_array($inputs[$key])) {
                    // 複数選択の処理
                    $temp = array();
                    foreach ($inputs[$key] as $k) {
                        $temp[] = $element['Options'][$k];
                    }
                    $confirm[$key] = implode(' 、', $temp);
                } else {
                    // 単一選択の処理
                    $confirm[$key] = $element['Options'][$inputs[$key]];
                }
            } else {
                // Optionsがない場合はそのまま値をセット
                $confirm[$key] = $inputs[$key];
            }

            // Reportの値が存在する場合、上書き
            if (isset($element['Report'])) {
                $confirm[$key] = $element['Report'];
            }
        }

        return $confirm;
    }


    function redirect()
    {
        // 永久リダイレクト（301）のヘッダーを送信
        header("HTTP/1.1 301 Moved Permanently");

        // 現在のスクリプトにリダイレクト
        header('Location: ' . $_SERVER['SCRIPT_NAME']);

        // スクリプトの実行を終了
        exit();
    }


    // 管理者にメール
    function sendmail()
    {
        // メールの内容を取得
        $value = $this->getValues();
        file_put_contents(MAIL_LOG, date("Y/m/d H:i:s") . " {$value['name']}<{$value['email']}>\n", FILE_APPEND);

        // メール送信ヘッダの共通部分を生成
        $header_info = $this->buildHeader(FROM_NAME, FROM_EMAIL);

        // テンプレートオブジェクトを作成し、共通設定を適用
        $tpl = $this->prepareTemplate();

        // カウントファイルが設定されている場合の処理
        if (MAIL_COUNT) {
            $cnt = file_get_contents(MAIL_COUNT);
            $cnt++;
            $tpl->assign('cnt', $cnt);
            file_put_contents(MAIL_COUNT, $cnt);
        }

        // 管理者宛のメールの件名と本文を取得し、送信
        $subject = $tpl->fetch('to_admin.php');
        $this->sendMailToAdmin($subject, $header_info);

        // サンキューメールがある場合の処理
        if (THANKSMAIL_TITLE) {
            $this->sendThankYouMail($tpl, $header_info);
        }
    }

    // メールヘッダを生成する共通処理
    private function buildHeader($fromName, $fromEmail)
    {
        $fromHeader = sprintf("From: %s <%s>", mb_encode_mimeheader($fromName), $fromEmail);
        $contentType = "Content-Type: text/plain;charset=ISO-2022-JP";
        $mailerInfo = "X-Mailer: PHP/" . phpversion();

        return implode("\n", [$fromHeader, $contentType, $mailerInfo]);
    }

    // テンプレートオブジェクトを作成し、共通設定を適用する関数
    private function prepareTemplate()
    {
        $template = new Template();

        // テンプレートパスを設定
        $template->set_path($this->_view->get_path());

        // 値と要素をテンプレートに割り当て
        $this->assignTemplateValues($template);

        return $template;
    }

    // テンプレートに値と要素を割り当てる処理を分離
    private function assignTemplateValues($template)
    {
        $template->assign('values', $this->getValues());
        $template->assign('element', $this->_elements);
    }

    // 管理者宛のメール送信処理
    private function sendMailToAdmin($subject, $headerInfo)
    {
        // 管理者宛のメールアドレスを作成
        $adminEmail = sprintf("%s <%s>", mb_encode_mimeheader(ADMIN_NAME), ADMIN_EMAIL);

        // メール送信
        mb_send_mail(
            $adminEmail,
            MAIL_TITLE,
            $this->convertEOL($subject),
            $headerInfo
        );
    }

    // サンキューメールを送信する処理
    private function sendThankYouMail($template, $headerInfo)
    {
        // ユーザー宛のメールの件名と本文を生成
        $subject = $template->fetch('to_user.php');
        $values = $this->getValues();

        // ユーザー宛のメールアドレスを作成
        $userEmail = sprintf("%s様 <%s>", mb_encode_mimeheader($values['name']), $values['email']);

        // サンキューメールを送信
        mb_send_mail(
            $userEmail,
            THANKSMAIL_TITLE,
            $this->convertEOL($subject),
            $headerInfo
        );
    }



    /**
     *
     * @param type $key
     * @param type $val
     * @param type $str
     * @return type
     */

    function _convert_tag($key, $val, $str)
    {
        // 変換するタグを生成
        $tag = sprintf("{%s}", $key);

        // タグを値で置き換える
        return str_replace($tag, $val, $str);
    }


    function convertEOL($string, $to = "\n")
    {
        // 変換対象の改行文字を配列で定義
        $eolCharacters = ["\r\n", "\r", "\n"];

        // 配列を使って改行コードを指定の形式に変換
        return strtr($string, array_fill_keys($eolCharacters, $to));
    }

    function check($post)
    {
        $err = array();

        foreach ($this->_elements as $key => $element) {
            // 必須項目チェック
            if ($this->isRequiredFieldMissing($element, $post[$key])) {
                $err[$key][] = '未入力';
                continue;
            }

            // バリデーションチェック
            if (isset($element['Validators'])) {
                $this->runValidators($element['Validators'], $post[$key], $err, $key);
            }
        }

        // エラーがあればフォーマットして返す
        return $this->formatErrors($err);
    }


    // 必須項目のチェックを行うメソッド
    private function isRequiredFieldMissing($element, $value)
    {
        return isset($element['Required']) && $element['Required'] === true && empty($value);
    }

    // バリデーションを実行するメソッド
    private function runValidators($validators, $value, &$err, $key)
    {
        foreach ($validators as $k => $v) {
            $validate = is_integer($k) ? $v : $k;
            $params = is_integer($k) ? null : $v;

            $res = $this->_validate($value, $validate, $params);

            if ($res) {
                $err[$key][] = $res;
            }
        }
    }

    // エラーメッセージをフォーマットして返すメソッド
    private function formatErrors($err)
    {
        if (count($err) > 0) {
            $error = array();
            foreach ($err as $key => $messages) {
                $error[$key] = implode('、', $messages);
            }
            return $error;
        }
        return false;
    }

    // バリデートを分解して実行
    function _validate($value, $validate, $params = null)
    {
        // バリデータがオブジェクトでない場合、初期化
        if (!$this->isValidatorLoaded($validate)) {
            $this->loadValidator($validate);
        }

        // パラメータが指定されている場合、設定
        if (!is_null($params)) {
            $this->_validates[$validate]->setParam($params);
        }

        // バリデータで値をチェック
        return $this->_validates[$validate]->check($value);
    }

    // バリデータがロードされているか確認する関数
    private function isValidatorLoaded($validate)
    {
        return is_object($this->_validates[$validate]);
    }

    // バリデータをロードする関数
    private function loadValidator($validate)
    {
        require_once 'validators/' . $validate . '.php';
        $objName = 'validators_' . $validate;
        $this->_validates[$validate] = new $objName($this);
    }

    function setSession($post)
    {
        foreach ($this->_elements as $key => $element) {
            // POSTに値が存在しない場合はnullを設定
            if (!isset($post[$key])) {
                $_SESSION[$key] = null;
            } else {
                // POSTの値が配列の場合、そのまま保存
                // それ以外の場合はサニタイズして保存
                $_SESSION[$key] = is_array($post[$key]) ? $post[$key] : strip_tags($post[$key]);
            }
        }

        return $this;
    }

    function getSession()
    {
        // セッションが開始されていない場合はセッションを開始
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // セッションが存在するかを確認し、なければ false を返す
        return !empty($_SESSION) ? $_SESSION : false;
    }



    function getInput($key)
    {
        return $_SESSION[$key];
    }


    // セッションの削除
    function clearSession()
    {
        return session_destroy();
    }

    function render()
    {
        // テンプレートからコンテンツを取得して割り当て
        $content = $this->_view->fetch($this->_template . '.php');
        $this->_view->assign('content', $content);

        // ベーステンプレートを表示
        $this->_view->display('base.php');
    }

    function mobileRender()
    {
        // Shift_JIS エンコーディングのヘッダーを設定
        header('Content-type: text/html; charset=Shift_JIS');

        // テンプレートのコンテンツを取得し、ビューに割り当て
        $content = $this->_view->fetch($this->_template . '.php');
        $this->_view->assign('content', $content);

        // ベーステンプレートを取得してエンコーディングを変換
        $output = $this->_view->fetch('base.php');
        $encodedOutput = mb_convert_encoding($output, 'SJIS-WIN', 'auto');

        // 変換後の出力を表示
        echo $encodedOutput;
    }
}
