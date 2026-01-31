<?php

require_once '../config.php';
$db = mysqli_connect('localhost', $databaseUser, $databasePass, $databaseName);
#==# functions #==#
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
$time = time();
$send = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM `send`"));
$del = mysqli_query($db, "SELECT * FROM `del` WHERE `timeDel` < $time LIMIT 100 OFFSET 0");
$admin = $send['from'];
$usersCount = mysqli_num_rows(mysqli_query($db, "SELECT * FROM `user`"));
#== send ==#
if ($send['step']) {
    $users = mysqli_query($db, "SELECT * FROM `user` LIMIT 100 OFFSET {$send['user']}");
    while ($row = mysqli_fetch_assoc($users)) {
        $id = $row['from_id'];
        $sendText = urldecode($send['text']);
        if ($send['step'] == 'for') $message = SBoOS('ForwardMessage', ['chat_id' => $id, 'from_chat_id' => $send['from'], 'message_id' => $sendText, 'parse_mode' => 'html']);
        else SBoOS('sendMessage', ['chat_id' => $id, 'text' => $sendText, 'disable_web_page_preview' => true, 'parse_mode' => 'html']);
        $db->query("UPDATE `send` SET `user` = `user` + 1 WHERE 1");
    }
    
    if ($send['count'] + 101 > $usersCount) {
        SBoOS('sendMessage', ['chat_id' => $admin, 'text' => "☑️ پیام برای" . number_format($usersCount) . " کابران ارسال شد"]);
        $db->query("DELETE FROM `send` WHERE 1");
    }
} else echo "There is no message to send<br><br>";

#== delete message ==#
if (mysqli_num_rows($del) > 0) {
    while ($row = mysqli_fetch_assoc($del)) {
        SBoOS('deleteMessage', ['chat_id' => $row['from_id'], 'message_id' => $row['message_id']]);
        $db->query("DELETE FROM `del` WHERE `message_id` = {$row['message_id']} AND `from_id` = {$row['from_id']}");
    }
    echo "100 messages were successfully deleted<br><br>";
} else echo "There is no message to delete<br><br>";
