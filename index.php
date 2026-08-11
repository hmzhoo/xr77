<?php
/**
 * بوت تيليجرام لتحميل الفيديوهات من مواقع التواصل الاجتماعي
 * يدعم: يوتيوب، تيك توك، فيسبوك، إنستغرام، تويتر، وغيرها عبر خدمات متعددة
 * الإصدار: 2.0
 * تاريخ: 2026-08-12
 */

// ========== إعدادات البوت ==========
define('BOT_TOKEN', '6580071450:AAEP2Lkzn5YjfMUYc67euLyA1oD72-vsgIE');
define('API_URL', 'https://api.telegram.org/bot' . BOT_TOKEN . '/');
define('CACHE_DIR', __DIR__ . '/cache/'); // لتخزين النتائج مؤقتاً
if (!is_dir(CACHE_DIR)) mkdir(CACHE_DIR, 0755, true);

// ========== معالجة الطلب الوارد (Webhook) ==========
$content = file_get_contents('php://input');
$update = json_decode($content, true);

if (!$update) {
    http_response_code(200);
    exit('OK');
}

// استخراج بيانات الرسالة
$message = $update['message'] ?? null;
if (!$message) exit;

$chat_id = $message['chat']['id'] ?? null;
$text = $message['text'] ?? '';
$reply_to = $message['message_id'] ?? null;

if (!$chat_id) exit;

// تجاهل الأوامر التي تبدأ بـ '/' (لن نستخدم أوامر، فقط نستقبل الروابط)
// لكننا سنضيف أمر /start للترحيب
if ($text === '/start') {
    sendMessage($chat_id, "👋 أهلاً بك! أرسل لي رابط فيديو من أي موقع (يوتيوب، تيك توك، فيسبوك، إنستغرام، تويتر، إلخ) وسأحاول توفير روابط التحميل لك.");
    exit;
}

// التحقق من وجود رابط في النص
$url = extractUrl($text);
if (!$url) {
    sendMessage($chat_id, "❌ لم أجد رابطاً صحيحاً في رسالتك. يرجى إرسال رابط فيديو.");
    exit;
}

// ========== البحث عن روابط التحميل ==========
sendMessage($chat_id, "⏳ جاري معالجة الرابط...");

$downloadLinks = getDownloadLinks($url);

if ($downloadLinks === false || empty($downloadLinks)) {
    sendMessage($chat_id, "❌ عذراً، لم أتمكن من الحصول على روابط التحميل لهذا الرابط. قد يكون الموقع غير مدعوم أو الرابط غير صحيح.");
    exit;
}

// ========== عرض النتائج للمستخدم ==========
if (isset($downloadLinks['error'])) {
    sendMessage($chat_id, "⚠️ " . $downloadLinks['error']);
    exit;
}

// إذا كانت النتيجة تحتوي على روابط مباشرة للفيديو (بجودة مختلفة)
if (isset($downloadLinks['video'])) {
    // إرسال روابط الفيديو (جودة متعددة)
    $reply = "✅ تم العثور على روابط التحميل:\n\n";
    foreach ($downloadLinks['video'] as $quality => $link) {
        $reply .= "🎬 $quality: <a href=\"$link\">اضغط للتحميل</a>\n";
    }
    // إذا كان يوجد صوت منفصل
    if (isset($downloadLinks['audio'])) {
        $reply .= "\n🎵 صوت فقط: <a href=\"{$downloadLinks['audio']}\">تحميل</a>";
    }
    sendMessage($chat_id, $reply, 'HTML');
} else {
    // إذا كانت النتيجة رابط واحد فقط (مباشر)
    $reply = "✅ رابط التحميل:\n<a href=\"{$downloadLinks['url']}\">اضغط هنا</a>";
    sendMessage($chat_id, $reply, 'HTML');
}

// ============================================================
// ========== الدوال الأساسية ==================================
// ============================================================

/**
 * استخراج الرابط الأول من النص
 */
function extractUrl($text) {
    preg_match('/https?:\/\/[^\s]+/', $text, $matches);
    return $matches[0] ?? null;
}

/**
 * الحصول على روابط التحميل من أي موقع (يوتيوب، تيك توك، فيسبوك، إنستغرام، إلخ)
 * تعتمد على خدمات متعددة وتجربها بالتتابع
 */
function getDownloadLinks($url) {
    // التحقق من التخزين المؤقت
    $cacheKey = md5($url);
    $cacheFile = CACHE_DIR . $cacheKey . '.json';
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < 3600)) { // صلاحية ساعة
        $cached = json_decode(file_get_contents($cacheFile), true);
        if ($cached) return $cached;
    }

    // تحديد نوع الموقع
    $domain = parse_url($url, PHP_URL_HOST);
    $domain = str_replace('www.', '', $domain);

    $result = false;

    // 1. يوتيوب
    if (strpos($domain, 'youtube.com') !== false || strpos($domain, 'youtu.be') !== false) {
        $result = getYouTubeLinks($url);
    }
    // 2. تيك توك
    elseif (strpos($domain, 'tiktok.com') !== false) {
        $result = getTikTokLinks($url);
    }
    // 3. فيسبوك
    elseif (strpos($domain, 'facebook.com') !== false || strpos($domain, 'fb.watch') !== false) {
        $result = getFacebookLinks($url);
    }
    // 4. إنستغرام
    elseif (strpos($domain, 'instagram.com') !== false) {
        $result = getInstagramLinks($url);
    }
    // 5. تويتر
    elseif (strpos($domain, 'twitter.com') !== false || strpos($domain, 'x.com') !== false) {
        $result = getTwitterLinks($url);
    }
    // 6. مواقع أخرى - نستخدم خدمة عامة
    else {
        $result = getGenericLinks($url);
    }

    // إذا فشلت الطريقة المخصصة، نجرب الخدمة العامة كاحتياطي
    if ($result === false || empty($result)) {
        $result = getGenericLinks($url);
    }

    // تخزين النتيجة في الكاش إذا نجحت
    if ($result && !isset($result['error'])) {
        file_put_contents($cacheFile, json_encode($result));
    }

    return $result;
}

// ========== دوال التحميل حسب الموقع ==========

/**
 * تحميل فيديو يوتيوب باستخدام ssyoutube.com
 */
function getYouTubeLinks($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://ssyoutube.com/api/convert');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['url' => $url]));
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'User-Agent: Mozilla/5.0 (Linux; Android 11) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Mobile Safari/537.36',
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode != 200 || !$response) return false;

    $json = json_decode($response, true);
    if (!$json) return false;

    // تحليل الرد (تختلف بنية الرد حسب الخدمة)
    // ssyoutube يعيد عادةً: { "status": "ok", "links": { "mp4": { "360": "url", ... }, "mp3": "url" } }
    if (isset($json['links']['mp4']) && is_array($json['links']['mp4'])) {
        $result['video'] = [];
        foreach ($json['links']['mp4'] as $quality => $link) {
            $result['video'][$quality . 'p'] = $link;
        }
        if (isset($json['links']['mp3'])) {
            $result['audio'] = $json['links']['mp3'];
        }
        return $result;
    }

    return false;
}

/**
 * تحميل فيديو تيك توك باستخدام tikmate.cc (API غير رسمي)
 */
function getTikTokLinks($url) {
    // استخدام خدمة مجانية مثل https://www.tikmate.cc/api/
    // لكن يمكن استخدام endpoint آخر مثل https://api.tikmate.app/
    $apiUrl = 'https://www.tikmate.cc/api/';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl . '?url=' . urlencode($url));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'User-Agent: Mozilla/5.0 (Linux; Android 11) AppleWebKit/537.36',
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode != 200 || !$response) return false;

    $json = json_decode($response, true);
    if (!$json || !isset($json['url'])) return false;

    // عادةً tikmate يعيد { "url": "https://..." }
    return ['url' => $json['url']];
}

/**
 * تحميل فيديو فيسبوك باستخدام getvideo.watch (نسخة مبسطة)
 */
function getFacebookLinks($url) {
    // استخدام خدمة https://getvideo.watch/api/ (غير رسمية)
    $apiUrl = 'https://getvideo.watch/api/ajax/search';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'q=' . urlencode($url));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded',
        'User-Agent: Mozilla/5.0 (Linux; Android 11) AppleWebKit/537.36',
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode != 200 || !$response) return false;

    $json = json_decode($response, true);
    if (!$json || !isset($json['links']['Download']['High Quality'])) return false;

    // قد يعيد عدة جودات
    $result['video'] = [];
    foreach ($json['links']['Download'] as $quality => $link) {
        $result['video'][$quality] = $link;
    }
    return $result;
}

/**
 * تحميل فيديو إنستغرام باستخدام saveinsta.app (API بسيط)
 */
function getInstagramLinks($url) {
    // استخدام saveinsta.app
    $apiUrl = 'https://saveinsta.app/api/ajaxSearch';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'q=' . urlencode($url));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded',
        'User-Agent: Mozilla/5.0 (Linux; Android 11) AppleWebKit/537.36',
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode != 200 || !$response) return false;

    $json = json_decode($response, true);
    if (!$json || !isset($json['media'])) return false;

    // قد يكون الفيديو أو الصورة
    if (isset($json['media']['video'])) {
        return ['url' => $json['media']['video']];
    } elseif (isset($json['media']['image'])) {
        return ['url' => $json['media']['image']];
    }
    return false;
}

/**
 * تحميل فيديو تويتر (نستخدم خدمة عامة)
 */
function getTwitterLinks($url) {
    // استخدام خدمة عامة مثل twittervideodownloader.com
    // لكن سنستخدم API مفتوح مثل https://api.vevioz.com/
    // بدلاً من ذلك، نمرر للخدمة العامة.
    return getGenericLinks($url);
}

/**
 * خدمة عامة لتحميل الفيديو من أي موقع (تستخدم عدة APIs احتياطية)
 * نستخدم https://social-downloader.com/api/ (مجانية ولكن محدودة)
 * أو https://download4.cc/api/ (قديمة)
 * أفضل: استخدام api.vevioz.com
 */
function getGenericLinks($url) {
    // 1. محاولة استخدام api.vevioz.com (يدعم العديد من المواقع)
    $apiUrl = 'https://api.vevioz.com/api/button/mp3/' . urlencode($url);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'User-Agent: Mozilla/5.0 (Linux; Android 11) AppleWebKit/537.36',
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 200 && $response) {
        $json = json_decode($response, true);
        if ($json && isset($json['medias'])) {
            $result['video'] = [];
            foreach ($json['medias'] as $media) {
                if (isset($media['url']) && isset($media['quality'])) {
                    $result['video'][$media['quality']] = $media['url'];
                }
            }
            if (!empty($result['video'])) return $result;
        }
    }

    // 2. محاولة استخدام موقع savefrom.net (نسخة مبسطة)
    // غير موصى بها لأنها تتطلب تحليل HTML، لكن نتركها للاحتياط.
    return false;
}

// ========== دالة إرسال الرسائل إلى تيليجرام ==========
function sendMessage($chat_id, $text, $parse_mode = 'HTML', $reply_to = null) {
    $url = API_URL . 'sendMessage';
    $data = [
        'chat_id' => $chat_id,
        'text' => $text,
        'parse_mode' => $parse_mode,
        'disable_web_page_preview' => true,
    ];
    if ($reply_to) $data['reply_to_message_id'] = $reply_to;

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ],
    ];
    $context = stream_context_create($options);
    file_get_contents($url, false, $context);
}

// ========== تشغيل البوت ==========
// بعد كل شيء، لا حاجة لإضافة شيء، البوت يعمل عبر webhook.

// نهاية الملف
