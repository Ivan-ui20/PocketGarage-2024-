<?php
    require_once './backend/database/db.php';
    session_start();

    if(!isset($_SESSION['user_id'])) {
      header("Location: index.php");
      exit();
  }  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- CSS-link -->
    <link rel="stylesheet" href="MyProfile.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
    />


</head>
<body>
  
    <?php include './shared/header.php';?>
      <!-- Messages Section for Buyer-->


    <div id="message-section" class="section">

      <div class="chat-container">
        <!-- Left Chat List -->
        <div class="chat-list" id="chat-list">
        
        </div>

       <!-- Right Chat Box -->
        <div class="chat-box" id="chat-box">
          <div class="messages" id="messages">
            <!-- Messages will load here -->
          </div>

          <form id="message-form">
            <div class="message-input">
              <input type="hidden" id="room-id" value="">
              <input type="hidden" id="customer-id" value="<?php echo $_SESSION["user_id"]?>">
              <input type="hidden" id="user-type" value="<?php echo $_SESSION["user_type"]?>">

              <input type="text" id="message-input" placeholder="Type your message here..." />
                                
              <input type="file" id="image-input" accept="image/*" style="display: none;" />
                                
              <span class="material-symbols-outlined" id="file-icon" onclick="document.getElementById('image-input').click();">
                  attach_file
              </span>

              <button type="button" onclick="sendMessage()">Send</button>
            </div>
          </form> 
        </div>                 
      </div>           
    </div>

   <!-- need to fix chat routes-->


    <!-- Cart Modal -->
    <?php include './shared/cartModal.php';?>
    <!-- Checkout Modal -->
    <?php include './shared/checkoutModal.php';?>

    <div class="footer">
        <?php include './shared/footer.php';?>
    </div>
        
    <script src="./scripts/java.js"></script>
    <script>
      const messagesData = {};
      const customerId = document.getElementById("customer-id").value;
      fetch(`/backend/src/chat/route.php?route=last/chat/get/customer&customer_id=${customerId}`, {
        method: 'GET',                
        headers: {
            'Content-Type': 'application/json'
        }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(chat => {            
            const chatListDiv = document.getElementById("chat-list");            
            chatListDiv.innerHTML = "";           
        
            chat.data.forEach(chat => {                            
                const chatItem = document.createElement("div");
                chatItem.className = "chat-list-item";
                chatItem.onclick = () => openChat(chat.room_id);                 
                chatItem.innerHTML = `
                    ${chat.seller_name} - <small>Last message: ${chat.message}</small>
                `;

                const chatItem1 = document.createElement("div");
                chatItem1.className = "chat-list-item";
                chatItem1.onclick = () => openChat(chat.room_id);                 
                chatItem1.innerHTML = `
                    ${chat.seller_name} - <small>Last message: ${chat.message}</small>
                `;
                
                chatListDiv.appendChild(chatItem);                                 
            });                      
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });

        async function sendMessage() {
          event.preventDefault()
          
          const roomId = document.getElementById("room-id").value
          const senderId = document.getElementById("customer-id").value
          const userType = document.getElementById("user-type").value
          const message = document.getElementById('message-input').value;
                  
          const file = document.getElementById('image-input').files[0];        
          
          // const data = new URLSearchParams({          
          //   room_id: roomId,
          //   sender_id: senderId,
          //   user_type: userType,
          //   message: message,
          //   attachment: file ? file : null,
          // });

          const formData = new FormData();
                          
          formData.append('room_id', roomId);
          formData.append('sender_id', senderId);
          formData.append('user_type', userType);
          formData.append('message', message);
          formData.append('attachment', file);
        
          fetch('/backend/src/chat/route.php?route=chat/send', {
            method: 'POST',
            body: formData,          
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log(data);              
                alert("message sent")
                document.getElementById('message-form').reset();                
                openChat(roomId)
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });          
        }
        function openChat(chatId) {
          const chatBox = document.getElementById('messages');
          chatBox.innerHTML = ''; // Clear previous messages      
          
          fetch(`/backend/src/chat/route.php?route=chat/get&room_id=${chatId}&limit=10&offset=0`, {
            method: 'GET',                
            headers: {
                'Content-Type': 'application/json'
            }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(chat => {
              
              chat.data.forEach(chat => {    
                          
                if (!messagesData[chatId]) {
                    messagesData[chatId] = [];
                }                                
                const messageExists = messagesData[chatId].some(message => message.id === chat.message_id);
                if (!messageExists) {
                  messagesData[chatId].push({ id: chat.message_id, type: chat.sender_type, sender: chat.name, text: chat.message });
                }
              })
              const chatMessages = messagesData[chatId];      
                
              
              const roomId = document.getElementById("room-id");
              roomId.value = chatId;

              chatMessages.forEach((message) => {
                const messageElement = document.createElement('div');
                                            
                messageElement.classList.add('message');
                
                if (message.type === "seller") {
                  messageElement.innerHTML = ` <div class="message sent"> <strong>${message.sender}:</strong> ${message.text} </div>`;               
                } else {                               
                  messageElement.innerHTML = ` <div class="message received"> <strong>${message.sender}:</strong> ${message.text} </div>`;
                }            
                chatBox.appendChild(messageElement);
              });
              // window.location.reload()
              // openChat(chatId)
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });                  
        }
        // setInterval(openChat, 3000); 
    </script>
    <script>
      function getUrlParams() {
        const params = new URLSearchParams(window.location.search);
        const sellerId = params.get('seller_id');
        const customerId = params.get('customer_id');
            
        if (sellerId && customerId) {
          createChatRoom(sellerId, customerId);
        }
      }
      getUrlParams();

    
    function createChatRoom(sellerId, customerId) {       
      
      const formData = new FormData();
                          
      formData.append('seller_id', sellerId);
      formData.append('customer_id', customerId);
         
      fetch('/backend/src/chat/route.php?route=chat/room', {
        method: 'POST',       
        body: formData
      })
      .then(response => {
          if (!response.ok) {
              throw new Error('Network response was not ok');
          }
          return response.json();
      })
      .then(data => {
          console.log(data);          
          openChat(data.data.room_id)
      })
      .catch(error => {
          console.error('There was a problem with the fetch operation:', error);
      });
    }
    </script>
</body>
</html>



<style>
/* chat section */

#message-section h2 {
  color:  rgb(17, 8, 43);
  gap: 1rem;
  padding: 1rem;
}



.chat-container {
  display: flex;
  flex-direction: row;
  height: 80vh;
  max-width: 500px;
  background-color: rgba(45, 19, 116, 0.274);
  backdrop-filter: blur(10px);
  border: 1px solid #ccc;
  border-radius: 10px;
  overflow: hidden;
  gap: 1rem;
  max-width: 900px;
  margin: 2rem auto;
  margin-top: 1rem;


}

.chat-list {
  flex: 1;
  background-color: #f7f7f7;
  padding: 10px;
  border-right: 1px solid #ccc;
  overflow-y: auto;
  height: 400px;
  max-width: 2000px;
  height: 80vh;

}

.chat-list-item {
  padding: 10px;
  border-bottom: 1px solid #ddd;
  cursor: pointer;
}

.chat-list-item:hover {
  background-color: #e0e0e0;
}

.chat-box {
  flex: 3;
  display: flex;
  flex-direction: column;
  padding: 10px;
  justify-content: space-between;
  max-width: 500px;
  
}

.chat-box .messages {
  flex: 1;
  overflow-y: auto;
  padding: 10px;
  border-bottom: 1px solid #ccc;
}

.chat-box .message {
  padding: 5px 10px;
  margin-bottom: 10px;
  border-radius: 8px;
}

.sent {
  background-color: #daf5db;
  align-self: flex-end;
}

.received {
  background-color: #f1f1f1;
  align-self: flex-start;
}

.message-input {
  display: flex;
  gap: 10px;
  padding-top: 10px;
}

.message-input input {
  flex: 1;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.message-input button {
  padding: 10px 20px;
  background-color: #201e1f;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;  
}

.message-input button:hover {
  background-color: #c98585;
}

</style>