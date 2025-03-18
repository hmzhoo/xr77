<?php
$token = "7690752619:AAFDTs0sBGvBgAkapX4PDZp6FYcXX53YilM";
$update = json_decode(file_get_contents('php://input'));
if(isset($update->message) || isset($update->callback_query)):
$message = $update->message ;
$data=  $update->callback_query->data;
$id = $message->from->id ?? $update->callback_query->from->id;
$chat_id = $message->chat->id ?? $update->callback_query->message->chat->id;
$text = $message->text ;
$user = $message->from->username ?? $update->callback_query->from->username;
$name = $message->from->first_name ?? $update->callback_query->from->first_name;
$message_id = $message->message_id ?? $update->callback_query->message->message_id;
$type = $message->chat->type ?? $update->callback_query->message->chat->type;
$reply = $message->reply_to_message;
endif;
$link =  "https://".$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"];
echo file_get_contents("https://api.telegram.org/bot$token/setWebHook?url=$link");
$info = json_decode(file_get_contents("info.json"),1);
function save(){
	global $info;
	if(! empty ($info)) 
	file_put_contents("info.json",json_encode($info,448));
}
$api_key = ! empty ($info["key"])?$info["key"]: null;
$admin =5295190543 ;//ايدي الادمن
require "class.php";
require "Telegram.php";
$api = new sms_man_com ($api_key);
$bot = new Telegram ($token);
$ex = explode ("#",$data);
if($id == $admin ){
	
	if($text == "/start" or $data == "back") {
		$info["admin"] = "";
		save();
		if($data=="back")
		$bot->deletemessage ([
			"chat_id"=>$chat_id,
			"message_id"=>$message_id
		]);
		$bot->sendmessage ([
			"chat_id"=>$chat_id,
			"text"=>" مرحبآ عزيزي الادمن \n معلومه عند ايقاف الصيد يستمر الصيد بعد الايقاف دقايق ثم يتوقف \n عليك ادخال التوكن البوت واضافه رموز الدول لكي تتمكن من الصيد من الازرار التاليه",
			"reply_markup"=>json_encode([
				"inline_keyboard"=>[
					[["text"=>"اضافة دولة ➕","callback_data"=>"add"],
					["text"=>"حذف دولة 🗑️","callback_data"=>"del"]],
					[["text"=>"رفع api key","callback_data"=>"up"],
					["text"=>"حذف api key","callback_data"=>"rem"]],
					[["text"=>"الدول المضافة 📊","callback_data"=>"all"]],
					[["text"=>"تشغيل الصيد","callback_data"=>"work"]],
					[["text"=>"ايقاف الصيد","callback_data"=>"stop"]],
					[["text"=>"رموز  الدول في الموقع","callback_data"=>"infouse"]],
				]
			])
		]);
		
	} elseif($data == "work") {
		$bot->sendmessage ([
			"chat_id"=>$chat_id,
			"text"=>"تم تشغيل الصيد"
		]);
		$info["status"]="work";
		save();
	} elseif($data == "infouse") {
       $bot->sendmessage(["chat_id"=>$chat_id,
			"text"=>"
0 الاتحاد الروسي
 2-كازاخستان
 3-الصين
 1 أوكرانيا
 187-الولايات المتحدة الأمريكية
 7 ماليزيا
 6-اندونيسيا
 4-الفلبين
 5-ميانمار
 10 فييت نام
 32-رومانيا
 15 بولندا
 36-كندا
 22-الهند
 147-زامبيا
 66-باكستان
 60-بنجلاديش
 54-المكسيك
 24-24 كمبوديا
 90-نيكاراغوا
 8-كينيا
 11 قرغيزستان
 13 إسرائيل
 14 هونج كونج
 16-المملكة المتحدة لبريطانيا العظمى وأيرلندا الشمالية
 17-مدغشقر
 150-الكونغو
 19-نيجيريا
 20 ماكاو
 21 مصر
 23-أيرلندا
 25 جمهورية لاو الديمقراطية الشعبية
 26-هايتي
 27-كوت ديفوار
 28-غامبيا
 29-صربيا
 30 اليمن
 31-جنوب افريقيا
 33-كولومبيا
 34-إستونيا
 35-أذربيجان
 37-المغرب
 38-غانا
 39-الأرجنتين
 40 أوزبكستان
 41-الكاميرون
 42-تشاد
 43-ألمانيا
 44-ليتوانيا
 45-كرواتيا
 46-السويد
 47-العراق
 48-هولندا
 49-لاتفيا
 50 النمسا
 51-بيلاروسيا
 52-تايلاند
 53-السعودية
 55-تايوان، مقاطعة الصين
 56-إسبانيا
 57-إيران (جمهورية -الإسلامية)
 58-الجزائر
 59-سلوفينيا
 61-السنغال
 62-تركيا
 63-تشيكيا
 64-سريلانكا
 65-بيرو
 67-نيوزيلاندا
 68-غينيا
 69-مالي
 70-فنزويلا (جمهورية -البوليفارية)
 71-إثيوبيا
 72-منغوليا
 73-البرازيل
 74-أفغانستان
 75-أوغندا
 76-أنغولا
 77-قبرص
 78-فرنسا
 79-بابوا غينيا الجديدة
 80-موزمبيق
 81-نيبال
 82-بلجيكا
 83-بلغاريا
 84-المجر
 85-مولدوفا، جمهورية
 86-إيطاليا
 87-باراغواي
 88-هندوراس
 89-تونس
 149-الصومال
 91-تيمور -ليشتي
 92-بوليفيا (دولة -المتعددة القوميات)
 93-كوستاريكا
 94-جواتيمالا
 95-الإمارات العربية المتحدة
 96-زيمبابوي
 97-بورتو ريكو
 98-السودان
 99-توغو
 18-الكونغو، جمهورية الكونغو الديمقراطية
 155 ألبانيا
 169-أنتيغوا وبربودا
 148-أرمينيا
 175-أستراليا
 122-جزر الباهاما
 145 البحرين
 118 -باربادوس
 ١٣٤ -بيليز
 ١٢٠ -بنين
 158-بوتان
 108-البوسنة والهرسك
 123-بوتسوانا
 152-بوركينا فاسو
 119-بوروندي
 186 كابو فيردي
 125-جمهورية أفريقيا الوسطى
 151-تشيلي
 133-جزر القمر
 113-كوبا
 109-جمهورية الدومينيكان
 105-الإكوادور
 101-السلفادور
 167-غينيا الاستوائية
 163-فنلندا
 162 غويانا الفرنسية
 154 الغابون
 128-جورجيا
 129-اليونان
 127-غرينادا
 160-جوادلوب
 130-غينيا -بيساو
 ١٣١ -غيانا
 132-آيسلندا
 103-جامايكا
 182-اليابان
 ١١٦ -الاردن
 100 الكويت
 153-لبنان
 136-ليسوتو
 135-ليبيريا
 165-لوكسمبورغ
 137-مالاوي
 159-المالديف
 114-موريتانيا
 157-موريشيوس
 138-ناميبيا
 185-كاليدونيا الجديدة
 139-النيجر
 174-النرويج
 107-عمان
 ١١٧ -البرتغال
 111-قطر
 140-رواندا
 141-سلوفاكيا
 142-سورينام
 173-سويسرا
 143-طاجيكستان
 104-ترينيداد وتوباغو
 161-تركمانستان
 156-أوروغواي
 102-ليبيا
 ١٨٣ -مقدونيا الشمالية
 134 سانت كيتس ونيفيس
 164-سانت لوسيا
 166 سانت فنسنت وجزر غرينادين
 110 الجمهورية العربية السورية
 9-تنزانيا، جمهورية تنزانيا المتحدة
 106-سوازيلاند
 بنما ١١٢
 ١١٥ -سيراليون
 146-لم الشمل
 177-جمهورية جنوب السودان"
      ] ); 
    } elseif ($data == "stop") {
		$bot->sendmessage ([
			"chat_id"=>$chat_id,
			"text"=>"تم ايقاف الصيد"
		]);
		$info["status"]=null;
		save();
	} elseif ($data) {
		if($data == "all"){
			$all = join ("\n",$info["countries"]) ?? "لاتوجد دول مضافة";
			$bot->answercallbackquery([
				"callback_query_id" => $update->callback_query->id,
				"text"=>"$all",
				"show_alert"=>true,
			]);
		} elseif ($data == "add") {
			$bot->editmessagetext([
				"chat_id"=>$chat_id,
				"text"=>"قم بارسال رمز الدولة في موقع البوت",
				"message_id"=>$message_id,
				"reply_markup"=>json_encode([
					"inline_keyboard"=>[
						[["text"=>"رجوع🔙","callback_data"=>"back"]],
					]
				])
			]);
			$info["admin"] = "add";
			save();
		} elseif ($data == "del") {
			$bot->editmessagetext([
				"chat_id"=>$chat_id,
				"text"=>"قم بارسال كود الدولة",
				"message_id"=>$message_id,
				"reply_markup"=>json_encode([
					"inline_keyboard"=>[
						[["text"=>"رجوع🔙","callback_data"=>"back"]],
					]
				])
			]);
			$info["admin"] = "del";
			save();
		}/* elseif ($ex[0] == "getCode" ) {
			$res = $api->getCode($ex[1]);
			if($res["ok"] == true ) {
				$code = $res["code"];
				$bot->editmessagetext([
					"chat_id"=>$chat_id,
					"text"=>"تم وصول الكود بنجاح\n$ex[2]\n$code",
					"message_id"=>$message_id
				]);
			} else {
				$bot->answercallbackquery([
					"callback_query_id" => $update->callback_query->id,
					"text"=>"🚫 لم يصل الكود",
					"show_alert"=>true,
				]);
			}
		} elseif ($ex[0] == "ban" ) {
			$res = $api->cencel($ex[1]);
			$bot->editmessagetext([
				"chat_id"=>$chat_id,
				"text"=>"تم حظر الرقم بنجاح",
				"message_id"=>$message_id
			]);
		}*/
		elseif ($data == "up") {
			if($api_key == null) {
				$bot->editmessagetext([
					"chat_id"=>$chat_id,
					"text"=>"قم بارسال api key الخاص بحسابك",
					"message_id"=>$message_id,
					"reply_markup"=>json_encode([
						"inline_keyboard"=>[
							[["text"=>"رجوع🔙","callback_data"=>"back"]],
						]
					])
				]);
				$info["admin"] = "up";
				save();
			}else{
				$bot->answercallbackquery([
					"callback_query_id" => $update->callback_query->id,
					"text"=>"لايمكنك اضافة api key جديد الا بعد حذف القديم",
					"show_alert"=>true,
				]);
			}
		}elseif ($data == "rem") {
			$bot->editmessagetext([
				"chat_id"=>$chat_id,
				"text"=>"تم الحذف بنجاح",
				"message_id"=>$message_id,
				"reply_markup"=>json_encode([
					"inline_keyboard"=>[
						[["text"=>"رجوع🔙","callback_data"=>"back"]],
					]
				])
			]);
			unset($info["key"]);
			save();
		}
	} elseif ($text && $info["admin"] == "add") {
		$code = uniqid (1);
		$info["countries"][$code] = $text;
		$info["admin"] = "";
		save();
		$bot->sendmessage ([
			"chat_id"=>$chat_id,
			"text"=>"تمت الاضافة بنجاح\nكود الدولة\n$code\nيستخدم هذا الكود عند الرغبة بحذف الدولة"
		]);
	} elseif ($text && $info["admin"] == "del") {
		if($info["countries"][$text] == null){
			$bot->sendmessage ([
				"chat_id"=>$chat_id,
				"text"=>"لاتوجد دولة مضافة بهذا الكود"
			]);
			$info["admin"] = "";
			save();
		} else {
			unset($info["countries"][$text]);
			$info["admin"] = "";
			save();
			$bot->sendmessage ([
				"chat_id"=>$chat_id,
				"text"=>"تم الحذف بنجاح"
			]);
		}
	}
	elseif ($text && $info["admin"] == "up") {
		$info["key"] = $text;
		$info["admin"] = "";
		save();
		$bot->sendmessage ([
			"chat_id"=>$chat_id,
			"text"=>"تم الحفظ بنجاح"
		]);
	}
} 


if ($ex[0] == "getCode" ) {
	$res = $api->getCode($ex[1]);
	if($res["ok"] == true  ) {
		$code = $res["code"];
		$bot->editmessagetext([
			"chat_id"=>$chat_id,
			"text"=>"تم وصول الكود بنجاح\n\n📞 الرقم:$ex[2]\n\nالكود:$code \n\nhttps://wa.me/+$ex[2]",
			"message_id"=>$message_id
		]);
	} else {
		$bot->answercallbackquery([
			"callback_query_id" => $update->callback_query->id,
			"text"=>"🚫 لم يصل الكود",
			"show_alert"=>true,
		]);
	}
} elseif ($ex[0] == "ban" ) {
	$res = $api->cencel($ex[1]);
	$bot->editmessagetext([
		"chat_id"=>$chat_id,
		"text"=>"تم حظر الرقم بنجاح",
		"message_id"=>$message_id
	]);
}






