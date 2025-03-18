<?php 
$token = "7875259019:AAGCvVQat9qRyyaaaAEVYJY4320n_wgITsw"; 
require "class.php"; 
require "Telegram.php"; 

$bot = new Telegram($token); 
$info = json_decode(file_get_contents("info.json"), true); 

function save() { 
    global $info; 
    if (!empty($info))  
        file_put_contents("info.json", json_encode($info, 448)); } 
        
$api_key = !empty($info["key"]) ? $info["key"] : null; 
if ($api_key == null) exit; 
$admin = -1001395107790; // ايدي قناة الصيد 
$api = new sms_man_com($api_key); 
while (true) {
    if ($info["status"] == "work") { 
        if (!empty($info["countries"])) { 
            foreach ($info["countries"] as $country) { 
                $res = $api->getNumber((int)($country), "wa"); 
                if ($res["ok"] == true) { 
                    $id = $res["id"]; 
                    $num = $res["number"]; 
                    if (empty($id) || empty($num)) 
                        continue; 
                    $txt = "تم شراء الرقم بنجاح ☑️\n\n📞 الرقم: +$num\n🆔 ايدي العملية: $id\nhttps://wa.me/+$num"; 
                    $bot->sendmessage([ 
                        "chat_id" => $admin, 
                        "text" => $txt, 
                        "parse_mode" => "markdown", 
                        "reply_markup" => json_encode([ 
                            "inline_keyboard" => [ 
                                [["text" => "🌚 طلب الكود", "callback_data" => "getCode#$id#$num"]], 
                                [["text" => "❌ حظر الرقم", "callback_data" => "ban#$id"]] 
                            ] 
                        ]) 
                    ]); 
                    sleep(3); // توقف لثلاث ثواني قبل تكرار العملية
                } else { 
                    continue; 
                } 
            } 
        } else { 
            exit; 
        } 
    } else { 
        exit; 
    } 
}
