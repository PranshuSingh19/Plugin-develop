<?php
/*
Plugin Name: AI Chatbot for FAQs
Plugin URI: https://wordpress.org/plugins/classic-editor/
Description: A simple AI chatbot for answering FAQs using OpenAI's API.
Version: 1.0
Author: Pranshu Singh
Author URI: https://github.com/PranshuSingh19
License: GPL2
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Enqueue scripts and styles
function ai_chatbot_enqueue_scripts() {
    wp_enqueue_script('ai-chatbot-script', plugin_dir_url(__FILE__) . '/js/chat-custom.js', array('jquery'), '1.0', true);
    wp_enqueue_style('ai-chatbot-style', plugin_dir_url(__FILE__) . '/css/chat.css', array(), '1.0');
    wp_localize_script('ai-chatbot-script', 'chatbot_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ai_chatbot_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'ai_chatbot_enqueue_scripts');

// Shortcode to display chatbot
function ai_chatbot_shortcode() {
    ob_start();
    ?>
    <div id="ai-chatbot">
        <div id="chatbot-messages"></div>
        <div class="chat-from">
        <input type="text" id="chatbot-input" placeholder="Ask a question...">
        <button id="chatbot-send">Send</button>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('ai_chatbot', 'ai_chatbot_shortcode');

// AJAX handler for chatbot response
function ai_chatbot_ajax_response() {
    check_ajax_referer('ai_chatbot_nonce', 'security');
    
    $user_input = sanitize_text_field($_POST['message']);
    
    // Example AI response (Replace with OpenAI API integration)
    $responses = [
        'hello' => 'Hello! How can I assist you today?',
        'who are you' => 'I am ai chat modale create by Mr. Pranshu Singh',
        'what type of work are you doing' => 'I am here to provide information, answer questions, assist with problem-solving, and engage in conversations on a wide range of topics. Whether you need help with homework, explanations of concepts, or just want to chat, I am here for you! What would you like to know or discuss?',
        'thanku for assist' => 'You are welcome! If you have any other questions or need further assistance, feel free to ask. I am here to help!',
        'What are your business hours?' => 'We are open Monday to Friday from 9 AM to 5 PM.',
        'How can I contact support?' => 'You can contact our support team via email at support@yourwebsite.com.',
        'Do you offer refunds?' => 'Yes, we offer a 30-day money-back guarantee.'
    ];
    
    $response = isset($responses[$user_input]) ? $responses[$user_input] : 'I am sorry, I do not understand your question.';
    
    wp_send_json_success(['response' => $response]);
}
add_action('wp_ajax_ai_chatbot_response', 'ai_chatbot_ajax_response');
add_action('wp_ajax_nopriv_ai_chatbot_response', 'ai_chatbot_ajax_response');
?>