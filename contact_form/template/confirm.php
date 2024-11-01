<!-- /** ----------------------------------------------------------------------------
 * 確認画面です
 *--------------------------------------------------------------------------- */ -->

<div id="confirm">
    <div class="container">
        <h2 id="form">【確認画面です】この内容で申し込みます</h2>
        <table class="contact_form--table contact">
            <tbody>
                <?php foreach ($confirm as $key => $value) : ?>
                    <?php if ($key == 'color' || $key == 'size' || $key == 'comment' || $key == 'select') : continue; ?>
                    <?php else : ?>
                        <tr>
                            <th>
                                <?php echo $element[$key]['Label']; ?>
                            </th>
                            <td>
                                <?php echo nl2br($value); ?>
                            </td>
                        </tr>
                    <?php endif ?>
                <?php endforeach; ?>
                <tr>
                    <th rowspan="4">
                        ラジオボタン<br>(一つしか選択できない)<br>
                        ※注意事項など<br>てきすとですてきすとですてきすとですてきすとですてきすとですてきすとです
                    </th>
                    <td>
                        <?php echo nl2br($confirm['select']); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        希望する内容です<br>
                        <?php echo nl2br($confirm['color']); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        ラジオボタンの選択項目<br>
                        <?php echo nl2br($confirm['size']); ?>
                    </td>
                </tr>
                <tr>
                    <td>質問や要望などのテキストエリア<br>
                        <?php echo nl2br($confirm['comment']); ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <form method="post" action="" name="frm">
            <div class="contact_form--btn">
                <input type="hidden" name="action" value="last" />
                <button type="button" onclick="location.href = '<?php echo $_SERVER['SCRIPT_NAME'] ?>?back=1#form'">戻る</button>
                <button type="submit">送信する</button>
            </div>
        </form>
    </div>
</div>