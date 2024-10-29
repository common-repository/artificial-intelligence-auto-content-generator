/*global jQuery*/
/*global define */
/*global window */
/*global $(this)*/
/*global setTimeout*/
/*global document*/
/*global momoacgcs_fe*/
/*global console*/
/**
 * Async Script
 */
jQuery(document).ready(function ($) {
    "use strict";
    var start = null;
    var end = null;
    function generateImage($this, ajaxdata) {
        var $parent = $this.closest('#openai-content-generator');
        var $working = $parent.find('.momo-be-working');
        var $msgBox = $parent.find('#momo_be_mb_openai_messagebox');
        var $contentBox = $parent.find('#momo_be_mb_generated_content');
        ajaxdata.action = 'momo_acg_openai_generate_remaining_synchronously_fe';
        ajaxdata.security = momoacgcs_fe.momoacgcs_ajax_nonce;
        ajaxdata.stage = 'image';
        if ('off' === ajaxdata.addimage) {
            triggerTimeCard($this);
            return;
        }
        $.ajax({
            beforeSend: function () {
                var old = '';
                $working.addClass('show');
                old += $msgBox.html();
                $msgBox.html(old + '</br>' + '<b>' + momoacgcs_fe.mb_add_image + '</b>');
                $msgBox.show();
            },
            type: 'POST',
            dataType: 'json',
            url: momoacgcs_fe.ajaxurl,
            data: ajaxdata,
            success: function (data) {
                var old = '';
                if ('stop' === data.stage) {
                    old = $msgBox.html();
                    $working.removeClass('show');
                    $msgBox.html(old + '</br>' + data.msg);
                } else {
                    if (data.hasOwnProperty('status') && 'bad' === data.status) {
                        old = $msgBox.html();
                        $msgBox.html(old + '</br>' + data.msg);
                        $msgBox.show();
                    } else if (data.hasOwnProperty('status') && 'good' === data.status) {
                        var oldContent = $contentBox.val();
                        $contentBox.val(oldContent + data.content);
                        old = $msgBox.html();
                        $msgBox.html(old + '</br>' + '&#x2022;  ' + data.msg);
                        $msgBox.show();
                    }
                }
            },
            complete: function () {
                triggerTimeCard($this);     
            }
        });
    }
    function generateHyperlink($this, ajaxdata) {
        var $parent = $this.closest('#openai-content-generator');
        var $working = $parent.find('.momo-be-working');
        var $msgBox = $parent.find('#momo_be_mb_openai_messagebox');
        var $contentBox = $parent.find('#momo_be_mb_generated_content');
        ajaxdata.action = 'momo_acg_openai_generate_remaining_synchronously_fe';
        ajaxdata.security = momoacgcs_fe.momoacgcs_ajax_nonce;
        ajaxdata.stage = 'hyperlink';
        ajaxdata.content = $contentBox.val();
        if ('off' === ajaxdata.addhyperlink) {
            generateImage($this, ajaxdata);
            return;
        }
        $.ajax({
            beforeSend: function () {
                var old = '';
                $working.addClass('show');
                old += $msgBox.html();
                $msgBox.html(old + '</br>' + '<b>' + momoacgcs_fe.mb_add_hyperlink + '</b>');
                $msgBox.show();
            },
            type: 'POST',
            dataType: 'json',
            url: momoacgcs_fe.ajaxurl,
            data: ajaxdata,
            success: function (data) {
                var old = '';
                if ('stop' === data.stage) {
                    old = $msgBox.html();
                    $working.removeClass('show');
                    $msgBox.html(old + '</br>' + data.msg);
                } else {
                    if (data.hasOwnProperty('status') && 'bad' === data.status) {
                        old = $msgBox.html();
                        $msgBox.html(old + '</br>' + data.msg);
                        $msgBox.show();
                    } else if (data.hasOwnProperty('status') && 'good' === data.status) {
                        var oldContent = $contentBox.val();
                        $contentBox.val(data.content);
                        old = $msgBox.html();
                        $msgBox.html(old + '</br>' + '&#x2022;  ' + data.msg);
                        $msgBox.show();
                    }
                    generateImage($this, ajaxdata);
                }
            },
            complete: function () {   
            }
        });
    }
    function generateConclusion($this, ajaxdata) {
        var $parent = $this.closest('#openai-content-generator');
        var $working = $parent.find('.momo-be-working');
        var $msgBox = $parent.find('#momo_be_mb_openai_messagebox');
        var $contentBox = $parent.find('#momo_be_mb_generated_content');
        ajaxdata.action = 'momo_acg_openai_generate_remaining_synchronously_fe';
        ajaxdata.security = momoacgcs_fe.momoacgcs_ajax_nonce;
        ajaxdata.stage = 'conclusion';
        if ('off' === ajaxdata.addconclusion) {
            generateHyperlink($this, ajaxdata);
            return;
        }
        $.ajax({
            beforeSend: function () {
                var old = '';
                $working.addClass('show');
                old += $msgBox.html();
                $msgBox.html(old + '</br>' + '<b>' + momoacgcs_fe.mb_add_conclusion + '</b>');
                $msgBox.show();
            },
            type: 'POST',
            dataType: 'json',
            url: momoacgcs_fe.ajaxurl,
            data: ajaxdata,
            success: function (data) {
                var old = '';
                if ('stop' === data.stage) {
                    old = $msgBox.html();
                    $working.removeClass('show');
                    $msgBox.html(old + '</br>' + data.msg);
                } else {
                    if (data.hasOwnProperty('status') && 'bad' === data.status) {
                        old = $msgBox.html();
                        $msgBox.html(old + '</br>' + data.msg);
                        $msgBox.show();
                    } else if (data.hasOwnProperty('status') && 'good' === data.status) {
                        var oldContent = $contentBox.val();
                        $contentBox.val(oldContent + data.content);
                        old = $msgBox.html();
                        $msgBox.html(old + '</br>' + '&#x2022;  ' + data.msg);
                        $msgBox.show();
                    }
                    generateHyperlink($this, ajaxdata);
                }
            },
            complete: function () {
            }
        });
    }
    function generateIntroduction($this, ajaxdata) {
        var $parent = $this.closest('#openai-content-generator');
        var $working = $parent.find('.momo-be-working');
        var $msgBox = $parent.find('#momo_be_mb_openai_messagebox');
        var $contentBox = $parent.find('#momo_be_mb_generated_content');
        ajaxdata.action = 'momo_acg_openai_generate_remaining_synchronously_fe';
        ajaxdata.security = momoacgcs_fe.momoacgcs_ajax_nonce;
        ajaxdata.stage = 'introduction';
        if ('off' === ajaxdata.addintroduction) {
            generateConclusion($this, ajaxdata);
            return;
        }
        $.ajax({
            beforeSend: function () {
                var old = '';
                $working.addClass('show');
                old += $msgBox.html();
                $msgBox.html(old + '</br>' + '<b>' + momoacgcs_fe.mb_add_introduction + '</b>');
                $msgBox.show();
            },
            type: 'POST',
            dataType: 'json',
            url: momoacgcs_fe.ajaxurl,
            data: ajaxdata,
            success: function (data) {
                var old = '';
                if ('stop' === data.stage) {
                    old = $msgBox.html();
                    $working.removeClass('show');
                    $msgBox.html(old + '</br>' + data.msg);
                } else {
                    if (data.hasOwnProperty('status') && 'bad' === data.status) {
                        old = $msgBox.html();
                        $msgBox.html(old + '</br>' + data.msg);
                        $msgBox.show();
                    } else if (data.hasOwnProperty('status') && 'good' === data.status) {
                        var oldContent = $contentBox.val();
                        $contentBox.val(data.content + oldContent);
                        old = $msgBox.html();
                        $msgBox.html(old + '</br>' + '&#x2022;  ' + data.msg);
                        $msgBox.show();
                    }
                    generateConclusion($this, ajaxdata);
                }
            },
            complete: function () {
            }
        });
    }
    function getMomoAcgContentFromHeadings($this, ajaxdata, stage) {
        var $parent = $this.closest('#openai-content-generator');
        var $working = $parent.find('.momo-be-working');
        var $msgBox = $parent.find('#momo_be_mb_openai_messagebox');
        var $contentBox = $parent.find('#momo_be_mb_generated_content');
        var $headings = ajaxdata.headings;
        var oldmsg = '';
        oldmsg = $msgBox.html();
        $msgBox.html(oldmsg + '</br>' + '<b>' + momoacgcs_fe.mb_add_content + '</b>');
        var xhrs = [];
        var count = 0;
        $contentBox.val('');
        $.each($headings, function (index, value) {console.log(index);console.log(value);
            ajaxdata.heading = value;
            ajaxdata.index = index;
            ajaxdata.security = momoacgcs_fe.momoacgcs_ajax_nonce;
            ajaxdata.action = 'momo_acg_openai_generate_contents_synchronously_fe';
            ajaxdata.stage = 'content';
            var xhr = $.ajax({
                beforeSend: function () {
                    $working.addClass('show');
                },
                type: 'POST',
                dataType: 'json',
                url: momoacgcs_fe.ajaxurl,
                data: ajaxdata,
                success: function (data) {
                    var oldMsg = '';
                    var old = '';
                    if (data.status === 'bad') {
                        oldMsg = $msgBox.html();
                        $msgBox.html(oldMsg + '</br>' + '&#x2022;  ' + data.msg);
                    } else if (data.status === 'good') {
                        count = count + 1;
                        old = $contentBox.val();
                        $contentBox.val(old + data.content);
                        oldMsg = $msgBox.html();
                        $msgBox.html(oldMsg + '</br>' + '&#x2022;  ' + data.msg);
                    }
                },
                complete: function () {
                }
            });
            xhrs.push(xhr);
        });
        $.when.apply($, xhrs).done(function () {
            var oldMsg = $msgBox.html();
            $msgBox.html(oldMsg + '</br><b>' + count + ' ' + momoacgcs_fe.completed_content_generation + '</b>').show();
            generateIntroduction($this, ajaxdata);
        });
    }
    function getMomoAcgHeadings($this, ajaxdata, stage) {
        var $parent = $this.closest('#openai-content-generator');
        var $working = $parent.find('.momo-be-working');
        var $msgBox = $parent.find('#momo_be_mb_openai_messagebox');
        var $contentBox = $parent.find('#momo_be_mb_generated_content');
        $msgBox.addClass('show');
        var $headingsBox = $parent.find('.momo-be-section-generated-headings').find('.momo-be-section-container');
        ajaxdata.stage = stage;
        if ('on' === ajaxdata.modifyheadings) {
            getMomoAcgContentFromHeadings($this, ajaxdata, 'content');
            return;
        }
        var msgbox = momoacgcs_fe['mb_add_' + stage];
        ajaxdata.action = 'momo_acg_openai_generate_headings_synchronously_fe';
        $.ajax({
            beforeSend: function () {
                $working.addClass('show');
                var oldMsgbox = $msgBox.html();
                if ('headings' === stage) {
                    $msgBox.html( oldMsgbox + '<b>' + msgbox + '</b>');
                }
            },
            type: 'POST',
            dataType: 'json',
            url: momoacgcs_fe.ajaxurl,
            data: ajaxdata,
            success: function (data) {
                var oldMsg = '';
                var old = '';
                if ('stop' === data.stage) {
                    old = $msgBox.html();
                    $working.removeClass('show');
                    $msgBox.html(old + '</br>' + data.msg);
                    return;
                }
                if (data.status === 'bad') {
                    oldMsg = $msgBox.html();
                    $msgBox.html(oldMsg + '</br>' + '&#x2022;  ' + data.msg);
                    triggerTimeCard($this);
                } else if (data.status === 'good') {
                    ajaxdata.headings = data.headings;
                    old = $contentBox.val();
                    $contentBox.val(old + data.hstring);
                    oldMsg = $msgBox.html();
                    $msgBox.html(oldMsg + '</br>' + '&#x2022;  ' + data.msg);
                    $headingsBox.html(data.content);
                    getMomoAcgContentFromHeadings($this, ajaxdata, 'content');
                }
            },
            complete: function() {
            }
        });
    }
    function toHoursAndMinutes(milliSeconds) {
        // Pad to 2 or 3 digits, default is 2
        function pad(n, z) {
            z = z || 2;
            return ('00' + n).slice(-z);
        }

        var ms = milliSeconds % 1000;
        milliSeconds = (milliSeconds - ms) / 1000;
        var secs = milliSeconds % 60;
        milliSeconds = (milliSeconds - secs) / 60;
        var mins = milliSeconds % 60;
        var hrs = (milliSeconds - mins) / 60;

        return pad(hrs) + ':' + pad(mins) + ':' + pad(secs);
    }
    function triggerTimeCard($this) {
        var $parent = $this.closest('#openai-content-generator');
        var $working = $parent.find('.momo-be-working');
        var $msgBox = $parent.find('#momo_be_mb_openai_messagebox');
        end = new Date().getTime();
        var totalTime = end - start;
        var oldMsg = $msgBox.html();
        $msgBox.html(oldMsg + '</br></br><b>' + ' ' + momoacgcs_fe.time_taken + toHoursAndMinutes(totalTime) + '</b>').show();

        var $saveDraft = $parent.find('#momo_be_mb_openai_draft_content');
        var $generatedContent = $parent.find('.momo-be-section-generated-content');
        var $generatedHeadings = $parent.find('.momo-be-section-generated-headings');
        $generatedContent.removeClass('momo-hidden').addClass('momo-show');
        $saveDraft.removeClass('momo-hidden').addClass('momo-show');
        $generatedHeadings.addClass('momo-hidden').removeClass('momo-show');
        $working.removeClass('show');
    }
    function momoAcgGetPageAjaxDataSync($parent) {
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

        var $textGenerationSettings = $parent.find('input[name="momo_be_mb_text_generation_settings"]');
        var temperature = $parent.find('input[name="momo_be_mb_temperature"]').val();
        var maximumTokens = $parent.find('input[name="momo_be_mb_max_tokens"]').val();
        var topP = $parent.find('input[name="momo_be_mb_top_p"]').val();
        var frequencyPenalty = $parent.find('input[name="momo_be_mb_frequency_penalty"]').val();
        var presencePenalty = $parent.find('input[name="momo_be_mb_presence_penalty"]').val();

        var imageSize = $parent.find('select[name="momo_be_mb_image_size"]').val();
        
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
        ajaxdata.image_size = imageSize;

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
        if ($textGenerationSettings.is(":checked")) {
            ajaxdata.tg_settings = 'on';
        } else {
            ajaxdata.tg_settings = 'off';
        }
        ajaxdata.temperature = temperature;
        ajaxdata.max_tokens = maximumTokens;
        ajaxdata.top_p = topP;
        ajaxdata.frequency_penalty = frequencyPenalty;
        ajaxdata.presence_penalty = presencePenalty;

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
        return ajaxdata;
    }
    function momoCheckTokens($working, ajaxdata, $this, $msgBox) {
        var $parent = $this.closest('#openai-content-generator');
        var $btmMsgBox = $parent.find('#momo-fe-cg-msgbox');
        var ajaxdatas = {};
        ajaxdatas.action = 'momo_acg_cs_check_user_tokens';
        var url = $parent.data('url');
        ajaxdatas.url = url;
        ajaxdatas.security = momoacgcs_fe.momoacgcs_ajax_nonce;
        var returnData;
        $.ajax({
            beforeSend: function () {
                $working.addClass('show');
            },
            type: 'POST',
            dataType: 'json',
            url: momoacgcs_fe.ajaxurl,
            data: ajaxdatas,
            success: function (data) {console.log(data);
                 if ('good' === data.status) {
                    $msgBox.addClass('show');
                    $btmMsgBox.html(data.msg);
                    $btmMsgBox.addClass('show');
                    getMomoAcgHeadings($this, ajaxdata, 'headings');
                 } else if('bad' === data.status) {
                    $btmMsgBox.html(data.msg);
                    $btmMsgBox.addClass('show');
                    $working.removeClass('show');
                 }
            },
            complete: function() {
            }
        });
        return returnData;
    }
    $('body').on('click', '#momo_be_mb_openai_generate_content', function (e) {
        e.preventDefault();
        var $parent = $(this).closest('#openai-content-generator');
        var $working = $parent.find('.momo-be-working');
        var $msgBox = $parent.find('#momo_be_mb_openai_messagebox');
        $msgBox.html('');
        $msgBox.removeClass('warning');
        $msgBox.removeClass('success');
        
        var ajaxdata = {};
        ajaxdata = momoAcgGetPageAjaxDataSync( $parent );

        var $saveDraft = $parent.find('#momo_be_mb_openai_draft_content');
        var $generatedContent = $parent.find('.momo-be-section-generated-content');
        var $generatedHeadings = $parent.find('.momo-be-section-generated-headings');
        $generatedContent.removeClass('momo-hidden').addClass('momo-show');
        $saveDraft.removeClass('momo-hidden').addClass('momo-show');
        $generatedHeadings.addClass('momo-hidden').removeClass('momo-show');

        
        ajaxdata.security = momoacgcs_fe.momoacgcs_ajax_nonce;
        ajaxdata.action = 'momo_acg_openai_generate_contents_synchronously_fe';
        start = new Date().getTime();

        momoCheckTokens($working, ajaxdata, $(this), $msgBox);
    });
});
