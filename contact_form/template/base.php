<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <title>contact_formの基本形です｜contact_formの基本形です</title>
    <meta content="★サイトの説明文を入力してください。★" name="description">
    <meta property="og:url" content="ページのURL">
    <meta property="og:type" content="ページの種類">
    <meta property="og:title" content="ページのタイトル">
    <meta property="og:description" content="ページの説明文">
    <meta property="og:site_name" content="サイト名">
    <meta property="og:image" content="サムネイル画像のURL">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="icon" href="./img/icons/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="./img/icons/apple-touch-icon.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- 住所の自動入力 -->
    <script type="text/javascript" src="//jpostal-1006.appspot.com/jquery.jpostal.js"></script>
    <!-- safariのスムーススクロール対応用 -->
    <script>
        if (/iP(hone|od|ad)/.test(navigator.userAgent)) {
            var s = document.createElement('script');
            s.src = 'https://polyfill.io/v3/polyfill.min.js?features=smoothscroll';
            document.head.appendChild(s);
        }
    </script>
    <script type="text/javascript" src="./js/form.js" defer></script>
    <script type="text/javascript" src="./js/scripts.js" defer></script>
</head>

<body id="contact">
    <div class="wrap">
        <!-- ヘッダー の出力-->
        <header class="header">
            <div class="container">
                <h1 class="header--logo">
                    <a href="/contact_form/"><img src="img/common/logo.svg" alt="" width="411" height="69"></a>
                </h1>
                <button id="js-gnav_btn" class="gnav_btn">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <nav id="js-gnav" class="gnav">
                    <ul>
                        <li><a href="#">メニュー1</a></li>
                        <li><a href="#">メニュー2</a></li>
                        <li><a href="#">メニュー3</a></li>
                        <li><a href="#">メニュー4</a></li>
                        <li><a href="#">メニュー5</a></li>
                        <li><a href="#">メニュー6</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- 「input.php」にて制御 -->
        <?php echo $content; ?>

        <!-- フッターの出力 -->
        <footer>
            <div class="container">
                <p>フッターの要素を入れて下さい。（templateフォルダの中の【base.php】にて制御されています。）</p>
            </div>
        </footer>

        <div id="loading">送信中...</div>
    </div>
</body>

</html>