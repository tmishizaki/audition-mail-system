<?php
/*
Mail Foarm 2007 - 2011
Copyright (C) Tomonobu Ishizaki.
contact : ishizaki@systemdepot.net
*/

//-----初期設定-----
//POST情報配列
$post_array = $_POST;

//文字コードタイプ指定
$codeType = "UTF-8";

//フォルダアドレス
$folder = $_SERVER["DOCUMENT_ROOT"]."/audition_2";

//差出人
//$MailFrom = base64_encode($MailFrom);
$MailFrom = "J-CREWプロジェクト";
$MailFromAddres = "info@designchamploo.net";

//件名
$Subject	= "オーディションご応募ありがとうございます。";

//確認画面テンプレート
$html_file = "confirm.html";

//折り返し用テンプレート
$mail_file = "replay.mail";

//送り先メールアドレス
$MailTo = $post_array[mail];

//件名
$Subject_Admin	= "海月七海オーディション2015応募者";

//管理者向けテンプレート
$mail_file_admin  = "recieve.mail";

//管理者メールアドレス
//$Mail_To_Admin = "question@ers-h.co.jp";
//$Mail_To_Admin = "info@designchamploo.net";
$Mail_To_Admin = "ishizaki.me@gmail.com";

//サンキュー画面ＵＲＬ
$comp_url = "thanks.html";

//CC宛先
$MailBcc = "null";

//-----初期設定ここまで-----


require("./qdmail.php");
mb_language("japanese");
mb_internal_encoding($codeType);

//メールテンプレート読み込み
$content = file_get_contents($mail_file);
foreach( $post_array as $key => $val ){
	$val = mb_convert_encoding($val, $codeType, "auto");
	$content = str_replace("#".$key."#", $val, $content);
}
/*
$content = str_replace('#enquete0#', "いいえ", $content);
$content = str_replace('#enquete1#', "いいえ", $content);
$content = str_replace('#enquete2#', "いいえ", $content);
*/

//添付ファイル
$fileArray = array();

foreach( $post_array[file] as $key => $val ){
	$fileArray[] = array( "{$folder}/upfiles/{$val[up]}", "{$val[up]}" );
}

//print_r($fileArray);
//確認メール送信
$from = array( $MailFromAddres, $MailFrom );
qd_send_mail( 'text', $MailTo, $Subject, $content, $from);

//管理者向け送信
$content = file_get_contents($mail_file_admin);
foreach( $post_array as $key => $val ){
	$val = mb_convert_encoding($val, $codeType, "auto");
	$content = str_replace("#".$key."#", $val, $content);
}
qd_send_mail( 'text', $Mail_To_Admin, $Subject_Admin, $content, $from, $fileArray);

//$mail->AddAddress($MailTo);
//入力者への確認メール送信
/*$mail = new PHPMailer();
$mail->CharSet = "iso-2022-jp";
$mail->Encoding = "7bit";
$mail->AddAddress("reuse@k-reuse.jp");
$mail->From = $MailFromAddres;
$mail->FromName = mb_encode_mimeheader(mb_convert_encoding($MailFrom,"JIS",$codeType));
$mail->Subject = mb_encode_mimeheader(mb_convert_encoding($Subject,"JIS",$codeType));
$mail->Body  = mb_convert_encoding($content,"JIS",$codeType);
foreach( $fileArray as $file ){
	$mail->AddAttachment($file,"","application/octet-stream");
}
$mail->AddAttachment("./confirm.html","","application/octet-stream");

if ( !$mail->Send() ){
	echo "ERROR ";
	echo $mail->ErrorInfo;
}else{
	echo "OK!";
}

if (!$mail->Send()){
    echo("メールが送信できませんでした。エラー:".$mail->ErrorInfo);
}

//管理者への送信
$content = file_get_contents($mail_file_admin);
foreach( $post_array as $key => $val ){
	$val = mb_convert_encoding($val, $codeType, "auto");
	$content = str_replace("#".$key."#", $val, $content);
}

$mail_ad = new PHPMailer();
$mail_ad->CharSet = "iso-2022-jp";
$mail_ad->Encoding = "7bit";
$mail_ad->AddAddress($Mail_To_Admin);
$mail_ad->From = $MailFromAddres;
$mail_ad->FromName = mb_encode_mimeheader(mb_convert_encoding($MailFrom,"JIS",$codeType));
$mail_ad->Subject = mb_encode_mimeheader(mb_convert_encoding($Subject_Admin,"JIS",$codeType));
$mail_ad->Body  = mb_convert_encoding($content,"JIS",$codeType);
foreach( $fileArray as $file ){
	$mail_ad->AddAttachment($file);
}

$mail_ad->Send();
*/
//サンキュー画面
$content = file_get_contents($comp_url);
//header("Content-Type: text/html; charset=".$codeType);
echo $content;

?>