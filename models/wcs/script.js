function cboxUp(e){
  e.children[0].style.visibility = 'hidden';
  e.children[1].style.visibility = 'visible';
}
function cboxDown(e){
  e.children[0].style.visibility = 'visible';
  e.children[1].style.visibility = 'hidden';
}

function openChatBox(e){
  if(e.innerHTML !== 'X'){
    e.innerHTML = 'X';
    chatbox.style.visibility = 'visible';
  } else {
    e.innerHTML = 'une question ?';
    chatbox.style.visibility = 'hidden';
  }
}

function chatAnswer(str){
  //Send message in chat
  chat.firstElementChild.firstElementChild.innerHTML += '<tr><td></td><td class="user-msg-chat">'+str+'</td></tr>';

  //Check it
  if(str.search('évenements') !== -1){
    keyword = 'évenements';
  } else if (str.search('colocs') !== -1) {
    keyword = 'colocs';
  } else {
    keyword = 'false';
  }

  //Answer it
  if(keyword !== 'false'){
    chat.firstElementChild.firstElementChild.innerHTML += '<tr><td><img src="../pool/images/face.jpg" class="fb-style"/></td><td class="msg-chat">Voici quelques informations sur les <strong>'+keyword+'</strong>&nbsp;: <a href="">lien</a></td></tr>';
  } else {
    chat.firstElementChild.firstElementChild.innerHTML += '<tr><td><img src="../pool/images/face.jpg" class="fb-style"/></td><td class="msg-chat">Je suis désolé, je n\'ai pas tout à fait compris.</td></tr><tr><td></td><td class="msg-chat">Pouvez-vous reformuler votre demande ou cliquer sur les propositions ?</td></tr>';
  }

  //Scroll
  var scrollBox = document.getElementById('chat');
  scrollBox.scrollTop = scrollBox.scrollHeight;
}

window.onkeyup = keyPressed;
function keyPressed(e){
  var keyValue;
  if(window.event) { // IE
    keyValue = e.keyCode;
  } else if(e.which){ // Netscape/Firefox/Opera
    keyValue = e.which;
  }
  //Enter
  if(keyValue === 13){
    chatSend();
  }
}

function chatSend(){
  if(inputchatsend.value !== ''){
    chatAnswer(inputchatsend.value);
    inputchatsend.value = '';
  }
}
