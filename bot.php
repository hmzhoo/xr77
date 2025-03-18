<?php 
ob_start(); 
$token = "2075951782:AAHmZap1EVnVu2-n5ss3xsW0S4Hug8wAPnM"; # Token
$userbot="numberswatawbot";

define("API_KEY", $token);
echo "setWebhook ~> <a href=\"https://api.telegram.org/bot".API_KEY."/setwebhook?url=".$_SERVER['SERVER_NAME']."".$_SERVER['SCRIPT_NAME']."\">https://api.telegram.org/bot".API_KEY."/setwebhook?url=".$_SERVER['SERVER_NAME']."".$_SERVER['SCRIPT_NAME']."</a>";
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
}}

# Short
$update = json_decode(file_get_contents("php://input"));
file_put_contents("update.txt",json_encode($update));
$message = $update->message;
$txt = $message->caption;
$text = $message->text;
$chat_id = $message->chat->id;
$from_id = $message->from->id;
$new = $message->new_chat_members;
$message_id = $message->message_id;
$type = $message->chat->type;
$name = $message->from->first_name;
if(isset($update->callback_query)){

$up = $update->callback_query;
$chat_id = $up->message->chat->id;
$from_id = $up->from->id;
$user = $up->from->username;
$name = $up->from->first_name;
$message_id = $up->message->message_id;
$data = $up->data;
}
$id = $update->inline_query->from->id; 
if(isset($update->inline_query)){
$chat_id = $update->inline_query->chat->id;
$from_id = $update->inline_query->from->id;
$name = $update->inline_query->from->first_name.' '.$update->inline_query->from->last_name;
$text_inline = $update->inline_query->query;
$mes_id = $update->inline_query->inline_message_id; 
$user = strtolower($update->inline_query->from->username); 
}
$sudo = array("5834457456","5834457456","5834457456");
$abdo1 = 1504476657; 
$gp = 1504476657; 

mkdir("sudo");
mkdir("data");


$get_ban=file_get_contents('sudo/ban.txt');
$ban =explode("\n",$get_ban);
/////////////////////

$member = explode("\n",file_get_contents("sudo/member.txt"));
$cunte = count($member)-1;
$ban = explode("\n",file_get_contents("sudo/ban.txt"));
$countban = count($ban);
//////////



 //ايديك
$reply = $message->reply_to_message->message_id;
$rep = $message->reply_to_message->forward_from; 





@$infosudo = json_decode(file_get_contents("sudo.json"),true);
if (!file_exists("sudo.json")) {
#	$put = [];
	$infosudo["info"]["admins"][]="$admin";
$infosudo["info"]["fwrmember"]="معطل";
$infosudo["info"]["tnbih"]="مفعل";
$infosudo["info"]["silk"]="مفعل";
$infosudo["info"]["allch"]="مفردة";
$infosudo["info"]["start"]="non";
$infosudo["info"]["klish_sil"]="كليشة الاشتراك الاجباري";


file_put_contents("sudo.json", json_encode($infosudo));
}
$fwrmember=$infosudo["info"]["fwrmember"];
$tnbih=$infosudo["info"]["tnbih"];
$silk=$infosudo["info"]["silk"];
$allch=$infosudo["info"]["allch"];
$start=$infosudo["info"]["start"];
$kl_3roth= $infosudo["info"]["kl_3roth"];


$kl_infobot=$infosudo["info"]["kl_infobot"];
$kl_alwklaa=$infosudo["info"]["kl_alwklaa"];
$kl_help=$infosudo["info"]["kl_help"];

$coinssudo=$infosudo["info"]["الرصيد"];
$adna=$coinssudo["الادنى"];if($adna==null){$adna=30;}

$a3la=$coinssudo["الاعلى"];
if($a3la==null){$a3la=3000;}
$thriph=$coinssudo["ضريبة"];
if($thriph==null){$thriph=0;}

if($start=="non"){
$start="لم يتم تعيين كليشة ستارت من قبل المطور ";
}
if($kl_3roth==null ){
$kl_3roth="لم يتم تعيين كليشة العروض من قبل المطور ";
}
if($kl_alwklaa==null ){
$kl_alwklaa="لم يتم تعيين كليشة الوكلاء من قبل المطور ";
}
if($kl_infobot==null){
$kl_infobot="لم يتم تعيين كليشة شرح البوت من قبل المطور ";
}
if($kl_help==null){
$kl_help="لم يتم تعيين كليشة المساعدة من قبل المطور ";
}

$api_key="f3AeA0AA44cb243c88bfA50A46bd9b26";
@$al3roth = json_decode(file_get_contents("databot/al3roth.json"),true);


require_once("function.php"); 

$fromjson = json_decode(file_get_contents("data/$from_id.json"),true);
$amrmem= $fromjson["info"]["amr"];
if($text=="/start"){
$coins=coins($from_id,"null",$c);
bot('sendmessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
"text"=>"مرحبا  [$name]

$start

💰 رصيدك : $coins ₽
",
'parse_mode'=>"MarkDown",
'disable_web_page_preview'=>true,
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>'🔰- الارقام الجاهزه. ' ,'callback_data'=>"جاهزة"],['text'=>'🔥- قسم العروض. ' ,'callback_data'=>"العروض"]],

[['text'=>'💵- شراء رقم. ' ,'callback_data'=>"الارقام"]],

[['text'=>"📤 - شحن رصيد بكرت.",'callback_data'=>"تعبئة"],['text'=>"💳 - انتاج كرت شحن.",'callback_data'=>"انتاج"]],

[['text'=>"🗂 - معلومات حسابي. ",'callback_data'=>"معلوماتي"],['text'=>"♻ - تحويل الرصيد. ",'callback_data'=>"تحويل"]],

[['text'=>"🗃 - صندوق مشترياتي. ",'callback_data'=>"مشترياتي"]],
[['text'=>"🔎 - بحث سريع عن دولة محددة.  ",'callback_data'=>"بحث"]],
[['text'=>"📑 - شرح الاستخدام. ",'callback_data'=>"شرح"],['text'=>"📡 - قناة البوت. ",'url'=>"t.me/mshro7"]],

[['text'=>"📮 - المساعدة. ",'callback_data'=>"مساعدة"]]
,
]])

]);
}

if($data == "home"){
$fromjson["info"]["amr"]="null";
file_put_contents("data/$from_id.json", json_encode($fromjson));
$coins=coins($from_id,"null",$c);
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
"text"=>"مرحبا  [$name]

$start

💰 رصيدك : $coins ₽
",
'parse_mode'=>"MarkDown",
'disable_web_page_preview'=>true,
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>'🔰- الارقام الجاهزه. ' ,'callback_data'=>"جاهزة"],['text'=>'🔥- قسم العروض. ' ,'callback_data'=>"العروض"]],

[['text'=>'💵- شراء رقم. ' ,'callback_data'=>"الارقام"]],

[['text'=>"📤 - شحن رصيد بكرت.",'callback_data'=>"تعبئة"],['text'=>"💳 - انتاج كرت شحن.",'callback_data'=>"انتاج"]],

[['text'=>"🗂 - معلومات حسابي. ",'callback_data'=>"معلوماتي"],['text'=>"♻ - تحويل الرصيد. ",'callback_data'=>"تحويل"]],

[['text'=>"🗃 - صندوق مشترياتي. ",'callback_data'=>"مشترياتي"]],
[['text'=>"🔎 - بحث سريع عن دولة محددة.  ",'callback_data'=>"بحث"]],

[['text'=>"📑 - شرح الاستخدام. ",'callback_data'=>"شرح"],['text'=>"📡 - قناة البوت. ",'url'=>"t.me/mshro7"]],

[['text'=>"📮 - المساعدة. ",'callback_data'=>"مساعدة"]]
,
]])

]);
}
#الوكلاء
if($data == "وكلاء"){
$fromjson["info"]["amr"]="null";
file_put_contents("data/$from_id.json", json_encode($fromjson));
$coins=coins($from_id,"null",$c);
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
"text"=>"مرحبا  [$name]

$kl_alwklaa
",
'parse_mode'=>"MarkDown",
'disable_web_page_preview'=>true,
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>'↩ - عودة.' ,'callback_data'=>"home"]],

]])
]);
}
if($data == "شرح"){
$fromjson["info"]["amr"]="null";
file_put_contents("data/$from_id.json", json_encode($fromjson));
$coins=coins($from_id,"null",$c);
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
"text"=>"مرحبا  [$name]

$kl_infobot
",
'parse_mode'=>"MarkDown",
'disable_web_page_preview'=>true,
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>'↩ - عودة.' ,'callback_data'=>"home"]],

]])
]);
}
if($data == "مساعدة"){
$fromjson["info"]["amr"]="null";
file_put_contents("data/$from_id.json", json_encode($fromjson));
$coins=coins($from_id,"null",$c);
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
"text"=>"مرحبا  [$name]

$kl_help
",
'parse_mode'=>"MarkDown",
'disable_web_page_preview'=>true,
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>'↩ - عودة.' ,'callback_data'=>"home"]],

]])
]);
}
if($data == "معلوماتي"){
$fromjson = json_decode(file_get_contents("data/$from_id.json"),true);
$coins=$fromjson["info"]["coins"];
$coinsst=$fromjson["info"]["الرصيد المستهلك"];
$arraymem=$fromjson["info"]["العملاء"];
$mycountmem=count($arraymem);
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
"text"=>"
🙋🏻 - مرحباً بك يـ $name.
📂 - هذا الأرشيف الخاص بحسابك.

✏️ - الإسم | $name.
🔖 - المُعرِف | $user.
🆔 - الآيدي | $from_id .
🏦 - الرصيد| $coins روبل.

📈 - عدد عملائك | $mycountmem عضواً.
📮 - كمية رصيدك المستخدم في البوت | $coinsst روبل.
 
",
'disable_web_page_preview'=>true,
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>'↩ - عودة.' ,'callback_data'=>"home"]],

]])
]);
}

if($data == "مشترياتي"){
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
"text"=>"
🙋🏻 - مرحباً بك يـ $name.
📦 - هذا صندوق المشتريات الخاصه بك.

",
'disable_web_page_preview'=>true,
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>'📋 - الأرقام اللتي تم شراؤها.' ,'callback_data'=>"ارقامي"],
['text'=>'💳 - الكروت اللتي تم شراؤها. ' ,'callback_data'=>"كروتي"]
],
[['text'=>'↩ - عودة.' ,'callback_data'=>"home"]],

]])
]);
}
if($data == "ارقامي"){
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
"text"=>"
🙋🏻 - مرحباً بك يـ $name.
📂 - هذا أرشيف الأرقام اللتي قمت بشرائها.

",
'disable_web_page_preview'=>true,
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>'✅ - الشراء الناجح.' ,'callback_data'=>"mynumbers 0"],
['text'=>'❌ - الشراء الفاشل.' ,'callback_data'=>"ارقامي2"]
],
[['text'=>'↩ - عودة.' ,'callback_data'=>"مشترياتي"]],

]])
]);
}
$datanumber = json_decode(file_get_contents("datanumber/$from_id.txt"),true);
mkdir("datanumber");


$datanumber["info"]["number"][]=$text;

if(preg_match('/^(mynumbers) (.*)/s', $data)){

$loop = str_replace('mynumbers ',"",$data);

$array=$datanumber["info"]["number"];
if(isset($datanumber["info"]["number"])){
for($i=$loop;$i<count($array);$i++){
$info=$array[$i];

if($info!=null ){
$l=$l+1;
$ex=explode('|',$info);
$number = $ex[0];
$codenum = $ex[1];
$coinnum = $ex[2];
$no3 = $ex[3];
$time = $ex[4];


$dayon = date('Y/m/d',$time);
$timeon =date('H:i:s A',$time);
$date = "🕰 -$dayon | $timeon ";
$txt="$txt\n$l | `$number` | `$codenum` | ₽$coinnum | $no3
$date
••••";
}
if($i==30){
break;
}
}


bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
"text"=>"
🙋🏻 - مرحباً بك يـ [$name].

$txt
…………………………

",
'parse_mode'=>"MarkDown",
'disable_web_page_preview'=>true,
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>'⬅ - السابق.' ,'callback_data'=>"mynumbers 0"],
['text'=>'السابق. - ➡' ,'callback_data'=>"mynumbers $i"]],

[['text'=>'↩ - عودة.' ,'callback_data'=>"مشترياتي"]],

]])
]);

}else{
bot('answercallbackquery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"❌ لم تقم بشراء الارقام مسبقاً 
",
'show_alert'=>true
]);


}
}






$cardsjson = json_decode(file_get_contents("databot/cards.txt"),true);


if($data == "كروتي"){
$arraydate=$fromjson["info"]["cards"];
if(isset($fromjson["info"]["cards"])){
foreach($arraydate as $time => $code){
if($time!=null ){
$l++;

$coincard=$cardsjson["cards"]["$code"]["coin"];
if($cardsjson["cards"]["$code"]["st"]=="yes"){
$st="🎫";
}else{
$st="🎟";
}
$dayon = date('Y/m/d',$time);
$timeon =date('H:i:s A',$time);
$date = "🕰 -$dayon | $timeon ";
$txt="$txt\n$l | `$code` ₽$coincard $st
$date
••••";
}
}
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
"text"=>"
🙋🏻 - مرحباً بك يـ [$name].
💳 - هذا قسم الكروت اللتي تم شراؤها.

$txt
…………………………
🎫 - غير مستخدم.
🎟 - مستخدم.
",
'parse_mode'=>"MarkDown",
'disable_web_page_preview'=>true,
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>'↩ - عودة.' ,'callback_data'=>"مشترياتي"]],

]])
]);

}else{
bot('answercallbackquery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"❌ لم تقم بشراء كروت مسبقاً 
",
'show_alert'=>true
]);


}
}
if($data == "بحث"){
$fromjson["info"]["amr"]="بحث";
file_put_contents("data/$from_id.json", json_encode($fromjson));
$coins=coins($from_id,"null",$c);
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
"text"=>"مرحبا  [$name]
قم بإرسال اسم الدولة للبحث عنها 
",
'parse_mode'=>"MarkDown",
'disable_web_page_preview'=>true,
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>'↩ - الغاء.' ,'callback_data'=>"home"]],

]])
]);
}





$timeuoto=time()+(3600 * 3);


require_once("countryofapps.php"); 
require_once("openapps.php"); 
require_once("buynumbers.php"); 

require_once("numberset.php"); 
require_once("coins.php"); 
##

require_once("setingsudo.php"); 
require_once("addapps.php");

@$countryjson = json_decode(file_get_contents("databot/country.txt"),true);
if(preg_match('/^(adddddddddddddd) (.*)/s', $text) and in_array($from_id,$sudo)){
$txt = str_replace('add ',"",$text);


$ex=explode("\n",$txt);
foreach($ex as $c => $in){
if($in!=null and $in!=""){
$ex1=explode("=",$in);
$country=trim($ex1[0]);
$namecou=trim($ex1[1]);

if(in_array($country,$city)){

$countryjson["info"]["$country"]="$namecou";
}
}
}
file_put_contents("databot/country.txt", json_encode($countryjson));

bot('sendmessage',[
'chat_id'=>$chat_id, 
'text'=>"
تمت البنجاح..
للعرض 
/view
 ",
'disable_web_page_preview'=>true,
"reply_to_message_id"=>$message_id,
]);
} 
 ###wataw### 
if($text == "/viewwwwwwwwww" and in_array($from_id,$sudo)){

$ar_country=$countryjson["info"];


foreach($ar_country as $country => $name_country){
if($country!=null and $country!=""){
$txx="$txx\n-$name_country | $country";
}
}

bot('sendmessage',[
'chat_id'=>$chat_id, 
'text'=>"Get country
~~~~~~~~~
$txx
",
'parse_mode'=>markdown,
'disable_web_page_preview'=>true,
"reply_to_message_id"=>$message_id,
]);
} 
 ###wataw### 
@$countryjson = json_decode(file_get_contents("databot/country.txt"),true);
if(preg_match('/^(adddddddddddddd) (.*)/s', $text) and in_array($from_id,$sudo)){
$txt = str_replace('add ',"",$text);


$ex=explode("\n",$txt);
foreach($ex as $c => $in){
if($in!=null and $in!=""){
$ex1=explode("=",$in);
$country=trim(strtolower($ex1[0]));
$namecou=trim($ex1[1]);

if(in_array($country,$city)){

$countryjson["info"]["$country"]="$namecou";
}
}
}
file_put_contents("databot/country.txt", json_encode($countryjson));

bot('sendmessage',[
'chat_id'=>$chat_id, 
'text'=>"
تمت البنجاح..
للعرض 
/view
 ",
'disable_web_page_preview'=>true,
"reply_to_message_id"=>$message_id,
]);
} 
 ###wataw### 
if($text == "/viewwwwwwwwww" and in_array($from_id,$sudo)){

$ar_country=$countryjson["info"];


foreach($ar_country as $country => $name_country){
if($country!=null and $country!=""){
$txx="$txx\n-$name_country | $country";
}
}
bot('sendmessage',[
'chat_id'=>$chat_id, 
'text'=>"Get country
~~~~~~~~~
$txx
",
'parse_mode'=>markdown,
'disable_web_page_preview'=>true,
"reply_to_message_id"=>$message_id,
]);
} 
 ###wataw### 
@$countryjson = json_decode(file_get_contents("databot/country.txt"),true);
if(preg_match('/^(adddddddddddddd) (.*)/s', $text) and in_array($from_id,$sudo)){
$txt = str_replace('add ',"",$text);


$ex=explode("\n",$txt);
foreach($ex as $c => $in){
if($in!=null and $in!=""){
$ex1=explode("=",$in);
$country=trim(strtolower($ex1[0]));
$namecou=trim($ex1[1]);

if(in_array($country,$city)){

$countryjson["info"]["$country"]="$namecou";
}
}
}
file_put_contents("databot/country.txt", json_encode($countryjson));

bot('sendmessage',[
'chat_id'=>$chat_id, 
'text'=>"
تمت البنجاح..
للعرض 
/view
 ",
'disable_web_page_preview'=>true,
"reply_to_message_id"=>$message_id,
]);
} 
 ###wataw### 
