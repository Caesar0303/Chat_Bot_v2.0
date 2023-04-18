<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="reset.css">
    <title>Document</title>
</head>
<style> 
    .bot-message-special {
        background: #66ff00;
    }
    .hide {
        display: none;
    }
</style>
<body>
    <form action="chatbot.php" method="get"  id="chat-form">
        <input type="text" name="message" class="inpt">
        <button type="submit">Send</button>
    </form>
    <div id="chat-area">
    </div>
    <div class="wrapper hide">
        <p id="raiting">Score:<span id="score">0</span></p>
        <div id="world" style="width:400px; height:400px;"></div>
        <p id="raiting">Your record:<span id="record">0</span></p>
    </div>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="script.js"></script>
    <script src="snake.js"></script>
</body>
</html>
