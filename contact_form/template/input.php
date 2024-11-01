<!-- /** ----------------------------------------------------------------------------
 * メインのコンテンツ部分 ⇒ base.phpの【$content】の部分
 *--------------------------------------------------------------------------- */ -->

<div class="container">

    <b style="display: block; text-align: center;">
        ＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝</br>
        【input.php】にて制御されています</br>templateフォルダの中の【input.php】を参照してください。</br>
        ＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝</br>
    </b>

    <!-- フォーム項目出力部分 -->
    <div id="form">
        <form method="post" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>#form" name="frm" id="frm" class="h-adr">
            <table class="contact_form--table contact">
                <tbody>
                    <?php foreach ($element as $key => $value) : ?>
                        <?php if ($key == 'color' || $key == 'size' || $key == 'comment' || $key == 'select') : continue; ?>
                        <?php elseif ($key == 'multiplecheck') : ?>
                            <tr>
                                <th class="is-required">
                                    <?php echo $element[$key]['Label']; ?>
                                </th>
                                <td>
                                    <?php foreach ($element[$key]['Options'] as $k => $v) : ?>
                                        <label>
                                            <input type="checkbox" name="<?php echo $key; ?>[]" value="<?php echo $k ?>" <?php if (!empty($input[$key]) && in_array($k, $input[$key])) : ?> checked="checked" <?php endif; ?>>
                                            <?php echo $v; ?>
                                        </label>
                                    <?php endforeach; ?>
                                    <?php if ($error[$key]) : ?><br><span class="frm danger"><?php echo $error[$key]; ?></span><?php endif; ?>
                                </td>
                            </tr>
                        <?php elseif ($key == 'kiyaku') : ?>
                            <tr>
                                <th class="is-required">
                                    <?php echo $element[$key]['Label']; ?>
                                </th>
                                <td>
                                    <?php foreach ($element[$key]['Options'] as $k => $v) : ?>
                                        <label>
                                            <input type="checkbox" name="<?php echo $key; ?>[]" value="<?php echo $k ?>" <?php if (!empty($input[$key]) && in_array($k, $input[$key])) : ?> checked="checked" <?php endif; ?>>
                                            <?php echo $v; ?>
                                        </label>
                                    <?php endforeach; ?>
                                    <br>ご利用規約をよく読み同意しますにチェックを入れてください。
                                    <?php if ($error[$key]) : ?><br><span class="frm danger"><?php echo $error[$key]; ?></span><?php endif; ?>
                                </td>
                            </tr>
                        <?php elseif ($key == 'radiobutton') : ?>
                            <tr>
                                <th class="is-required">
                                    <?php echo $element[$key]['Label']; ?>
                                </th>
                                <td>
                                    <?php foreach ($element[$key]['Options'] as $optionKey => $optionValue) : ?>
                                        <label>
                                            <input type="radio" name="<?php echo $key; ?>" value="<?php echo $optionKey; ?>"
                                                <?php echo ($input[$key] == $optionKey) ? 'checked="checked"' : ''; ?> />
                                            <?php echo $optionValue; ?>
                                        </label>
                                    <?php endforeach; ?>
                                    <?php if (isset($error[$key])) : ?>
                                        <br><span class="frm danger"><?php echo $error[$key]; ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php elseif ($key == 'zipcode') : ?>
                            <tr>
                                <th class="is-required">
                                    郵便番号
                                </th>
                                <td>
                                    <input type="text" class="text" id="zip" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo $input[$key]; ?>" />
                                    <?php if ($element[$key]['description']) : ?><br><?php echo $element[$key]['description']; ?><?php endif; ?>
                                        <?php if ($error[$key]) : ?><br><span class="frm danger"><?php echo $error[$key]; ?></span><?php endif; ?>
                                </td>
                            </tr>
                        <?php elseif ($key == 'address01') : ?>
                            <tr>
                                <th class="is-required">
                                    住所
                                </th>
                                <td>
                                    <input type="text" class="text" id="address1" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo $input[$key]; ?>" />
                                    <?php if ($element[$key]['description']) : ?><br><?php echo $element[$key]['description']; ?><?php endif; ?>
                                        <?php if ($error[$key]) : ?><br><span class="frm danger"><?php echo $error[$key]; ?></span><?php endif; ?>
                                </td>
                            </tr>
                        <?php elseif ($key == 'address02') : ?>
                            <tr>
                                <th class="is-required">
                                    住所(フリガナ)
                                </th>
                                <td>
                                    <input type="text" class="text" id="address2" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo $input[$key]; ?>" />
                                    <?php if ($element[$key]['description']) : ?><br><?php echo $element[$key]['description']; ?><?php endif; ?>
                                        <?php if ($error[$key]) : ?><br><span class="frm danger"><?php echo $error[$key]; ?></span><?php endif; ?>
                                </td>
                            </tr>
                        <?php else : ?>
                            <tr>
                                <th class="is-required">
                                    <?php echo $element[$key]['Label']; ?>
                                </th>
                                <td>
                                    <input type="text" class="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo $input[$key]; ?>" />
                                    <?php if ($element[$key]['description']) : ?><br><?php echo $element[$key]['description']; ?><?php endif; ?>
                                        <?php if ($error[$key]) : ?><br><span class="frm danger"><?php echo $error[$key]; ?></span><?php endif; ?>
                                </td>
                            </tr>
                        <?php endif ?>
                    <?php endforeach; ?>

                    <tr>
                        <th class="is-option" rowspan="4">
                            <p>ラジオボタン<br>(一つしか選択できない)<br></p>
                            <span>※注意事項など<br>てきすとですてきすとですてきすとですてきすとですてきすとですてきすとです</span>
                        </th>
                        <td>
                            <?php foreach ($element['select']['Options'] as $key => $value) : ?>
                                <label>
                                    <input type="radio" name="select" value="<?php echo $key ?>" <?php if ($input['select'] == $key) : ?> checked="checked" <?php endif; ?> />
                                    <?php echo $value; ?>
                                </label>
                            <?php endforeach; ?>
                            <?php if ($error['select']) : ?><br><span class="frm danger"><?php echo $error['select']; ?></span><?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>希望する内容です</p>
                            <textarea name="color"><?php echo $input['color']; ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>ラジオボタンの選択項目</p>
                            <?php foreach ($element['size']['Options'] as $key => $value) : ?>
                                <label>
                                    <input type="radio" name="size" value="<?php echo $key ?>" <?php if ($input['size'] == $key) : ?> checked="checked" <?php endif; ?> />
                                    <?php echo $value; ?>
                                </label>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>質問や要望などのテキストエリア</p>
                            <textarea name="comment"><?php echo $input['comment']; ?></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="contact_form--btn">
                <input type="hidden" name="action" value="confirm">
                <input class="confirm" type="submit" value="確認">
            </div>
        </form>
    </div>
</div>

<!-- /** ----------------------------------------------------------------------------
 * メインのコンテンツ部分 ⇒ base.phpの【$content】の部分
 *--------------------------------------------------------------------------- */ -->