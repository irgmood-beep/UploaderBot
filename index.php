<?php

/*
Source code for: B9MOD
Original author: @devbc
Final Optimization for InfinityFree
*/

// --- رفع محدودیت امنیتی InfinityFree برای تلگرام ---
if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) || isset($_SERVER['HTTP_USER_AGENT'])){
    // اجازه عبور به درخواست‌های بات تلگرام
}

// --- تنظیمات اصلی ---
$token = "8137720844:AAFzS8tRGmMS6p17oMLydSwAHZtEuQRq084";
$admin = "1328873149";
$dev   = "B9MOD"; 
$channel1 = "B9MOD";
$channel2 = "B9MODGP";

define('API_KEY', $token);

date_default_timezone_set('Asia/Tehran');
error_reporting(0);

// --- توابع اصلی ---

function bot($method, $datas = []) {
    $url = "https://api.telegram.org/bot" . API_KEY . "/" . $method;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
    $res = curl_exec($ch);
    return json_decode($res);
}

function sendmessage($chat_id, $text, $keyboard = null) {
    return bot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => $text,
        'parse_mode' => "HTML",
        'disable_web_page_preview' => true,
        'reply_markup' => $keyboard
    ]);
}

// --- دریافت آپدیت‌ها ---
$update = json_decode(file_get_contents("php://input"));

if (isset($update->message)) {
    $from_id    = $update->message->from->id;
    $chat_id    = $update->message->chat->id;
    $text       = $update->message->text;
    $first_name = $update->message->from->first_name;
} elseif (isset($update->callback_query)) {
    $chat_id    = $update->callback_query->message->chat->id;
    $from_id    = $update->callback_query->from->id;
    $data       = $update->callback_query->data;
}

// --- ساخت دیتابیس کوچک ---
if (!is_dir('data')) mkdir('data');
if (!is_dir('data/user')) mkdir('data/user');
if ($from_id && !is_dir("data/user/$from_id")) {
    mkdir("data/user/$from_id");
    file_put_contents("data/user/$from_id/step.txt", "none");
}

// --- بررسی وضعیت عضویت ---
$status1 = bot('getChatMember', ['chat_id' => "@$channel1", 'user_id' => $from_id])->result->status;
$status2 = bot('getChatMember', ['chat_id' => "@$channel2", 'user_id' => $from_id])->result->status;

// --- دکمه‌ها ---
$up    = "☁️ آپلود رسانه ☁️";
$cap   = "♻️کپشن";
$fk    = "🗑 حذف فایل";
$posh  = "پشتیبانی 🗣";
$pro   = "⚙️ حساب کاربری";

$main_keyboard = json_encode(['keyboard' => [
    [['text' => $up]],
    [['text' => $cap], ['text' => $fk]],
    [['text' => $posh], ['text' => $pro]],
], 'resize_keyboard' => true]);

// --- منطق دستورات ---

// قفل کانال
if ($from_id && ($status1 == 'left' || $status2 == 'left')) {
    if ($from_id != $admin) {
        sendmessage($chat_id, "⚠️ <b>برای استفاده از ربات باید در کانال‌های زیر عضو شوید:</b>\n\n📣 @$channel1\n📣 @$channel2\n\nبعد از عضویت /start بزنید.");
        exit();
    }
}

// استارت و دریافت فایل
if (strpos($text, "/start") !== false) {
    $start_data = str_replace("/start ", "", $text);
    
    if ($start_data != "/start" && file_exists("data/file_$start_data.txt")) {
        $file_id = file_get_contents("data/file_$start_data.txt");
        bot('sendDocument', ['chat_id' => $chat_id, 'document' => $file_id, 'caption' => "✅ فایل شما آماده است."]);
    } else {
        file_put_contents("data/user/$from_id/step.txt", "none");
        sendmessage($chat_id, "سلام <b>$first_name</b> خوش آمدی!\nاز دکمه‌های زیر استفاده کن:", $main_keyboard);
    }
}

// پنل مدیریت
elseif ($text == "/panel" && $chat_id == $admin) {
    sendmessage($chat_id, "ادمین عزیز به پنل خوش آمدی.");
}

// شروع فرآیند آپلود
elseif ($text == $up) {
    file_put_contents("data/user/$from_id/step.txt", "uploading");
    sendmessage($chat_id, "📥 لطفاً فایل خود را بفرستید (داکیومنت، ویدیو، عکس):", json_encode(['keyboard' => [[['text' => "لغو"]]], 'resize_keyboard' => true]));
}

// لغو عملیات
elseif ($text == "لغو") {
    file_put_contents("data/user/$from_id/step.txt", "none");
    sendmessage($chat_id, "عملیات لغو شد.", $main_keyboard);
}

// دریافت و ذخیره فایل
elseif (file_get_contents("data/user/$from_id/step.txt") == "uploading") {
    $file_id = "";
    if (isset($update->message->document)) $file_id = $update->message->document->file_id;
    elseif (isset($update->message->video)) $file_id = $update->message->video->file_id;
    elseif (isset($update->message->audio)) $file_id = $update->message->audio->file_id;
    elseif (isset($update->message->photo)) $file_id = $update->message->photo[count($update->message->photo)-1]->file_id;

    if ($file_id != "") {
        $code = rand(1000, 9999) . time();
        file_put_contents("data/file_$code.txt", $file_id);
        
        $bot_info = bot('getMe');
        $username = $bot_info->result->username;
        $link = "https://t.me/$username?start=$code";
        
        sendmessage($chat_id, "✅ <b>فایل ذخیره شد!</b>\n\n🔗 لینک اشتراک‌گذاری:\n<code>$link</code>", $main_keyboard);
        file_put_contents("data/user/$from_id/step.txt", "none");
    } else {
        sendmessage($chat_id, "❌ خطا! لطفاً یک فایل معتبر بفرستید.");
    }
}

?>
