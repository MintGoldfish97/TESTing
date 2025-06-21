
<?php
// Get client IP
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    return $_SERVER['REMOTE_ADDR'];
}

$ip = getUserIP();

// Fetch geolocation data using ip-api
$apiURL = "http://ip-api.com/json/{$ip}";
$response = file_get_contents($apiURL);
$data = json_decode($response, true);

// Prepare log data
$logData = [
    'ip' => $ip,
    'country' => $data['country'] ?? 'Unknown',
    'region' => $data['regionName'] ?? 'Unknown',
    'city' => $data['city'] ?? 'Unknown',
    'isp' => $data['isp'] ?? 'Unknown',
    'timezone' => $data['timezone'] ?? 'Unknown',
    'lat' => $data['lat'] ?? '',
    'lon' => $data['lon'] ?? '',
    'time' => date("Y-m-d H:i:s")
];

// Convert to log line
$logLine = json_encode($logData) . PHP_EOL;

// Save to log file
file_put_contents("visitors.log", $logLine, FILE_APPEND);

// Optional: redirect to another page after logging
// header("Location: https://example.com"); 
// exit();

// Show confirmation or blank page
echo "Logged.";
?>
