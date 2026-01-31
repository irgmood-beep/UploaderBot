<?php

include_once '../config.php';
$db = mysqli_connect('localhost', $databaseUser, $databasePass, $databaseName);
#==#
function SBoOS($method, $datas = [])
{
    $url = "https://api.telegram.org/bot" . API_TOKEN . "/" . $method;
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
file_get_contents('https://api.telegram.org/bot' . API_TOKEN . '/setWebHook?url=' . $web . 'bot.php');
file_get_contents($web . 'lib/table.php');
#==#
$usernamebot = SBoOS('getMe')->result->username;

if (!$db)
{
    die("Connection db failed: " . mysqli_connect_error());
} else {
    echo "<h1>The robot was runned ...<br><a href='https://t.me/$usernamebot'>Click to start robot</a><h1>";
    SBoOS('sendMessage', ['chat_id' => $admin, 'text' => "<b>The robot was runned ...\nPlease /start the bot</b>", 'parse_mode' => 'html']);
}