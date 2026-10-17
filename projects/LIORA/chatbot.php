<?php
session_start();
include 'header.php';
?>
    <!--=============== HEADER ===============-->
  

  <!--=============== MAIN ===============-->
  <main class="main">
    <section class="chatbot-section container section">
      <div class="chat-header">
        <img src="assets/img/AI.JPG" alt="Liora AI Assistant" />
        <h2>Hi, I'm Liora Assistant 🌷🤖</h2>
        <p>Ask me anything about flowers, bouquets, or the perfect gift for any occasion!</p>
      </div>

      <div class="chat-container">
        <div class="chat-window" id="chat-window">
          <!-- Welcome message will be added by JS -->
        </div>

        <div class="chat-input-area">
          <input type="text" id="user-input" class="chat-input" placeholder="Type your message here..." autocomplete="off" />
          <button class="send-btn" id="send-btn" type="button" aria-label="Send message">
            <i class="fi fi-rs-paper-plane"></i>
          </button>
        </div>
      </div>

      <!-- Chat History Section -->
      <div class="chat-history-container">
        <div class="chat-history-header">
          <h3><i class="fi fi-rs-time-past"></i> Recent Chat History</h3>
          <p>Review your previous conversations with Liora</p>
        </div>
        <div class="chat-history-actions">
          <button class="clear-history-btn" id="clear-history-btn">
            <i class="fi fi-rs-trash"></i> Clear All
          </button>
        </div>
        <div class="chat-history-list" id="chat-history-list">
          <div class="empty-history">
            <p>No chat history yet. Start a conversation above! 🌸</p>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!--=============== FOOTER (copy from index.html) ===============-->
  

  <!--=============== SCRIPTS ===============--><!-- Chatbot JS will be in main.js or chatbot.js -->
    <!--=============== search ===============--><?php include 'footer.php'; ?>


