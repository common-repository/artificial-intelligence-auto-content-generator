/*global jQuery*/
/*global define */
/*global window */
/*global this*/
/*global location*/
/*global document*/
/*global momoacgcs_fe*/
/*global momoacgcs_fe*/
/*global console*/
/*jslint this*/
/**
 * momowsw Admin Script
 */
jQuery(document).ready(function ($) {
    "use strict";
    function momoChangePlanBorderColor() {
        $('body').find('.momo-cs-plan-holder-container input[type="radio"]').each(function () {
            var $parent = $(this).closest('.momo-plan-single-holder');
            if ($(this).is(":checked")) {
                $parent.addClass('is-active');
            } else {
                $parent.removeClass('is-active');
            }
        });
    }
    function init() {
        momoChangePlanBorderColor();
        $('#momo-be-form .switch-input').each(function () {
            var toggleContainer = $(this).parents('.momo-be-toggle-container');
            var afteryes = toggleContainer.attr('momo-be-tc-yes-container');
            if ($(this).is(":checked")) {
                $('#' + afteryes).addClass('active');
            } else {
                $('#' + afteryes).removeClass('active');
            }
        });
    }
    init();
    $('body').on('change', '#momo-be-form  .switch-input, .momo-be-mb-form .switch-input', function () {
        var toggleContainer = $(this).parents('.momo-be-toggle-container');
        var afteryes = toggleContainer.attr('momo-be-tc-yes-container');
        if ($(this).is(":checked")) {
            $('#' + afteryes).addClass('active');
        } else {
            $('#' + afteryes).removeClass('active');
            $(this).val('off');
        }
    });
    $('body').on('input', '.momo-be-range-slider', function () {

        var control = $(this);
        var controlMin = control.attr('min');
        var controlMax = control.attr('max');
        var controlVal = control.val();
        var controlThumbWidth = control.data('thumbwidth');

        var range = controlMax - controlMin;

        var position = ((controlVal - controlMin) / range) * 100;
        var positionOffset = Math.round(controlThumbWidth * position / 100) - (controlThumbWidth / 2);
        var output = control.next('.momo-be-rs-value');

        output.css('left', 'calc(' + position + '% - ' + positionOffset + 'px)').text(controlVal);

    });
    $('body').on('click', '.momo-cs-plan-holder-container input[type="radio"]', function () {
        momoChangePlanBorderColor();
    });
    $('body').on('click', 'span.momo-plan-single-holder', function () {
        var $radio = $(this).find('input[type="radio"]');
        $radio.prop('checked', true);
        momoChangePlanBorderColor();
    });
    $('body').on('click', '.momo-cs-continue-checkout-cart', function () {
        var $loader = $(this).closest('.momo-cs-plan-relative-container');
        var $parent = $(this).closest('.momo-cs-plan-holder-container');
        var $msgbox = $loader.find('.momo-fe-msg-block');
        $msgbox.removeClass('show').removeClass('warning').html('');
        var url = $parent.data('url');
        var plan = $parent.find('input[name="plan"]:checked').val();
        var ajaxdata = {};
        ajaxdata.plan_id = plan;
        ajaxdata.url = url;
        ajaxdata.security = momoacgcs_fe.momoacgcs_ajax_nonce;
        ajaxdata.action = 'momo_acg_cs_add_to_cart_plan';
        $.ajax({
            beforeSend: function () {
                $loader.addClass('momo-loading-fe');
            },
            type: 'POST',
            dataType: 'json',
            url: momoacgcs_fe.ajaxurl,
            data: ajaxdata,
            success: function (data) {
                if (data.hasOwnProperty('status') && 'good' === data.status) {
                    $msgbox.html(data.msg);
                    $msgbox.addClass('show').addClass('info');
                } else {
                    $msgbox.html(data.msg);
                    $msgbox.addClass('show').addClass('warning');
                }
            },
            complete: function () {
                $loader.removeClass('momo-loading-fe');
            }
        });
    });
    /** Content Generator */
    $('body').on('change', 'input[name="momo_be_mb_modify_headings"]', function (e) {
        var $parent = $(this).closest('#openai-content-generator');
        var $generateContent = $parent.find('#momo_be_mb_openai_generate_content');
        var $generateHeadings = $parent.find('#momo_be_mb_openai_generate_headings');
        var $scheduleGenerator = $parent.find('#momo_be_mb_openai_schedule_generator');

        var $generatedContent = $parent.find('.momo-be-section-generated-content');
        var $generatedHeadings = $parent.find('.momo-be-section-generated-headings');

        var $saveDraft = $parent.find('#momo_be_mb_openai_draft_content');

        if ($(this).is(":checked")) {
            $generateContent.addClass('momo-hidden').removeClass('momo-show');
            $generateHeadings.addClass('momo-show').removeClass('momo-hidden');

            $generatedContent.addClass('momo-hidden').removeClass('momo-show');
            $generatedHeadings.addClass('momo-show').removeClass('momo-hidden');

            $scheduleGenerator.addClass('momo-hidden').removeClass('momo-show');

            $saveDraft.addClass('momo-hidden').removeClass('momo-show');

        } else {
            $generateContent.removeClass('momo-hidden').addClass('momo-show');
            $generateHeadings.removeClass('momo-show').addClass('momo-hidden');

            $generatedContent.removeClass('momo-hidden').addClass('momo-show');
            $generatedHeadings.removeClass('momo-show').addClass('momo-hidden');

            $scheduleGenerator.addClass('momo-show').removeClass('momo-hidden');

            $saveDraft.removeClass('momo-hidden').addClass('momo-show');
        }
    });
    $('body').on('change', 'input[name="momo_be_mb_add_headings"]', function (e) {
        var $parent = $(this).closest('#openai-content-generator');
        var $modifyHeadings = $parent.find('input[name="momo_be_mb_modify_headings"]');
        if (!$(this).is(":checked")) {
            $modifyHeadings.prop("checked", false);
            $modifyHeadings.trigger('change');
        }
    });
    $('body').on('click', '#momo_be_mb_openai_generate_headings', function (e) {
        e.preventDefault();
        var $parent = $(this).closest('#openai-content-generator');
        var $working = $parent.find('.momo-be-working');
        var $msgBox = $parent.find('#momo_be_mb_openai_messagebox');
        $msgBox.removeClass('warning');
        $msgBox.removeClass('success');
        var language = $parent.find('select[name="momo_be_mb_language"]').val();
        var title = $parent.find('input[name="momo_be_mb_search_title"]').val();
        var $modifyHeadings = $parent.find('input[name="momo_be_mb_modify_headings"]');
        var $headingsBox = $parent.find('.momo-be-section-generated-headings').find('.momo-be-section-container');
        var nopara = $parent.find('select[name="momo_be_mb_nopara"]').val();
        var writing_style = $parent.find('select[name="momo_be_mb_writing_style"]').val();
        var headingwrapper = $parent.find('select[name="momo_be_mb_heading_wrapper"]').val();
        var ajaxdata = {};
        if ($modifyHeadings.is(":checked")) {
            ajaxdata.modifyheadings = 'on';
        } else {
            ajaxdata.modifyheadings = 'off';
        }
        ajaxdata.headingwrapper = headingwrapper;
        ajaxdata.language = language;
        ajaxdata.title = title;
        ajaxdata.nopara = nopara;
        ajaxdata.writing_style = writing_style;
        ajaxdata.security = momoacgcs_fe.momoacgcs_ajax_nonce;
        ajaxdata.action = 'momo_acg_openai_generate_headings_fe';
        $.ajax({
            beforeSend: function () {
                $headingsBox.html('');
                $working.addClass('show');
                $msgBox.html(momoacgcs_fe.generating_heading);
                $msgBox.show();
            },
            type: 'POST',
            dataType: 'json',
            url: momoacgcs_fe.ajaxurl,
            data: ajaxdata,
            success: function (data) {
                if (data.hasOwnProperty('status') && 'bad' === data.status) {
                    $msgBox.html(data.msg);
                    $msgBox.show();
                } else if (data.hasOwnProperty('status') && 'good' === data.status) {
                    var $generateContent = $parent.find('#momo_be_mb_openai_generate_content');
                    var $generateHeadings = $parent.find('#momo_be_mb_openai_generate_headings');
                    $msgBox.html(data.msg);
                    $msgBox.show();
                    $headingsBox.html(data.content);
                    $generateContent.addClass('momo-show').removeClass('momo-hidden');
                    $generateHeadings.addClass('momo-hidden').removeClass('momo-show');
                } else {
                    $msgBox.html(momoacgcs_fe.empty_response);
                    $msgBox.show();
                }
            },
            complete: function () {
                $working.removeClass('show');
            }
        });
    });
});