/*global jQuery*/
/*global define */
/*global window */
/*global this*/
/*global location*/
/*global document*/
/*global momoacg_admin*/
/*global console*/
/*jslint this*/
/**
 * momowsw Admin Script
 */
jQuery(document).ready(function ($) {
    "use strict";
    function changeAdminTab(hash) {
        var mmtmsTable = $('.momo-be-tab-table');
        mmtmsTable.attr('data-tab', hash);
        mmtmsTable.find('.momo-be-admin-content.active').removeClass('active');
        var ul = mmtmsTable.find('ul.momo-be-main-tab');
        ul.find('li a').removeClass('active');
        $(ul).find('a[href=\\' + hash + ']').addClass('active');
        mmtmsTable.find(hash).addClass('active');
        $("html, body").animate({
            scrollTop: 0
        }, 1000);
    }
    function doNothing() {
        var mmtmsTable = $('.momo-be-tab-table');
        mmtmsTable.attr('data-tab', '#momo-eo-ei-event_card');
        return;
    }
    function init() {
        var hash = window.location.hash;
        if (hash === '' || hash === 'undefined') {
            doNothing();
        } else {
            changeAdminTab(hash);
        }
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
    $('.momo-be-tab-table').on('click', 'ul.momo-be-main-tab li a, a.momo-inside-page-link', function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        changeAdminTab(href);
        window.location.hash = href;
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
    $('body').on('change', 'input[name="momo_be_mb_modify_headings"]', function (e) {
        var $parent = $(this).closest('#openai-content-generator');
        var $generateContent = $parent.find('#momo_be_mb_openai_generate_content');
        var $generateHeadings = $parent.find('#momo_be_mb_openai_generate_headings');
        var $generatedContent = $parent.find('.momo-be-section-generated-content');
        var $generatedHeadings = $parent.find('.momo-be-section-generated-headings');

        var $saveDraft = $parent.find('#momo_be_mb_openai_draft_content');

        if ($(this).is(":checked")) {
            $generateContent.addClass('momo-hidden').removeClass('momo-show');
            $generateHeadings.addClass('momo-show').removeClass('momo-hidden');

            $generatedContent.addClass('momo-hidden').removeClass('momo-show');
            $generatedHeadings.addClass('momo-show').removeClass('momo-hidden');

            $saveDraft.addClass('momo-hidden').removeClass('momo-show');

        } else {
            $generateContent.removeClass('momo-hidden').addClass('momo-show');
            $generateHeadings.removeClass('momo-show').addClass('momo-hidden');

            $generatedContent.removeClass('momo-hidden').addClass('momo-show');
            $generatedHeadings.removeClass('momo-show').addClass('momo-hidden');

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
    $('body').on('click', '#momo_be_mb_openai_generate_content_old', function (e) {
        e.preventDefault();
        var $parent = $(this).closest('#openai-content-generator');
        var $working = $parent.find('.momo-be-working');
        var $msgBox = $parent.find('#momo_be_mb_openai_messagebox');
        $msgBox.removeClass('warning');
        $msgBox.removeClass('success');
        var $addImage = $parent.find('input[name="momo_be_mb_add_image"]');
        var $addIntroduction = $parent.find('input[name="momo_be_mb_add_introduction"]');
        var $addConclusion = $parent.find('input[name="momo_be_mb_add_conclusion"]');
        var $addHeadings = $parent.find('input[name="momo_be_mb_add_headings"]');
        var $addHyperlink = $parent.find('input[name="momo_be_mb_add_hyperlink"]');
        var $modifyHeadings = $parent.find('input[name="momo_be_mb_modify_headings"]');
        var language = $parent.find('select[name="momo_be_mb_language"]').val();
        var headingwrapper = $parent.find('select[name="momo_be_mb_heading_wrapper"]').val();
        var title = $parent.find('input[name="momo_be_mb_search_title"]').val();
        var hyperlink_text = $parent.find('input[name="momo_be_mb_search_hyperlink_text"]').val();
        var anchor_link = $parent.find('input[name="momo_be_mb_anchor_link"]').val();
        var nopara = $parent.find('select[name="momo_be_mb_nopara"]').val();
        var writing_style = $parent.find('select[name="momo_be_mb_writing_style"]').val();
        var $contentBox = $parent.find('#momo_be_mb_generated_content');
        var ajaxdata = {};
        ajaxdata.language = language;
        ajaxdata.title = title;
        ajaxdata.nopara = nopara;
        ajaxdata.writing_style = writing_style;
        ajaxdata.headingwrapper = headingwrapper;
        ajaxdata.hyperlink_text = hyperlink_text;
        ajaxdata.anchor_link = anchor_link;
        if ($addImage.is(":checked")) {
            ajaxdata.addimage = 'on';
        } else {
            ajaxdata.addimage = 'off';
        }
        if ($addIntroduction.is(":checked")) {
            ajaxdata.addintroduction = 'on';
        } else {
            ajaxdata.addintroduction = 'off';
        }
        if ($addConclusion.is(":checked")) {
            ajaxdata.addconclusion = 'on';
        } else {
            ajaxdata.addconclusion = 'off';
        }
        if ($addHeadings.is(":checked")) {
            ajaxdata.addheadings = 'on';
        } else {
            ajaxdata.addheadings = 'off';
        }
        if ($addHyperlink.is(":checked")) {
            ajaxdata.addhyperlink = 'on';
        } else {
            ajaxdata.addhyperlink = 'off';
        }
        if ($modifyHeadings.is(":checked")) {
            ajaxdata.modifyheadings = 'on';
            var headingsList = [];
            var parasList = [];
            var wrappersList = [];
            $parent.find('input[name="momo_be_mb_heading[]"]').each(function () {
                headingsList.push($(this).val());
            });
            $parent.find('select[name="momo_be_mb_heading_para[]"]').each(function () {
                parasList.push($(this).val());
            });
            $parent.find('select[name="momo_be_mb_heading_wrapper[]"]').each(function () {
                wrappersList.push($(this).val());
            });
            ajaxdata.headings = headingsList;
            ajaxdata.paras = parasList;
            ajaxdata.wrappers = wrappersList;
        } else {
            ajaxdata.modifyheadings = 'off';
        }
        ajaxdata.security = momoacg_admin.momoacg_ajax_nonce;
        ajaxdata.action = 'momo_acg_openai_generate_content';
        $.ajax({
            beforeSend: function () {
                $contentBox.val('');
                $working.addClass('show');
                $msgBox.html(momoacg_admin.generating_content);
                $msgBox.show();
            },
            type: 'POST',
            dataType: 'json',
            url: momoacg_admin.ajaxurl,
            data: ajaxdata,
            success: function (data) {
                if (data.hasOwnProperty('status') && 'bad' === data.status) {
                    $msgBox.html(data.msg);
                    $msgBox.show();
                } else if (data.hasOwnProperty('status') && 'good' === data.status) {
                    var $generatedContent = $parent.find('.momo-be-section-generated-content');
                    var $generatedHeadings = $parent.find('.momo-be-section-generated-headings');

                    var $saveDraft = $parent.find('#momo_be_mb_openai_draft_content');
                    $msgBox.html(data.msg);
                    $msgBox.show();
                    $contentBox.val(data.content);
                    $generatedContent.removeClass('momo-hidden').addClass('momo-show');
                    $saveDraft.removeClass('momo-hidden').addClass('momo-show');
                    $generatedHeadings.addClass('momo-hidden').removeClass('momo-show');
                } else {
                    $msgBox.html(momoacg_admin.empty_response);
                    $msgBox.show();
                }
            },
            complete: function () {
                $working.removeClass('show');
            }
        });
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
        ajaxdata.security = momoacg_admin.momoacg_ajax_nonce;
        ajaxdata.action = 'momo_acg_openai_generate_headings';
        $.ajax({
            beforeSend: function () {
                $headingsBox.html('');
                $working.addClass('show');
                $msgBox.html(momoacg_admin.generating_heading);
                $msgBox.show();
            },
            type: 'POST',
            dataType: 'json',
            url: momoacg_admin.ajaxurl,
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
                    $msgBox.html(momoacg_admin.empty_response);
                    $msgBox.show();
                }
            },
            complete: function () {
                $working.removeClass('show');
            }
        });
    });
    $('body').on('click', '#momo_be_mb_openai_draft_content', function (e) {
        e.preventDefault();
        var $parent = $(this).closest('#openai-content-generator');
        var $working = $parent.find('.momo-be-working');
        var $msgBox = $parent.find('#momo_be_mb_openai_messagebox');
        $msgBox.removeClass('warning');
        $msgBox.removeClass('success');
        var $contentBox = $parent.find('#momo_be_mb_generated_content');
        var draftID = $contentBox.attr('data-draft_id');
        var title = $parent.find('input[name="momo_be_mb_search_title"]').val();
        var ajaxdata = {};
        ajaxdata.security = momoacg_admin.momoacg_ajax_nonce;
        ajaxdata.action = 'momo_acg_openai_save_draft_content';
        ajaxdata.draft_id = draftID;
        ajaxdata.content = $contentBox.val();
        ajaxdata.title = title;
        $.ajax({
            beforeSend: function () {
                $working.addClass('show');
                $msgBox.html(momoacg_admin.saving_draft);
                $msgBox.show();
            },
            type: 'POST',
            dataType: 'json',
            url: momoacg_admin.ajaxurl,
            data: ajaxdata,
            success: function (data) {
                if (data.hasOwnProperty('status') && 'bad' === data.status) {
                    $msgBox.html(data.msg);
                    $msgBox.addClass('warning');
                    $msgBox.show();
                } else if (data.hasOwnProperty('status') && 'good' === data.status) {
                    $msgBox.html(data.msg);
                    $msgBox.addClass('success');
                    $msgBox.show();
                    console.log(data);
                    $contentBox.attr('data-draft_id', data.draft_id);
                }
            },
            complete: function () {
                $working.removeClass('show');
            }
        });
    });
    /**** Clear Logs */
    $('body').on('click', '#mmtre_flush_debug_logs', function (e) {
        var type = $(this).data('type');
        var $tab = $(this).closest('.momo-be-main-tabcontent');
        var $container = $(this).closest('.momoacg-debug-log');
        var $working = $tab.find('.momo-be-working');
        var ajaxdata = {};
        ajaxdata.action = 'momo_acg_flush_debug_logs';
        ajaxdata.security = momoacg_admin.momoacg_ajax_nonce;
        ajaxdata.type = type;
        $.ajax({
            beforeSend: function () {
                $working.addClass('show');
            },
            type: 'POST',
            dataType: 'json',
            url: momoacg_admin.ajaxurl,
            data: ajaxdata,
            success: function (data) {
                if ('good' === data.status) {
                    $container.find('.momo-be-textarea-style').html(data.message);
                }
            },
            complete: function () {
                $working.removeClass('show');
            }
        });
    });
    $('body').on('click', '.momo-clear-api', function (e) {
        var $parent = $(this).closest('.momo-be-block-section');
        var $input = $parent.find('input');
        var $masked = $parent.find('.momo-block-with-asterix');
        $input.val('');
        $input.removeClass('momo-hidden');
        $masked.addClass('momo-hidden');
        $input.focus();
    });
});