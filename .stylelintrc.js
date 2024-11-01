module.exports = {
  extends: ["stylelint-config-standard-scss", "stylelint-config-recess-order"],
  rules: {
    "at-rule-empty-line-before": [
      "always",
      {
        except: ["blockless-after-blockless", "first-nested"],
        ignore: ["after-comment"],
        ignoreAtRules: ["else"],
      },
    ],
    "at-rule-no-unknown": [
      true,
      {
        ignoreAtRules: ["include", "mixin", "each", "use", "forward", "charset"],
      },
    ],
    "block-no-empty": true,
    "color-no-invalid-hex": true,
    "color-named": "never",
    "color-hex-case": "lower",
    "comment-no-empty": true,
    "comment-empty-line-before": "always",
    "comment-whitespace-inside": "always",
    "declaration-block-no-duplicate-properties": true,
    "declaration-block-no-shorthand-property-overrides": true,
    "declaration-block-no-redundant-longhand-properties": true,
    "declaration-bang-space-after": "never",
    "function-calc-no-unspaced-operator": true,
    "function-url-quotes": "never", //url()内にはquotesを付けない
    "function-name-case": "lower",
    "function-max-empty-lines": 0,
    // "function-parentheses-space-inside": "always", //(prettierで圧縮されるのでoffが正しいようです)
    "font-family-no-duplicate-names": true,
    "font-family-name-quotes": "always-unless-keyword",
    "keyframes-name-pattern": null, // keyframesでkebab-case以外も許容
    "length-zero-no-unit": true,
    "media-feature-name-no-unknown": true,
    "max-line-length": null, // 120文字を超える行を許可
    "max-empty-lines": null, // 連続する空白行を許可
    "no-duplicate-at-import-rules": true,
    "no-duplicate-selectors": true,
    "no-descending-specificity": null, // 詳細度の高いセレクタが前に来るのを禁止(ネストを多用する場合はnull推奨)
    "no-empty-source": true,
    "no-extra-semicolons": true,
    "number-leading-zero": "always",
    "number-no-trailing-zeros": true,
    "property-no-unknown": true,
    "property-case": "lower",
    "selector-pseudo-class-no-unknown": true,
    "selector-pseudo-element-no-unknown": true,
    "selector-pseudo-element-colon-notation": "double",
    "selector-type-no-unknown": true,
    "selector-type-case": "lower",
    "selector-class-pattern": null, // idでkebab-case以外も許容
    "selector-id-pattern": null, // classでkebab-case以外も許容
    "string-no-newline": true,
    "string-quotes": "double",
    "shorthand-property-no-redundant-values": true,
    "scss/at-rule-no-unknown": true,
    "scss/at-mixin-pattern": null, // mixinでkebab-case以外も許容
    "scss/dollar-variable-pattern": null, // $変数でkebab-case以外も許容
    "scss/percent-placeholder-pattern": null, // %placeholderでkebab-case以外も許容
    "scss/at-extend-no-missing-placeholder": null, // @extendで%placeholder以外も許容
    "scss/double-slash-comment-whitespace-inside": null, // autofixがないので修正が面倒だったらnull
    "time-min-milliseconds": 100,
    "unit-no-unknown": true,
    "unit-case": "lower",
    "value-keyword-case": "lower",
    "value-no-vendor-prefix": null, //「-webkit-」などのベンダープレフィックスを維持する
  },
};
