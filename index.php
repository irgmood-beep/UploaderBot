<?php

/*
Source code author: @devbc
Configured for: irgmood-beep
*/

// --- بخش تنظیمات اختصاصی ---
$token = "8137720844:AAFzS8tRGmMS6p17oMLydSwAHZtEuQRq084";
$admin = "1328873149";
$dev   = "B9MOD"; 


/*
Source code author: @devbc

channel = https://t.me/Sourrce_kade

Copying without mentioning the source channel is not legal.
*/

include ("config.php");

date_default_timezone_set('Asia/Tehran');
error_reporting(0);

define('API_KEY', $token);

#-----------------------------#

$update = json_decode(file_get_contents("php://input"));
if(isset($update->message)){
    $from_id    = $update->message->from->id;
    $chat_id    = $update->message->chat->id;
    $tc         = $update->message->chat->type;
    $text       = $update->message->text;
    $first_name = $update->message->from->first_name;
    $message_id = $update->message->message_id;
}elseif(isset($update->callback_query)){
    $chat_id    = $update->callback_query->message->chat->id;
    $data       = $update->callback_query->data;
    $query_id   = $update->callback_query->id;
    $message_id = $update->callback_query->message->message_id;
    $in_text    = $update->callback_query->message->text;
    $from_id    = $update->callback_query->from->id;
}

$channel1     = file_get_contents("data/channel/channel1.txt");
$channel2    = file_get_contents("data/channel/channel2.txt");
$channel3     = file_get_contents("data/channel/channel3.txt");
$truechannel1 = json_decode(file_get_contents("https://api.telegram.org/bot$token/getChatMember?chat_id=@$channel1&user_id=".$from_id));
$truechannel2 = json_decode(file_get_contents("https://api.telegram.org/bot$token/getChatMember?chat_id=@$channel2&user_id=".$from_id));
$truechannel3 = json_decode(file_get_contents("https://api.telegram.org/bot$token/getChatMember?chat_id=@$channel3&user_id=".$from_id));
$tch1   = $truechannel1->result->status;
$tch2   = $truechannel2->result->status;
$tch3   = $truechannel3->result->status;
$cha   = "⚙تنظیم کانال";
$fakee = file_get_contents("database/fake.txt");
$up    = file_get_contents("database/up.txt");
$cap   = file_get_contents("database/cap.txt");
$fk    = file_get_contents("database/fk.txt");
$posh  = file_get_contents("database/posh.txt");
$pro   = file_get_contents("database/pro.txt");
$idbot = file_get_contents("database/idbot.txt");
$sett  = file_get_contents("database/sett.txt");
$se    = file_get_contents("database/se.txt");
$oo = "بازگشت به منوی اصلی";   


#-----------------------------#

function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}

function sendmessage($chat_id,$text,$keyboard = null) {
    bot('sendMessage',[
        'chat_id' => $chat_id,
        'text' => $text,
        'parse_mode' => "HTML",
        'disable_web_page_preview' => true,
        'reply_markup' => $keyboard
    ]);
}

#-----------------------------#

$key2 = json_encode(['keyboard'=>[
[['text'=>"💡آمار ربات"],['text'=>"🎈خاموش | روشن"]],
[['text'=>"❌مسدود کردن"],['text'=>"✅رفع مسدودی"]],
[['text'=>"📥فوروراد همگانی"],['text'=>"📤ارسال همگانی"]],
[['text'=>"📌سایر تنظیمات"],['text'=>"📤آپلود فایل vip"]],
],'resize_keyboard' =>true]);

$key3 = json_encode(['keyboard' => [
    [['text' => "$up"]],
    [['text' => "$cap"], ['text' => "$fk"]],
    [['text' => "$posh"], ['text' => "$pro"]]
], 'resize_keyboard' => true]);


$main = json_encode(['keyboard' => [
    [['text' => "$up"]],
    [['text' => "$cap"],['text' => "$fk"]],
    [['text' => "$posh"],['text' => "$pro"]],
], 'resize_keyboard' => true]);

$back = json_encode(['keyboard' => [
    [['text' => "منوی قبل"]]
], 'resize_keyboard' => true]);

$key0 = json_encode(['keyboard' => [
[['text'=>"💥تغییر دکمه $up"],['text'=>"💥تغییر دکمه $cap"]],
[['text'=>"💥تغییر دکمه $fk"],['text'=>"💥تغییر دکمه $posh"]],
[['text'=>"💥تغییر دکمه $pro"],['text'=>"منوی قبل"]],
], 'resize_keyboard' => true]);


$moresetting = json_encode(['keyboard'=>[
[['text'=>"💡تنظیمات مربوط به کانال"]],
[['text'=>"🔘تنظیمات مربوط به اسم دکمه ها"]],
[['text'=>"📑تنظیمات مربوط به متن های ربات"]],
[['text'=>"🤖تنظیم ایدی ربات"]],[['text'=>"📤روشن / خاموش اپلودر کاربر"]],
[['text'=>"🔰تغییر حالت حساب کاربری"]],
[['text'=>"$oo"]],
],'resize_keyboard' =>true]);


$bk = json_encode(['keyboard'=>[
[['text'=>"$oo"]],
],'resize_keyboard' =>true]);


$key6 = json_encode(['keyboard'=>[
[['text'=>"توضیحات"],['text'=>"دریافت فایل vip"]],
],'resize_keyboard' =>true]);

$key7 = json_encode(['keyboard'=>[
[['text'=>"تغییر متن استارت"]],
[['text'=>"تغییر متن توضیحات"]],
[['text'=>"تغییر متن قفل کانال"]],
[['text'=>"تغییر متن قفل پشتیبانی"]],
[['text'=>"تغییر متن حساب کاربری / شیشه ای"]],
[['text'=>"$oo"]],
],'resize_keyboard' =>true]);

#-----------------------------#

$step = file_get_contents("data/user/$from_id/step.txt");

if(file_exists("data/user/$from_id/ban")){
    
    sendmessage($from_id, 'حساب شما مسدود میباشد و به ربات دسترسی ندارید !');
    exit();
    
}

if(!is_dir('data')){
    mkdir('data');
}

if(!is_dir('data/user')){
    mkdir('data/user');
}

if(!is_dir("data/user/$from_id")){
    mkdir("data/user/$from_id");
}

if(!is_dir("data/user/$from_id/files")){
    mkdir("data/user/$from_id/files");
}

if(!file_exists("data/user/$from_id/files/data.json")){
    file_put_contents("data/user/$from_id/files/data.json", json_encode(['files' => [
        'photo' => [],
        'video' => [],
        'music' => [],
        'document' => []
    ]]));
}

if(!file_exists("data/user/$from_id/caption.txt")){

    touch("data/user/$from_id/caption.txt");

}

$user_caption = file_get_contents("data/user/$from_id/caption.txt");
$user_data = json_decode(file_get_contents("data/user/$from_id/files/data.json"), true);

 
  if(!is_dir('database')){
    mkdir('database');
}

if(!file_exists("database/channel.txt")){
    file_put_contents("database/channel.txt","zitactm");
}
if(!file_exists("database/fake.txt")){
    file_put_contents("database/fake.txt","تنظیم نشده است.");
}


if(!file_exists("database/up.txt")){
    file_put_contents("database/up.txt","☁️ آپلود رسانه ☁️");
}



if(!file_exists("database/cap.txt")){
    file_put_contents("database/cap.txt","♻️کپشن");
}

if(!file_exists("database/sett.txt")){
    file_put_contents("database/sett.txt","none");
}


if(!file_exists("database/fk.txt")){
    file_put_contents("database/fk.txt","🗑 حذف فایل");
}


if(!file_exists("database/posh.txt")){
    file_put_contents("database/posh.txt","پشتیبانی 🗣");
}


if(!file_exists("database/pro.txt")){
    file_put_contents("database/pro.txt","⚙️ حساب کاربری");
}

if(!file_exists("database/idbot.txt")){
    file_put_contents("database/idbot.txt","none");
}


if(!file_exists("data/bot.txt")){
    file_put_contents("data/bot.txt", "روشن است ✅");
}

if(!file_exists("data/user/$from_id/ban.txt")){
    file_put_contents("data/user/$from_id/ban.txt", "false");
}

if(!file_exists("data/zitactm.txt")){
    file_put_contents("data/zitactm.txt", "غیر فعال ❌");
}

if(!file_exists("data/@devbc.txt")){
    file_put_contents("data/@devbc.txt", "false");
}

if(!file_exists("database/iamgod.txt")){
    file_put_contents("database/iamgod.txt", "روشن است ✅");
}

if(!file_exists("database/popak.txt")){
    file_put_contents("database/popak.txt", "شیشه ای 🔎");
}

$bot = file_get_contents ("data/bot.txt");
$ban = file_get_contents ("data/user/$from_id/ban.txt");
$zitactm = file_get_contents ("data/zitactm.txt");
$iamgod = file_get_contents ("database/iamgod.txt");
$popak = file_get_contents ("database/popak.txt");

$help = "
سلام دوست عزیز این پیام فقط یکبار برای شما که ادمین هستید ارسال می شود لطفا با دقت مطالعه فرمایید :

پنل مدیریت ربات با دستور /panel یا پنل بارگزاری می شود که شما میتوانید ربات خود را مدیریت کنید .

حتما از مسیر زیر ایدی ربات خود را ثبت کنید تا در دریافت فایل ها مشکلی پیش نیاد ...
پنل-تنظیمات بیشتر - تنظیم ایدی ربات

این ربات توسط @devbc طراحی و نوشته شده است که توسط خودم هم پابلیک شد تا بتونید رایگان استفاده کنید :

حتما داخل کانال منم عضو بشین ممنون

نویسنده : @devbc
کانال من : @zitactm

ورژن فعلی ربات : 1.2.1
";

mkdir ("database/text");

if(!file_exists("database/text/txt1")){
    file_put_contents("database/text/txt1", "متن استارت تنظیم نشده است !");
}
if(!file_exists("database/text/txt2")){
    file_put_contents("database/text/txt2", "متن توضیحات تنظیم نشده است !");
}
if(!file_exists("database/text/txt3")){
    file_put_contents("database/text/txt3", "✅دوست عزیز جهت عضویت در ربات باید وارد کانال های اسپانسر ما شوید و پس از عضویت روی دستور /start کلیک کنید");
}
if(!file_exists("database/text/txt4")){
    file_put_contents("database/text/txt4", "متن پشتیبانی تنظیم نشده است !");
}
if(!file_exists("database/text/txt5")){
    file_put_contents("database/text/txt5", "متن حساب کاربری تنظیم نشده است !");
}
#-----------------------------#
$txt1 = file_get_contents ("database/text/txt1");
$txt2 = file_get_contents ("database/text/txt2");
$txt3 = file_get_contents ("database/text/txt3");
$txt4 = file_get_contents ("database/text/txt4");
$txt5 = file_get_contents ("database/text/txt5");


if($ban == "true" and $chat_id != $admin){
sendmessage ($chat_id , "❌ : متاسفانه شما توسط ادمین های ربات مسدود شده اید اگر فکر میکنید اشتباهی رخ داده است با ایدی زیر در ارتباط باشید . \n @$dev");
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}


if($bot == "خاموش است ⛔" and $chat_id != $admin){
sendmessage ($chat_id , "
⏳ ربات توسط ادمین خاموش شده است .
📌 لطفا بعدا مراجعه کنید .
");
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}



elseif(strpos($text, '/start ') !== false){

    $file_info = str_replace('getfile_', '', explode(' ', $text)[1]);
    $file_type = explode('_', $file_info)[0];
    $file_code = explode('_', $file_info)[1];
    $file_from = explode('_', $file_info)[2];

    $m_type = ['i', 'v', 'd', 'm'];

    @$user_data_f = json_decode(file_get_contents("data/user/$file_from/files/data.json"), true);
    @$user_caption_f = file_get_contents("data/user/$file_from/caption.txt");

    if(is_numeric($file_code)){

        if(in_array($file_type, $m_type)){

            if($file_type == 'i'){

                if($user_data_f['files']['photo'][$file_code]){

                    bot('sendPhoto', ['chat_id' => $from_id, 'photo' => $user_data_f['files']['photo'][$file_code]['file_id'], 'caption' => $user_caption_f]);

                }

            }elseif($file_type == 'v'){

                if($user_data_f['files']['video'][$file_code]){

                    bot('sendvideo', ['chat_id' => $from_id, 'video' => $user_data_f['files']['video'][$file_code]['file_id'], 'caption' => $user_caption_f]);

                }

            }elseif($file_type == 'd'){

                if($user_data_f['files']['document'][$file_code]){

                    bot('sendDocument', ['chat_id' => $from_id, 'document' => $user_data_f['files']['document'][$file_code]['file_id'], 'caption' => $user_caption_f]);

                }

            }elseif($file_type == 'm'){

                if($user_data_f['files']['music'][$file_code]){

                    bot('sendAudio', ['chat_id' => $from_id, 'audio' => $user_data_f['files']['music'][$file_code]['file_id'], 'caption' => $user_caption_f]);

                }

            }

        }

    }

}

	



elseif($zitactm == "فعال ✅"){

if($tch1 != 'member' && $tch1 != 'creator' && $tch1 != 'administrator' && $from_id != $admin && $channel1 != ""){
bot('sendmessage', [
'chat_id' => $chat_id,
'text' => "
$txt3
",
'parse_mode' => "html",
'reply_markup' => json_encode([
'inline_keyboard' => [
[['text' => "$channel1", 'url' => "https://t.me/$channel1"]],
]])
]);
exit();
}

if($tch2 != 'member' && $tch2 != 'creator' && $tch2 != 'administrator' && $from_id != $admin && $channel2 != ""){
bot('sendmessage', [
'chat_id' => $chat_id,
'text' => "
$txt3
",
'parse_mode' => "html",
'reply_markup' => json_encode([
'inline_keyboard' => [
[['text' => "$channel2", 'url' => "https://t.me/$channel2"]],
]])
]);
exit();
}

if($tch3 != 'member' && $tch3 != 'creator' && $tch3 != 'administrator' && $from_id != $admin && $channel3 != ""){
bot('sendmessage', [
'chat_id' => $chat_id,
'text' => "
$txt3
",
'parse_mode' => "html",
'reply_markup' => json_encode([
'inline_keyboard' => [
[['text' => "$channel3", 'url' => "https://t.me/$channel3"]],
]])
]);
exit();
}
	
	}
	
	
	
#-----------------------------#

$iamdevbc = file_get_contents ("data/@devbc.txt");

if($iamdevbc == "false"){
sendmessage ($admin , $help);
file_put_contents ("data/@devbc.txt","true");
}

#-----------------------------#
#-----------------------------#
if($iamgod == "روشن است ✅"){
if($text == "/start" || $text == "منوی قبل"){
sendmessage ($chat_id , "$txt1" , $key3);
file_put_contents ("data/user/$from_id/step.txt","none");
}
if($text == "$posh"){
sendmessage($from_id, "$txt4", $back);
file_put_contents("data/user/$from_id/step.txt", "support");
}
elseif($step == 'support' and !in_array($text, ['/start', 'منوی قبل'])){

if(isset($text)){

        $s_a = json_encode(['inline_keyboard' => [
            [['text' => "پاسخ به این پیام", 'callback_data' => "answer-$from_id"]]
        ]]);

        bot('sendmessage', ['chat_id' => $admin, 'text' => "پیام جدید!\n\nنام فرستنده: <b>$first_name</b>\nآیدی عددی: <a href='tg://user?id=$from_id'>$from_id</a>\n\nمتن پیام:\n\n" . $text, 'reply_markup' => $s_a, 'parse_mode' => 'HTML']);
        sendmessage($from_id, '✔پیام شما با موفقیت ارسال شد .', $back);
        file_put_contents("data/user/$from_id/step.txt", "none");

    }

}

elseif($text == "$pro"){
$time = date('H:i:s');
$f_c = count($user_data['files']['photo']) + count($user_data['files']['video']) + count($user_data['files']['music']) + count($user_data['files']['document']);
$p_s = "
💡 - نام شما : $first_name 
🎫 - شناسه عددی شما : $chat_id 
♻️ - تعداد فایل های شما : $f_c تا  
";
$p_f = json_encode(['inline_keyboard' => [
[['text' =>"$first_name",'callback_data'=>"h"],['text'=>"🎴 - نام شما",'callback_data'=>"h"]],
[['text' =>"$chat_id",'callback_data'=>"h"],['text'=>"💡 - شناسه عددی شما",'callback_data'=>"h"]],
[['text' =>"$f_c تا",'callback_data'=>"h"],['text'=>"♻️ - تعداد فایل های شما",'callback_data'=>"h"]],
]]);
if($popak == "شیشه ای 🔎"){
sendmessage ($chat_id , "$txt5" , $p_f);
}
else{
sendmessage ($chat_id , $p_s);
}
}

if($text == "$cap"){

    if(empty($user_caption)) $user_caption = 'تنظیم نشده است!';
    sendmessage($from_id, "لطفا کپشن مورد نظر را برای فایل های خود ارسال کنید:\n\nکپشن فعلی: $user_caption\n.", $back);
    file_put_contents("data/user/$from_id/step.txt", "set-caption");

}

elseif($step == 'set-caption' and $text != "منوی قبل"){

    file_put_contents("data/user/$from_id/caption.txt", $text);
    sendmessage($from_id, 'کپشن با موفقیت ذخیره شد!', $main);
    file_put_contents("data/user/$from_id/step.txt", "none");

}

if($text == "$fk"){

    sendmessage($from_id, 'آیدی فایل مورد نظر را ارسال کنید:', $back);
    file_put_contents("data/user/$from_id/step.txt", "delete-file");

}

elseif($step == 'delete-file'){

    if(is_numeric($text)){

        if($user_data['files']['photo'][$text]){

            unset($user_data['files']['photo'][$text]);
            file_put_contents("data/user/$from_id/files/data.json", json_encode($user_data));
            file_put_contents("data/user/$from_id/step.txt", "none");
            sendmessage($from_id, "عکس با آیدی $text از دیتابیس حذف شد!", $main);

        }elseif($user_data['files']['video'][$text]){

            unset($user_data['files']['video'][$text]);
            file_put_contents("data/user/$from_id/files/data.json", json_encode($user_data));
            file_put_contents("data/user/$from_id/step.txt", "none");
            sendmessage($from_id, "ویدیو با آیدی $text از دیتابیس حذف شد!", $main);

        }elseif($user_data['files']['music'][$text]){

            unset($user_data['files']['music'][$text]);
            file_put_contents("data/user/$from_id/files/data.json", json_encode($user_data));
            file_put_contents("data/user/$from_id/step.txt", "none");
            sendmessage($from_id, "موزیک با آیدی $text از دیتابیس حذف شد!", $main);

        }elseif($user_data['files']['document'][$text]){

            unset($user_data['files']['document'][$text]);
            file_put_contents("data/user/$from_id/files/data.json", json_encode($user_data));
            file_put_contents("data/user/$from_id/step.txt", "none");
            sendmessage($from_id, "فایل با آیدی $text از دیتابیس حذف شد!", $main);

        }else{

            sendmessage($from_id, 'فایل موجود نیست!');

        }

    }

}

if($text == "$up"){

    file_put_contents("data/user/$from_id/step.txt","upload");
    sendmessage($from_id, 'رسانه خود را ارسال کنید:', $back);

}

elseif($step == 'upload' and $text != "منوی قبل"){

    if($update->message->photo){
        $rand = rand(1111111, 9999999);
        $file_id = $update->message->photo[count($update->message->photo) - 1]->file_id;
        $user_data['files']['photo'][$rand] = ['file_id' => $file_id];
        file_put_contents("data/user/$from_id/files/data.json", json_encode($user_data));
        sendmessage($from_id, "فایل شما با موفقیت آپلود شد!\n\nآیدی فایل: $rand\nلینک دانلود:\nhttps://t.me/$idbot?start=getfile_i_$rand". "_$from_id", $main);
        file_put_contents("data/user/$from_id/step.txt","none");
    }
    elseif($update->message->video){
        $rand = rand(1111111, 9999999);
        $file_id = $update->message->video->file_id;
        $user_data['files']['video'][$rand] = ['file_id' => $file_id];
        file_put_contents("data/user/$from_id/files/data.json", json_encode($user_data));
        sendmessage($from_id, "فایل شما با موفقیت آپلود شد!\n\nآیدی فایل: $rand\nلینک دانلود:\nhttps://t.me/$idbot?start=getfile_v_$rand". "_$from_id", $main);
        file_put_contents("data/user/$from_id/step.txt","none");
    }
    elseif($update->message->document){
        $rand = rand(1111111, 9999999);
        $file_id = $update->message->document->file_id;
        $user_data['files']['document'][$rand] = ['file_id' => $file_id];
        file_put_contents("data/user/$from_id/files/data.json", json_encode($user_data));
        sendmessage($from_id, "فایل شما با موفقیت آپلود شد!\n\nآیدی فایل: $rand\nلینک دانلود:\nhttps://t.me/$idbot?start=getfile_d_$rand". "_$from_id", $main);
        file_put_contents("data/user/$from_id/step.txt","none");
    }
    elseif($update->message->audio){
        $rand = rand(1111111, 9999999);
        $file_id = $update->message->audio->file_id;
        $user_data['files']['music'][$rand] = ['file_id' => $file_id];
        file_put_contents("data/user/$from_id/files/data.json", json_encode($user_data));
        sendmessage($from_id, "فایل شما با موفقیت آپلود شد!\n\nآیدی فایل: $rand\nلینک دانلود:\nhttps://t.me/$idbot?start=getfile_m_$rand". "_$from_id", $main);
        file_put_contents("data/user/$from_id/step.txt","none");
    }else{
        sendmessage($from_id, 'شما فقط میتوانید عکس، ویدیو، موزیک و یا داکیومنت ارسال کنید:');
   
    }

}



}

elseif($iamgod == "خاموش است ⛔"){

if($text == "/start" || $text == "منوی قبل"){
sendmessage ($chat_id , "$txt1" , $key6);
file_put_contents ("data/user/$from_id/step.txt","none");
}

if($text == "توضیحات"){
sendmessage ($chat_id , "$txt2");
file_put_contents ("data/user/$from_id/step.txt","none");
}

if($text == "دریافت فایل vip" || $text == "cmd_5000"){
sendmessage ($chat_id , "🔗لطفا پسورد فایل را وارد کنید :" , $back);
file_put_contents ("data/user/$from_id/step.txt","nop");
}
elseif($step == "nop" and $text != "منوی قبل"){
$kolam = file_get_contents ("data/vipfile/$text/file");
$kalam = file_get_contents ("data/vipfile/$text/cap");
$llla = file_get_contents ("data/vipfile/$text/ok");
if(!is_dir("data/vipfile/$text")){
sendmessage ($chat_id , "چنین فایلی وجود ندارد !");
}

if($llla == "photo"){
bot('sendphoto',[
'chat_id'=>$chat_id,
'photo'=>"$kolam",
'caption'=>"$kalam",
]);
}

if($llla == "video"){
bot('sendvideo',[
'chat_id'=>$chat_id,
'video'=>"$kolam",
'caption'=>"$kalam",
]);
}

if($llla == "audio"){
bot('sendAudio',[
'chat_id'=>$chat_id,
'audio'=>"$kolam",
'caption'=>"$kalam",
]);
}

if($llla == "document"){
bot('sendDocument',[
'chat_id'=>$chat_id,
'document'=>"$kolam",
'caption'=>"$kalam",
]);
}

}
}



#-----------------------------#
if($from_id == $admin){
if($text == "/panel" || $text == "پنل"){
sendmessage ($chat_id , "✅پنل مدیریت بارگزاری شد..." , $key2);
file_put_contents ("data/user/$from_id/step.txt","none");
}

if($text == "$oo"){
sendmessage ($chat_id , "به منوی اصلی برگشتیم" , $key2);
file_put_contents ("data/user/$from_id/step.txt","none");
}
    
 if($text == "💡آمار ربات"){
 $scan = scandir('data/user');
 $users_count = count($scan) - 2;
 $bot = file_get_contents ("data/bot.txt");
 $amarok = json_encode(['inline_keyboard' => [
[['text' =>"$users_count نفر",'callback_data'=>"hdhdh"],['text'=>"📌تعداد کاربران :",'callback_data'=>"hsh"]],
[['text' =>"$bot",'callback_data'=>"hdhdbshh"],['text'=>"⏳وضعیت ربات :",'callback_data'=>"hsedyh"]],
[['text' =>"$iamgod",'callback_data'=>"hdhdbshh"],['text'=>"📤آپلودر کاربر :",'callback_data'=>"hsedyh"]],
]]);
sendmessage($from_id, "🏷آمار ربات شما به شرح زیر می باشد :" , $amarok);
    }
    
elseif($text == "🎈خاموش | روشن"){
$bot = file_get_contents ("data/bot.txt");
if($bot == "روشن است ✅"){
file_put_contents ("data/bot.txt","خاموش است ⛔");
sendmessage ($chat_id , "⛔ربات با موفقیت خاموش شد");
}
else{
file_put_contents ("data/bot.txt","روشن است ✅");
sendmessage ($chat_id , "✅ربات با موفقیت روشن شد");
}
file_put_contents ("data/user/$from_id/step.txt","none");
}

elseif($text == "📤روشن / خاموش اپلودر کاربر"){
if($iamgod == "روشن است ✅"){
file_put_contents ("database/iamgod.txt","خاموش است ⛔");
sendmessage ($chat_id , "🙂 حالت اپلود رسانه توسط کاربر خاموش شد .");
}
else{
file_put_contents ("database/iamgod.txt","روشن است ✅");
sendmessage ($chat_id , "🔥حالت اپلود رسانه توسط کاربر روشن شد .");
}
file_put_contents ("data/user/$from_id/step.txt","none");
}


if($text == "📌سایر تنظیمات"){
sendmessage ($chat_id , "☑یکی از بخش های زیر را انتخاب کنید :" , $moresetting);
file_put_contents ("data/user/$from_id/step.txt","none");
}


if($text == "❌مسدود کردن"){
sendmessage ($chat_id , "☑ایدی عددی کاربر مورد نظر را وارد کنید :" , $bk);
file_put_contents ("data/user/$from_id/step.txt","banuser");
}

elseif($step == "banuser" and $text != $oo){
if(!is_Numeric($text)){
sendmessage ($chat_id , "❌ • از اعداد استفاده کنید");
file_put_contents ("data/user/$from_id/step.txt","banuser");
exit();
}
if(!is_dir("data/user/$text")){
sendmessage ($chat_id , "خطا : این کاربر وجود ندارد .");
file_put_contents ("data/user/$from_id/step.txt","banuser");
exit();
}
else{
file_put_contents ("data/user/$text/ban.txt","true");
sendmessage ($chat_id , "🔥کاربر با ایدی عددی : $text از ربات مسدود شد ." , $bk);
file_put_contents ("data/user/$from_id/step.txt","none");
}
}

if($text == "✅رفع مسدودی"){
sendmessage ($chat_id , "☑ایدی عددی کاربر مورد نظر را وارد کنید :" , $bk);
file_put_contents ("data/user/$from_id/step.txt","unban");
}

elseif($step == "unban" and $text != $oo){
if(!is_Numeric($text)){
sendmessage ($chat_id , "❌ • از اعداد استفاده کنید" , $bk);
file_put_contents ("data/user/$from_id/step.txt","unban");
exit();
}
if(!is_dir("data/user/$text")){
sendmessage ($chat_id , "خطا : این کاربر وجود ندارد ." , $bk);
file_put_contents ("data/user/$from_id/step.txt","unban");
exit();
}
$band = file_get_contents ("data/user/$text/ban.txt");
if($band == "false"){
sendmessage ($chat_id , "این کاربر مسدود نمی باشد ." , $bk);
file_put_contents ("data/user/$from_id/step.txt","unban");
exit();
}
else{
file_put_contents ("data/user/$text/ban.txt","false");
sendmessage ($chat_id , "🔥کاربر با ایدی عددی : $text از ربات آزاد شد ." , $bk);
file_put_contents ("data/user/$from_id/step.txt","none");
}
}
    
if($text == "📤ارسال همگانی"){
sendmessage($from_id, "📌 یک پیام دارم برای ممبرای عزیز پیام شما : ؟", $bk);
file_put_contents("data/user/$from_id/step.txt", "send-to-all");
}
    
if($text == "📥فوروراد همگانی"){
sendmessage($from_id, "پیام خود را جهت فروارد به تمامی کاربران، به من فروارد کنید...", $bk);
file_put_contents("data/user/$from_id/step.txt", "for-to-all");
}
    
elseif($step == "send-to-all" and $text != $oo){
        
if($text){
$users_array = scandir('data/user');
unset($users_array[0]);
unset($users_array[1]);
foreach($users_array as $id_to_send){
sendmessage($id_to_send, $text);
}
file_put_contents("data/user/$from_id/step.txt", "none");
sendmessage($from_id, "عملیات ارسال همگانی با موفقیت انجام شد!", $key2);
}else{
sendmessage($from_id, "🔗شما فقط میتوانید یک پیام بدین به ممبرای عزیز عکس و فیلم و فایل نمیشه");
}
}
    
elseif($step == "for-to-all"){     
$users_array = scandir('data/user');
unset($users_array[0]);
unset($users_array[1]);
        
foreach($users_array as $id_to_send){
            
bot('forwardMessage', [
'from_chat_id' => $from_id,
'message_id' => $message_id,
'chat_id' => $id_to_send,
]);
}
        
file_put_contents("data/user/$from_id/step.txt", "none");
sendmessage($from_id, "عملیات فروارد همگانی با موفقیت انجام شد!", $key2);
}
    
    elseif(strpos($data, 'answer') !== false){

        $rcv = explode("-", $data)[1];
        file_put_contents("data/user/$from_id/step.txt", "answer-$rcv");
        sendmessage($from_id, 'پیام خود را ارسال کنید تا برای کاربر مورد نظرتان ارسال کنم.', $back_panel);

    }
    
    
if($text == "💡تنظیمات مربوط به کانال"){
$channelsetting = json_encode(['inline_keyboard' => [
[['text'=>"🔗وضعیت قفل کانال : $zitactm",'callback_data'=>"vgg"]],
[['text' =>"$channel1",'callback_data'=>"vvv"],['text'=>"📌کانال اول :",'callback_data'=>"vgg"]],
[['text' =>"$channel2",'callback_data'=>"vvv"],['text'=>"📌کانال دوم :",'callback_data'=>"vgg"]],
[['text' =>"$channel3",'callback_data'=>"vvv"],['text'=>"📌کانال سوم :",'callback_data'=>"vgg"]],
[['text'=>"فعال / غیر فعال سازی قفل کانال",'callback_data'=>"setjoin"]],
[['text'=>"⏳ریست قفل ها",'callback_data'=>"ohno"]],
[['text'=>"🏷ثبت کانال",'callback_data'=>"setchannel"]],
]]);
sendmessage ($chat_id , "🔥تمامی اطلاعات مربوط به کانال های ثبت شده برای ربات و همچنین تنظیمات فعال سازی و غیر فعال سازی قفل کانال را مشاهده میکنید :" , $channelsetting);
file_put_contents ("data/user/$from_id/step.txt","none");
}   


if($text == "📤آپلود فایل vip"){
sendmessage ($chat_id , "✔فایل خود را ارسال کنید :" , $bk);
file_put_contents ("data/user/$from_id/step.txt","filevip");
}

elseif($step == "filevip" and $text != $oo){

mkdir ("data/vipfile");

if($update->message->photo){
$rand = rand(1111111, 9999999);
$file_id = $update->message->photo[count($update->message->photo) - 1]->file_id;
mkdir ("data/vipfile/$rand");
file_put_contents ("data/vipfile/$rand/file",$file_id);   
file_put_contents ("data/vipfile/$rand/ok","photo");       
bot('sendmessage',[
'chat_id'=> $chat_id,
'text'=> "🔗فایل ذخیره شد اکنون کپشن خود را وارد کنید :",
'reply_markup'=>$bk,
'parse_mode'=>"Markdown",
]);
file_put_contents ("data/vipfile/pas",$rand);
file_put_contents ("data/user/$from_id/step.txt","setpo");
}

elseif($update->message->video){
$rand = rand(1111111, 9999999);
$file_id = $update->message->video->file_id;
mkdir ("data/vipfile/$rand");
file_put_contents ("data/vipfile/$rand/file",$file_id);    
file_put_contents ("data/vipfile/$rand/ok","video");          
bot('sendmessage',[
'chat_id'=> $chat_id,
'text'=> "🔗فایل ذخیره شد اکنون کپشن خود را وارد کنید :",
'reply_markup'=>$bk,
'parse_mode'=>"Markdown",
]);        
file_put_contents ("data/vipfile/pas",$rand);
 file_put_contents ("data/user/$from_id/step.txt","setpo");       
        }
        
        
elseif($update->message->document){
$rand = rand(1111111, 9999999);
$file_id = $update->message->document->file_id;
mkdir ("data/vipfile/$rand");
file_put_contents ("data/vipfile/$rand/file",$file_id);       
file_put_contents ("data/vipfile/$rand/ok","document");       
bot('sendmessage',[
'chat_id'=> $chat_id,
'text'=> "🔗فایل ذخیره شد اکنون کپشن خود را وارد کنید :",
'reply_markup'=>$bk,
'parse_mode'=>"Markdown",
]);    
file_put_contents ("data/vipfile/pas",$rand);
file_put_contents ("data/user/$from_id/step.txt","setpo");    
   }
                                                                            
elseif($update->message->audio){
$rand = rand(1111111, 9999999);
$file_id = $update->message->audio->file_id;
mkdir ("data/vipfile/$rand");
file_put_contents ("data/vipfile/$rand/file",$file_id);       
file_put_contents ("data/vipfile/$rand/ok","audio");       
bot('sendmessage',[
'chat_id'=> $chat_id,
'text'=> "🔗فایل ذخیره شد اکنون کپشن خود را وارد کنید :",
'reply_markup'=>$bk,
'parse_mode'=>"Markdown",
]);
file_put_contents ("data/vipfile/pas",$rand);
       file_put_contents ("data/user/$from_id/step.txt","setpo"); 
}

}

if($step == "setpo" and $text != $o){
$kopl = file_get_contents ("data/vipfile/pas");
file_put_contents ("data/vipfile/$kopl/cap",$text);
bot('sendmessage',[
'chat_id'=> $chat_id,
'text'=> "✅فایل شما با موفقیت به صورت ویژه ثبت شد : \n\n شناسه فایل : `$kopl`",
'reply_markup'=>$bk,
'parse_mode'=>"Markdown",
]);
file_put_contents ("data/user/$from_id/step.txt","none");
}


if($data == "ohno"){
unlink ("data/channel/channel1.txt");
unlink ("data/channel/channel3.txt");
unlink ("data/channel/channel2.txt");
bot('answerCallbackQuery',[
'callback_query_id' => $query_id,
'text' => "تمام قفل های کانال ها پاک شد .",
'show_alert' => true,
]);
file_put_contents ("data/user/$from_id/step.txt","none");
}


elseif($data == "setjoin"){
if($zitactm == "غیر فعال ❌"){
file_put_contents ("data/zitactm.txt", "فعال ✅");
bot('answerCallbackQuery',[
'callback_query_id' => $query_id,
'text' => "🔥 قفل جوین اجباری با موفقیت روشن شد .",
'show_alert' => true,
]);
}
else{
file_put_contents ("data/zitactm.txt","غیر فعال ❌");
bot('answerCallbackQuery',[
'callback_query_id' => $query_id,
'text' => "✅ قفل جوین اجباری با موفقیت غیر فعال شد ",
'show_alert' => true,
]);
file_put_contents ("data/user/$from_id/step.txt","none");
} 
  }  
  
  
if($data == "setchannel"){
mkdir ("data/channel");
$keyzitactm = json_encode(['keyboard'=>[
[['text'=>"کانال اول"],['text'=>"کانال دوم"]],
[['text'=>"کانال سوم"],['text'=>"$oo"]],
],'resize_keyboard' =>true]);
sendmessage ($chat_id , "🔥از پنل موجود دکمه مورد نظر خود را انتخاب کنید " , $keyzitactm);
file_put_contents ("data/user/$from_id/step.txt","none");
}


if($text == "📑تنظیمات مربوط به متن های ربات"){
sendmessage ($chat_id , "📌یکی از قسمت های موجود را انتخاب کنید : " , $key7);
file_put_contents ("data/user/$from_id/step.txt","none");
}

#-----------------------------#

elseif($text == "🔰تغییر حالت حساب کاربری"){
if($popak == "شیشه ای 🔎"){
file_put_contents ("database/popak.txt","متنی 📑");
sendmessage ($chat_id , "✅قسمت حساب کاربری به حالت متنی تغییر پیدا کرد !");
}
else{
file_put_contents ("database/popak.txt","شیشه ای 🔎");
sendmessage ($chat_id , "✅قسمت حساب کاربری به حالت شیشه ای تغییر پیدا کرد !");
}
file_put_contents ("data/user/$from_id/step.txt","none");
}

if($text == "تغییر متن استارت"){
sendmessage ($chat_id , "متن مورد نظر را وارد کنید : \n\n متن فعلی : $txt1" , $bk);
file_put_contents ("data/user/$from_id/step.txt","settxt1");
}

if($step == "settxt1" and $text != $oo){
file_put_contents ("database/text/txt1",$text);
sendmessage ($chat_id , "متن قسمت مورد نظر به $text تغییر پیدا کرد ✔" , $key7);
file_put_contents ("data/user/$from_id/step.txt","none");
}

if($text == "تغییر متن توضیحات"){
sendmessage ($chat_id , "متن مورد نظر را وارد کنید : \n\n متن فعلی : $txt2" , $bk);
file_put_contents ("data/user/$from_id/step.txt","settxt2");
}

if($step == "settxt2" and $text != $oo){
file_put_contents ("database/text/txt2",$text);
sendmessage ($chat_id , "متن قسمت مورد نظر به $text تغییر پیدا کرد ✔" , $key7);
file_put_contents ("data/user/$from_id/step.txt","none");
}

if($text == "تغییر متن قفل کانال"){
sendmessage ($chat_id , "متن مورد نظر را وارد کنید : \n\n متن فعلی : $txt3" , $bk);
file_put_contents ("data/user/$from_id/step.txt","settxt3");
}

if($step == "settxt3" and $text != $oo){
file_put_contents ("database/text/txt3",$text);
sendmessage ($chat_id , "متن قسمت مورد نظر به $text تغییر پیدا کرد ✔" , $key7);
file_put_contents ("data/user/$from_id/step.txt","none");
}

if($text == "تغییر متن قفل پشتیبانی"){
sendmessage ($chat_id , "متن مورد نظر را وارد کنید : \n\n متن فعلی : $txt4" , $bk);
file_put_contents ("data/user/$from_id/step.txt","settxt4");
}

if($step == "settxt4" and $text != $oo){
file_put_contents ("database/text/txt4",$text);
sendmessage ($chat_id , "متن قسمت مورد نظر به $text تغییر پیدا کرد ✔" , $key7);
file_put_contents ("data/user/$from_id/step.txt","none");
}


if($text == "تغییر متن حساب کاربری / شیشه ای"){
sendmessage ($chat_id , "متن مورد نظر را وارد کنید : \n\n متن فعلی : $txt5" , $bk);
file_put_contents ("data/user/$from_id/step.txt","settxt5");
}

if($step == "settxt5" and $text != $oo){
file_put_contents ("database/text/txt5",$text);
sendmessage ($chat_id , "متن قسمت مورد نظر به $text تغییر پیدا کرد ✔" , $key7);
file_put_contents ("data/user/$from_id/step.txt","none");
}

#-----------------------------#



if($text == "کانال اول"){
sendmessage ($chat_id , "ایدی کانال خود را بدون @ وارد کنید ." , $bk);
file_put_contents ("data/user/$from_id/step.txt","set1");
}

if($step == "set1" and $text != $oo){
file_put_contents ("data/channel/channel1.txt",$text);
sendmessage ($chat_id , "کانال با موفقیت ثبت شد .");
file_put_contents ("data/user/$from_id/step.txt","none");
}

if($text == "کانال دوم"){
sendmessage ($chat_id , "ایدی کانال خود را بدون @ وارد کنید ." , $bk);
file_put_contents ("data/user/$from_id/step.txt","set2");
}

if($step == "set2" and $text != $oo){
file_put_contents ("data/channel/channel2.txt",$text);
sendmessage ($chat_id , "کانال با موفقیت ثبت شد .");
file_put_contents ("data/user/$from_id/step.txt","none");
}


if($text == "کانال سوم"){
sendmessage ($chat_id , "ایدی کانال خود را بدون @ وارد کنید ." , $bk);
file_put_contents ("data/user/$from_id/step.txt","set3");
}

if($step == "set3" and $text != $oo){
file_put_contents ("data/channel/channel3.txt",$text);
sendmessage ($chat_id , "کانال با موفقیت ثبت شد .");
file_put_contents ("data/user/$from_id/step.txt","none");
}
    

    elseif(strpos($step, 'answer') !== false and $text){

        bot('sendmessage', ['chat_id' => explode("-", $step)[1], 'text' => $text]);
        sendmessage($from_id, 'پیام شما برای این کاربر ارسال شد!', $key2);
        file_put_contents("data/user/$from_id/step.txt", "none");

    }
    
    
    if($text == "$cha"){
    file_put_contents("data/user/$from_id/step.txt","channel.txt");
    sendmessage($chat_id, "متن خود را ارسال کنید");
}
if($step == "channel.txt"){
    file_put_contents("data/user/$from_id/step.txt","none");
    file_put_contents("database/channel.txt","$text");
    sendmessage($chat_id, "انجام شد");
}
  
    
if($text == "💥تغییر دکمه $up"){
    file_put_contents("data/user/$from_id/step.txt","up.txt");
    sendmessage($chat_id, "متن خود را ارسال کنید" , $bk);
}
if($step == "up.txt" and $text != $oo){
    file_put_contents("data/user/$from_id/step.txt","none");
    file_put_contents("database/up.txt","$text");
    sendmessage($chat_id, "انجام شد");
}
if($text == "💥تغییر دکمه $cap"){
    file_put_contents("data/user/$from_id/step.txt","cap.txt");
    sendmessage($chat_id, "متن خود را ارسال کنید" , $bk);
}
if($step == "cap.txt" and $text != $oo){
    file_put_contents("data/user/$from_id/step.txt","none");
    file_put_contents("database/cap.txt","$text");
    sendmessage($chat_id, "انجام شد");
}
if($text == "💥تغییر دکمه $fk"){
    file_put_contents("data/user/$from_id/step.txt","fk.txt");
    sendmessage($chat_id, "متن خود را ارسال کنید" , $bk);
}
if($step == "fk.txt" and $text != $oo){
    file_put_contents("data/user/$from_id/step.txt","none");
    file_put_contents("database/fk.txt","$text");
    sendmessage($chat_id, "انجام شد");
}
if($text == "💥تغییر دکمه $posh"){
    file_put_contents("data/user/$from_id/step.txt","posh.txt");
    sendmessage($chat_id, "متن خود را ارسال کنید" , $bk);
}
if($step == "posh.txt" and $text != $oo){
    file_put_contents("data/user/$from_id/step.txt","none");
    file_put_contents("database/posh.txt","$text");
    sendmessage($chat_id, "انجام شد");
}
if($text == "💥تغییر دکمه $pro"){
    file_put_contents("data/user/$from_id/step.txt","pro.txt");
    sendmessage($chat_id, "متن خود را ارسال کنید" , $bk);
}
if($step == "pro.txt" and $text != $oo){
    file_put_contents("data/user/$from_id/step.txt","none");
    file_put_contents("database/pro.txt","$text");
    sendmessage($chat_id, "انجام شد");
}
if($text == "💥تغییر دکمه $sett"){
    file_put_contents("data/user/$from_id/step.txt","sett.txt");
    sendmessage($chat_id, "متن خود را ارسال کنید" , $bk);
}
if($step == "sett.txt" and $text != $oo){
    file_put_contents("data/user/$from_id/step.txt","none");
    file_put_contents("database/sett.txt","$text");
    sendmessage($chat_id, "انجام شد");
}
if($text == "🤖تنظیم ایدی ربات"){
    file_put_contents("data/user/$from_id/step.txt","idbot.txt");
    sendmessage($chat_id, "ایدی ربات خود را بدون @ ارسال کنید..." , $bk);
}
if($step == "idbot.txt" and $text != $oo){
    file_put_contents("data/user/$from_id/step.txt","none");
    file_put_contents("database/idbot.txt","$text");
    sendmessage($chat_id, "انجام شد");
}


if($text == "🔘تنظیمات مربوط به اسم دکمه ها"){
sendmessage ($chat_id , "👌یکی از بخش های موجود را انتخاب کنید " , $key0);
file_put_contents ("data/user/$from_id/step.txt","none");
}
 
}

#-----------------------------#
/*
Source code author: @devbc

channel = https://t.me/Sourrce_kade

Copying without mentioning the source channel is not legal.
*/


?>