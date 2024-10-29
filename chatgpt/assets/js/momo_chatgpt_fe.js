/*global jQuery*/
/*global define */
/*global window */
/*global this*/
/*global location*/
/*global document*/
/*global momochatgpt_fe*/
/*global console*/
/*jslint this*/
/**
 * ChatGPT Frontend Script
 */
jQuery(document).ready(function ($) {
    "use strict";
    /**
     * Default function ends.
     */
    function scrollToBottom($messageBlock) {
        var shouldScroll = $messageBlock.scrollTop + $messageBlock.clientHeight === $messageBlock.scrollHeight;
        if (!shouldScroll) {
            $messageBlock.scrollTop($messageBlock.prop('scrollHeight'));
        }
    }
    function generateAnswer(value, $parent, type) {
        var $messageHolder = $parent.find('.momo-chatgpt-messages');
        var output = '<div class="momo-chat-row">';
        output += '<div class="momo-chat-left"><strong>' + momochatgpt_fe[ type ] + '</strong></div>';
        output += '<div class="momo-chat-right">' + value + '</div>';
        output += '</div>';
        $messageHolder.append(output);
        scrollToBottom($messageHolder);
    }
    function processChatGPT($parent) {
        var $input = $parent.find('input[name="momo_chatgpt_sender_input"]');
        var $working = $parent.find('.momo-fe-working');
        var value = $input.val();
        if ('' === value) {
            return;
        }
        $input.val('');
        var ajaxdata = {};
        ajaxdata.question = value;
        ajaxdata.security = momochatgpt_fe.momochatgpt_ajax_nonce;
        ajaxdata.action = 'momo_chatgpt_openai_generate_answer';
        $.ajax({
            beforeSend: function () {
                $working.addClass('show');
                $input.prop('disabled', true );
                generateAnswer(value, $parent, 'sender');
            },
            type: 'POST',
            dataType: 'json',
            url: momochatgpt_fe.ajaxurl,
            data: ajaxdata,
            success: function (data) {
                console.log(data);
                if (data.hasOwnProperty('status') && 'good' === data.status) {
                    generateAnswer(data.content, $parent, 'answer');
                } else {
                    generateAnswer(data.content, $parent, 'answer');
                }
            },
            complete: function () {
                $working.removeClass('show');
                $input.prop('disabled', false );
            },
        });
    }
    $('body').on('keypress', 'input[name="momo_chatgpt_sender_input"]', function (e) {
        if (e.keyCode === 13) {
            var $parent = $(this).closest('.momo-chatgpt-ui-container');
            processChatGPT($parent);
        }
    });
    $('body').on('click', '.momo-chatgpt-sender-box .bx', function (e) {
        var $parent = $(this).closest('.momo-chatgpt-ui-container');
        processChatGPT($parent);
    });
});