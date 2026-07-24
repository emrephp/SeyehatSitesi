<?php
// CORS ve Content-Type ayarları
header('Content-Type: application/json; charset=utf-8');

// Sadece POST isteklerini kabul et
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Sadece POST istekleri kabul edilir.']);
    exit;
}

// Honeypot bot koruması
if (!empty($_POST['_gotcha'])) {
    http_response_code(200);
    echo json_encode(['success' => true, 'message' => 'OK']);
    exit;
}

// Form verilerini al ve temizle
$ad     = trim(htmlspecialchars($_POST['Ad'] ?? ''));
$soyad  = trim(htmlspecialchars($_POST['Soyad'] ?? ''));
$eposta = trim(filter_var($_POST['Eposta'] ?? '', FILTER_SANITIZE_EMAIL));
$numara = trim(htmlspecialchars($_POST['Numara'] ?? ''));
$mesaj  = trim(htmlspecialchars($_POST['Mesaj'] ?? ''));

// Zorunlu alan kontrolü
if ($ad === '' || $soyad === '' || $eposta === '' || $numara === '' || $mesaj === '') {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Tüm alanları doldurunuz.']);
    exit;
}

// E-posta format kontrolü
if (!filter_var($eposta, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Geçerli bir e-posta adresi giriniz.']);
    exit;
}

// ── Mesajı kaydet (dosyaya) ──
// İleride veritabanına geçilecek, şimdilik JSON dosyasına yazıyoruz
$dataDir = __DIR__ . '/data';
if (!is_dir($dataDir)) {
    mkdir($dataDir, 0755, true);
}

$entry = [
    'id'        => uniqid('msg_', true),
    'ad'        => $ad,
    'soyad'     => $soyad,
    'eposta'    => $eposta,
    'numara'    => $numara,
    'mesaj'     => $mesaj,
    'tarih'     => date('Y-m-d H:i:s'),
    'ip'        => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
];

$filePath = $dataDir . '/messages.json';

// Mevcut mesajları oku
$messages = [];
if (file_exists($filePath)) {
    $content = file_get_contents($filePath);
    $messages = json_decode($content, true) ?: [];
}

// Yeni mesajı ekle
$messages[] = $entry;

// Dosyaya yaz
$written = file_put_contents($filePath, json_encode($messages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

if ($written === false) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Mesaj kaydedilemedi. Lütfen daha sonra tekrar deneyin.']);
    exit;
}

// ── Formspree'ye de gönder ──
$formspreeUrl = 'https://formspree.io/f/xpqvyanp';
$formData = [
    'Ad'     => $ad,
    'Soyad'  => $soyad,
    'Eposta' => $eposta,
    'Numara' => $numara,
    'Mesaj'  => $mesaj,
];

$ch = curl_init($formspreeUrl);
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => json_encode($formData),
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'Accept: application/json',
    ],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 10,
]);
curl_exec($ch);
curl_close($ch);

// Başarılı yanıt
http_response_code(200);
echo json_encode(['success' => true, 'message' => 'Mesajınız başarıyla gönderildi!']);
