/*
 * Translated default messages for the jQuery validation plugin.
 * Language: JA
 * Skipped date/dateISO/number.
 */
jQuery.extend(jQuery.validator.messages, {
	required: "<span class='validate'>必須項目</span>",
	maxlength: jQuery.format("{0} 文字以下を入力してください"),
	minlength: jQuery.format("{0} 文字以上を入力してください"),
	rangelength: jQuery.format("{0} 文字以上 {1} 文字以下で入力してください"),
	email: "<span class='validate'>メールアドレスを入力してください</span>",
	url: "URLを入力してください",
	dateISO: "日付を入力してください",
	number: "有効な数字を入力してください",
	digits: "0-9までを入力してください",
	equalTo: "<span class='validate'>同じ値を入力してください</span>",
	range: jQuery.format(" {0} から {1} までの値を入力してください"),
	max: jQuery.format("{0} 以下の値を入力してください"),
	min: jQuery.format("{0} 以上の値を入力してください"),
	creditcard: "クレジットカード番号を入力してください"
});

jQuery.validator.addMethod("hankaku", function(hankaku_word, element) {
    hankaku_word = hankaku_word.replace(/\s+/g, ""); 
	return this.optional(element) || hankaku_word.match(/^[a-zA-Z0-9@\;\:\[\]\^\=\/\!\*\"\#\$\%\&\'\(\)\,\.\-\_\?\\\s]*$/);
}, "全角文字は使えません");
jQuery.validator.addMethod("tel", function(tel_number, element) {
    tel_number = tel_number.replace(/\s+/g, ""); 
	return this.optional(element) || tel_number.length >= 12 && tel_number.match(/^[\d-]*$/);
}, "<span class='validate'>正しい電話番号を入力してください</span>");
jQuery.validator.addMethod("zip", function(zip_number, element) {
    zip_number = zip_number.replace(/\s+/g, ""); 
	return this.optional(element) || zip_number.length >= 8 && zip_number.match( /^(\d\d\d\-?\d\d\d\d)*/);
}, "<span class='validate'>正しい郵便番号を入力してください</span>");
jQuery.validator.addMethod("ktai", function(ktai_number, element) {
    ktai_number = ktai_number.replace(/\s+/g, ""); 
	return this.optional(element) || !ktai_number.match( /docomo\.ne\.jp|mopera\.net|dwmail\.jp|softbank\.ne\.jp|i\.softbank\.jp|disney\.ne\.jp|vodafone\.ne\.jp|jp-d\.ne\.jp|ezweb\.ne\.jp|tkk\.ne\.jp|pdx\.ne\.jp|willcom\.com|wcm\.ne\.jp|emnet\.ne\.jp|emobile\.ne\.jp/ );
}, "<span class='validate'>ケータイアドレスは使えません</span>");


