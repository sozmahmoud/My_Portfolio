<?php
$file = 'c:/xampp/htdocs/LIORA/assets/css/styles.css';
$lines = file($file);
$cleanLines = [];
foreach ($lines as $line) {
    if (strpos($line, ' / *   R e w a r d') !== false) {
        break; // Stop when we find the corrupted block
    }
    $cleanLines[] = $line;
}

// Now append the clean reward explanation and chatbot styles
$extra = "
/* Reward Explanation Section */
.reward-explanation {
    background: var(--container-color);
    padding: 2rem;
    border-radius: 1.5rem;
    margin: 2rem 0;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border: 1px solid var(--border-color);
}

.reward-explanation h4 {
    margin-bottom: 1.5rem;
    font-size: var(--h3-font-size);
    color: var(--title-color);
    text-align: center;
}

.reward-explanation__grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
}

.reward-step {
    text-align: center;
    padding: 1rem;
    transition: transform 0.3s ease;
}

.reward-step:hover {
    transform: translateY(-5px);
}

.reward-step__icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    background: var(--first-color-alt);
    width: 60px;
    height: 60px;
    line-height: 60px;
    border-radius: 50%;
    margin-left: auto;
    margin-right: auto;
}

.reward-step h5 {
    font-size: var(--normal-font-size);
    margin-bottom: 0.5rem;
    color: var(--first-color);
}

.reward-step p {
    font-size: var(--small-font-size);
    color: var(--text-color);
    line-height: 1.4;
}

@media screen and (max-width: 768px) {
    .reward-explanation__grid {
        grid-template-columns: 1fr;
    }
}

/* AI Typing Indicator */
.typing { display: flex; align-items: center; gap: 4px; padding: 10px 15px !important; }
.typing span { width: 6px; height: 6px; background: #d86f9a; border-radius: 50%; animation: typing 1s infinite ease-in-out; opacity: 0.6; }
.typing span:nth-child(2) { animation-delay: 0.2s; }
.typing span:nth-child(3) { animation-delay: 0.4s; }
@keyframes typing { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-5px); } }
.send-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none !important; }

/*=============== CHATBOT STYLES (NEW) ===============*/
.chatbot-section { max-width: 800px; margin: 0 auto; padding-bottom: 4rem; }
.chat-header { text-align: center; margin-bottom: 2rem; }
.chat-header img { width: 80px; height: 80px; border-radius: 50%; margin-bottom: 1rem; box-shadow: 0 5px 15px rgba(216, 27, 96, 0.2); }
.chat-header h2 { font-size: 1.5rem; color: #1a1a1a; }
.chat-container { background: #fff; border-radius: 20px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05); overflow: hidden; display: flex; flex-direction: column; height: 600px; border: 1px solid #f0f0f0; }
.chat-window { flex: 1; padding: 1.5rem; overflow-y: auto; display: flex; flex-direction: column; gap: 1rem; background-color: #fcfcfc; }
.message { max-width: 80%; padding: 1rem 1.25rem; border-radius: 18px; font-size: 0.95rem; line-height: 1.5; position: relative; animation: fadeInChat 0.3s ease; }
.bot-message { align-self: flex-start; background: #fff; color: #444; border-bottom-left-radius: 4px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03); border: 1px solid #f0f0f0; }
.user-message { align-self: flex-end; background: #c14e8f; color: #fff; border-bottom-right-radius: 4px; }
.chat-input-area { padding: 1.25rem; display: flex; gap: 1rem; background: #fff; border-top: 1px solid #f0f0f0; }
.chat-input { flex: 1; padding: 0.8rem 1.2rem; border: 1px solid #eee; border-radius: 30px; outline: none; transition: 0.3s; }
.chat-input:focus { border-color: #c14e8f; }
.send-btn { width: 45px; height: 45px; border-radius: 50%; background: #c14e8f; color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.3s; border: none; }
.send-btn:hover { transform: scale(1.1); }
.chat-products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem; margin-top: 1rem; width: 100%; padding: 0.5rem; }
.chat-product-card { background: #fff; border-radius: 12px; padding: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: 0.3s; border: 1px solid #f0f0f0; }
.chat-product-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(193,78,143,0.15); }
.chat-product-card .product__img { height: 160px; width: 100%; object-fit: cover; border-radius: 8px; margin-bottom: 10px; }
.chat-product-card .product__title { font-size: 1rem; color: #1a1a1a; margin: 8px 0; font-weight: 600; }
.chat-product-card .new__price { font-size: 1.1rem; color: #c14e8f; font-weight: 700; }
@keyframes fadeInChat { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
";

file_put_contents($file, implode('', $cleanLines) . $extra);
echo "✓ styles.css has been completely purged of corruption!\n";
?>
