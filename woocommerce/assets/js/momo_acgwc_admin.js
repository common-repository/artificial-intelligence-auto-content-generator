/*global jQuery*/
/*global define */
/*global window */
/*global this*/
/*global tinymce*/
/*global document*/
/*global momoacgwc_admin*/
/*global console*/
/*global FileReader*/
/*global location*/
/*jslint this*/
/**
 * Woo Product Writer (momoacgwc) Admin Script
 */
jQuery(document).ready(function ($) {
    "use strict";
    $('body').on('click', '#momo-acg-wc-generate-product', function () {
        var $parent = $(this).closest('.momo-mb-side');
        var $poststuff = $(this).closest('#poststuff');
        var $postBody = $poststuff.find('#post-body-content');
        var $form = $poststuff.closest('form#post');
        var product_id = $form.find('input[name="post_ID"]').val();
        var $msgBox = $parent.find('#momo_be_mb_generate_product_messagebox');
        var $buttonBlock = $(this).closest('.momo-be-side-bottom');
        var $spinner = $buttonBlock.find('span.spinner');
        var title = $postBody.find('input[name="post_title"]').val();
        var language = $parent.find('select[name="momo_be_mb_language"]').val();
        var temperature = $parent.find('input[name="momo_be_mb_temperature"]').val();
        var max_tokens = $parent.find('input[name="momo_be_mb_max_tokens"]').val();
        var top_p = $parent.find('input[name="momo_be_mb_top_p"]').val();
        var frequency_penalty = $parent.find('input[name="momo_be_mb_frequency_penalty"]').val();
        var presence_penalty = $parent.find('input[name="momo_be_mb_presence_penalty"]').val();
        var ajaxdata = {};
        ajaxdata.product_id = product_id;
        ajaxdata.language = language;
        ajaxdata.title = title;
        ajaxdata.temperature = temperature;
        ajaxdata.max_tokens = max_tokens;
        ajaxdata.top_p = top_p;
        ajaxdata.frequency_penalty = frequency_penalty;
        ajaxdata.presence_penalty = presence_penalty;
        ajaxdata.security = momoacgwc_admin.momoacgwc_ajax_nonce;
        ajaxdata.action = 'momo_acg_wc_openai_generate_product';
        $.ajax({
            beforeSend: function () {
                $msgBox.html(momoacgwc_admin.generating_product);
                $msgBox.show();
                $spinner.addClass('is-active');
            },
            type: 'POST',
            dataType: 'json',
            url: momoacgwc_admin.ajaxurl,
            data: ajaxdata,
            success: function (data) {
                console.log(data);
                if (data.hasOwnProperty('status') && 'bad' === data.status) {
                    $msgBox.html(data.msg);
                    $msgBox.show();
                } else if (data.hasOwnProperty('status') && 'good' === data.status) {
                    if (null === tinymce.get('content')) {
                        var ohtml = $('#content').val();
                        $('#content').val(ohtml + data.content);
                    } else {
                        var olderHtml = tinymce.get('content').getContent();
                        tinymce.get('content').setContent(olderHtml + data.content);
                    }
                    if (null === tinymce.get('excerpt')) {
                        var ohtmle = $('#excerpt').val();
                        $('#excerpt').val(ohtmle + data.content);
                    } else {
                        var olderHtmlE = tinymce.get('excerpt').getContent();
                        tinymce.get('excerpt').setContent(olderHtmlE + data.short);
                    }
                    $msgBox.html(data.msg);
                    $msgBox.show();
                } else {
                    $msgBox.html(momoacgwc_admin.empty_response);
                    $msgBox.show();
                }
            },
            complete: function () {
                $spinner.removeClass('is-active');
            }
        });
    });
});