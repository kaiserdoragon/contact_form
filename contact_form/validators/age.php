<?php

class validators_age
{
	function check($value)
	{
		// 全角数字を半角に変換
		$value = mb_convert_kana($value, "n", 'UTF-8');

		// 半角数字以外が含まれている場合のバリデーション
		if (mb_strlen($value) > 0 && !preg_match("/^\d+$/", $value)) {
			return '年齢は全角・半角数字のみで入力してください。';
		} else {
			return false;
		}
	}
}
