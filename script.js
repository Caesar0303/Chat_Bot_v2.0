const form = document.querySelector('#chat-form');
const chatArea = document.querySelector('#chat-area');
let snakeWindow = document.querySelector('.wrapper');
form.addEventListener('submit', (e) => {
  e.preventDefault();
  const messageInput = form.querySelector('.inpt');
  const message = messageInput.value.trim();
  if (message == "Game") {
    snakeWindow.classList.remove('hide');
  } else if (message == "Close") {
    snakeWindow.classList.add('hide');
  }
  if (!message) return;
    axios.get('chatbot.php', { params: { message } })
    .then(response => {
      if (message == "Time" || message == "Weather") {
        const botMessage = document.createElement('div');
        const clientMessage = document.createElement('div');
        botMessage.classList.add('bot-message-special');
        botMessage.innerText = response.data;
        clientMessage.innerText = message;
        chatArea.appendChild(clientMessage);
        chatArea.appendChild(botMessage);
        messageInput.value = '';
      } else {
      const botMessage = document.createElement('div');
      const clientMessage = document.createElement('div');
      botMessage.classList.add('bot=message');
      botMessage.innerText = response.data;
      clientMessage.innerText = message;
      chatArea.appendChild(clientMessage);
      chatArea.appendChild(botMessage);
      messageInput.value = '';
      }
    })
    .catch(error => {
      console.error(error);
    });
});
