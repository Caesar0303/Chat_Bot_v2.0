<?php 
$message = $_GET['message'];

if (strpos($message, '?') !== false) {
    // Поиск ответа на вопрос в Википедии
    $message = str_replace('Who is', '', $message);
    $message = str_replace('What is', '', $message);
    $query = urlencode(substr($message, 0, -1));
    $url = "https://en.wikipedia.org/w/api.php?action=query&format=json&prop=extracts&exsentences=2&exintro=1&explaintext=1&redirects=1&titles={$query}";
    $data = @file_get_contents($url);
    $json = json_decode($data, true);
    
    // Обработка ответа
    $pages = $json['query']['pages'];
    $page = reset($pages);
    if (isset($page['extract'])) {
        echo $page['extract'];
    } else {
        echo 'Извините, я не знаю ответ на ваш вопрос.';
    }
}


$answers = [
  'Привет!',
  'Отлично, у вас как?',
  'Я могу выводит данные о погоде с различных городов, в будущем я смогу конвертировать валюту, показывать вам время с различных городов, отвечать на многие вопросы с помощью википедий а также смогу сыграть с вами в игры'
];

$client = [
  'Привет',
  'Как дела?',
  'Что ты умеешь?'
];

$length = count($answers);
for ($i = 0; $i < $length; $i++) {
  if(mb_strtoupper($message) == mb_strtoupper($client[$i])) {
    echo $answers[$i];
  }
}

// Начинаем сессию
session_start();
// Если пользователь только что ввел "weather", то сохраняем этот факт в сессии
if ($message == 'Weather') {

  $_SESSION['weather'] = true;
  echo 'Enter the city where you want to know the weather';
} else {
  // Если пользователь уже вводил "weather" и сейчас вводит город, то проверяем, сохранен ли флаг в сессии
  if (isset($_SESSION['weather']) && $_SESSION['weather']) {
    $city = $message;
    $weather_data = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q={$city}&appid=f19c51d8fa6cec26756d4151709ba8bf&units=metric");
    $weather_data = json_decode($weather_data, true);
    if (isset($weather_data['weather'][0]['description']) && isset($weather_data['main']['temp'])) {
      $temperature = $weather_data['main']['temp'];
      $description = $weather_data['weather'][0]['description'];
      $response = "City weather {$city} ${temperature} Celsius and ${description}";
    } else {
      $response = "Sorry, I couldn't find the weather for {$city}.";
    }
  
    echo $response;

    // Обнуляем флаг в сессии
    $_SESSION['weather'] = false;
  } 
}

if ($message == "Time") {
  $_SESSION['time'] = true;
  echo "Enter the city where you want to know the time in the format Continent/City\n";
  echo 'In Kazakhstan, such cities are supported as: Almaty, Aktau, Aktobe, Atyrau, Oral, Kostanay and Kyzylorda';
} else {
  if (isset($_SESSION['time']) && $_SESSION['time']) {
    $message = str_replace(" ","_",$message);
    $message = str_replace(",_","/",$message);
    var_dump($message);
    $zone_city = $message;
    $time_data = file_get_contents("http://api.timezonedb.com/v2.1/get-time-zone?key=TZ3B4QKEDDYZ&format=json&by=zone&zone={$zone_city}");
    $time_data = json_decode($time_data, true);
    $country_code = $time_data['countryCode'];
    $country_name = $time_data['countryName'];
    $zone_name = $time_data['zoneName'];
    $local_time = date('Y-m-d H:i:s', $time_data['timestamp']);
    if ($country_code == "") {
      echo 'There is no such city in the database or you entered the data incorrectly.';
    } else {
    echo 'Country code: ' . $country_code . "\n";
    echo 'Country name: ' . $country_name . "\n";
    echo 'Timezone: ' . $zone_name . "\n";
    echo 'Local time: ' . $local_time;
    }

    $_SESSION['time'] = false;
  }
}
?>
