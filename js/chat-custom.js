jQuery(document).ready(function($) {
    $('#chatbot-send').on('click', function() {
        var message = $('#chatbot-input').val().trim();
        if (message === '') return;

        $('#chatbot-messages').append('<div class="user-message">' + message + '</div>');
        $('#chatbot-input').val('');

        $.ajax({
            url: chatbot_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'ai_chatbot_response',
                security: chatbot_ajax.nonce,
                message: message
            },
            success: function(response) {
                if (response.success) {
                    $('#chatbot-messages').append('<div class="bot-message">' + response.data.response + '</div>');
                } else {
                    $('#chatbot-messages').append('<div class="bot-message">Error processing request.</div>');
                }
            },
            error: function() {
                $('#chatbot-messages').append('<div class="bot-message">Error connecting to the server.</div>');
            }
        });
    });

    $('#chatbot-input').keypress(function(event) {
        if (event.which === 13) {
            $('#chatbot-send').click();
        }
    });
});
