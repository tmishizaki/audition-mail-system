<?php
/*
Mail Form 2007 - 2011
Copyright (C) Tomonobu Ishizaki.
contact : ishizaki@systemdepot.net
*/

//----初期設定----
//差出人
$MailFrom	= "";
//件名
$Subject	= "メールフォームからのメール";
//確認画面テンプレート
$html_file = "confirm.html";
//エラー画面テンプレート
$error_file = "error.html";
//メール内容テンプレート
$mail_file = "templet.mail";
//サンキュー画面ＵＲＬ
$location_url = "comp.html";
//送り先メールアドレス
$MailTo = "";
//文字コードタイプ指定
$codeType = "UTF-8";
//----設定ここまで----


$post_array = $_POST;
//$HTTP_SESSION_VARS["cooke_array"] = $_POST;

$content = file_get_contents($html_file);
$er_msg = "";

foreach( $post_array as $key => $val ){
	if ( mb_ereg('.*?(#\!'.$key.'#).*?',$content) ){
		if ( $val == "" ){ 
			$er_msg .= "必須項目が入力されていません。"; 
		}
	}
	if ( $val != "" ) { 
		$val = htmlspecialchars($val);
		$val = mb_convert_encoding($val, $codeType, "auto");
	}
	$hidden .= '<input type="hidden" name="'.$key.'" value="'.$val.'">';
	$content = str_replace('#'.$key.'#', $val.'<input type="hidden" name="'.$key.'" value="'.$val.'">', $content);
	$content = str_replace('#!'.$key.'#', $val.'<input type="hidden" name="'.$key.'" value="'.$val.'">', $content);
}

//print_r($_FILES);

foreach( $_FILES as $key => $fileArray ){
	if( $fileArray['size'] > 0 ){
		if ( $fileArray['size'] >= 6048576 ){
			$er_msg .= "添付ファイルが大きすぎます。2Mバイト以内にしてください。";
		}else{
			$nowdate = date('YmdHis');
			move_uploaded_file( $fileArray[ 'tmp_name' ], "upfiles/{$nowdate}_{$fileArray['name']}" );
			$up_hidden = '<input type="hidden" name="file['.$key.'][up]" value="'.$nowdate.'_'.$fileArray['name'].'">';
			$name_hidden = '<input type="hidden" name="file['.$key.'][name]" value="'.$fileArray['name'].'">';
			$content = str_replace('#'.$key.'#', '<img src="./upfiles/'.$nowdate.'_'.$fileArray['name'].'" width="250">'.$up_hidden.$name_hidden, $content);
		}
	}
}

if ( $post_array["mail"] != $post_array["mail_2"] ) $er_msg = "メールアドレスの入力が確認の入力と一致していません"; 

$content = str_replace('#enquete0#', "いいえ", $content);
$content = str_replace('#enquete1#', "いいえ", $content);
$content = str_replace('#enquete2#', "いいえ", $content);
$content = str_replace('#doui#', '<input type="hidden" name="doui" value="">', $content);
$content = str_replace('#pref_r#', '<input type="hidden" name="pref_r" value="">', $content);
$content = str_replace('#hidden#', $hidden, $content);
if ( $er_msg == "" ){
	header("Content-Type: text/html; charset=".$codeType);
	$content = preg_replace("/#(.+?)#/", " ", $content);
	echo $content;
 } else {
 	header("Content-Type: text/html; charset=".$codeType);
 	$er_msg = mb_convert_encoding($er_msg, $codeType, "auto");
 	$content = file_get_contents($error_file);
 	$content = str_replace('#errormsg#', $er_msg, $content);
	echo $content;
}

?>