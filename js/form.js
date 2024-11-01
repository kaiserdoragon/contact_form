(function ($, root) {
    // ------------------------------
    // jQueryのコードはここに記載
    // ------------------------------
    $(function () {
        // 二重クリック防止・送信中表示
        $('form').on('submit', function () {
            $(this).find('button').attr('disabled', 'disabled');
            $('#loading').show();
        });

        //ラジオボタンのTRUE or Falseで表示・非表示の切り替え
        $(document).ready(function () {
            // 設定オブジェクト
            const config = {
                select1: {
                    color: { disabled: false, required: true },
                    size: { disabled: false, required: true },
                    comment: { disabled: false }
                },
                select2: {
                    color: { disabled: true, required: false },
                    size: { disabled: true, required: false },
                    comment: { disabled: true }
                }
            };

            // 設定を適用する関数
            function applyConfig(selectValue) {
                const settings = config[`select${selectValue}`];
                if (settings) {
                    $('[type=radio][name=color]').prop(settings.color);
                    $('[type=radio][name=size]').prop(settings.size);
                    $('textarea[name=comment]').prop(settings.comment);
                } else {
                    console.error(`設定が見つかりません: select${selectValue}`);
                }
            }

            // ラジオボタンのクリックイベント
            $('[name=select]').on('click', function () {
                applyConfig($(this).val());
            });

            // 初期状態のチェック
            const initialSelectValue = $('[name=select]:checked').val() || '1'; // デフォルト値を'1'とする
            applyConfig(initialSelectValue);

            // ラジオボタンが何も選択されていない時の処理
            $('[type=radio][name=color], [type=radio][name=size]').on('change', function () {
                const isAnySelected = $('[type=radio][name=color]:checked').length > 0 || $('[type=radio][name=size]:checked').length > 0;
                if (!isAnySelected) {
                    $('[type=radio][name=color]').prop({ disabled: false, required: false });
                    $('[type=radio][name=size]').prop({ disabled: false, required: false });
                }
            }).trigger('change'); // 初期状態のチェック
        });
    });
})(jQuery, this);
