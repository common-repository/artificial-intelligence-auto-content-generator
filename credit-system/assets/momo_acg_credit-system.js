/*global jQuery*/
/*global define */
/*global window */
/*global this*/
/*global location*/
/*global document*/
/*global momoacg_admin*/
/*global momoacg_credit_system_admin*/
/*global console*/
/*jslint this*/
/**
 * momowsw Admin Script
 */
jQuery(document).ready(function ($) {
    "use strict";
    $('body').on('click', '.momo-cs-add-plan-btn', function () {
        var $parent = $(this).closest('.momo-be-main-tabcontent');
        var $form = $parent.find('.momo-cs-plan-form');
        $form.find('input[name="plan_title"]').val('');
        $form.find('input[name="plan_price"]').val('');
        $form.find('input[name="plan_tokens"]').val('');
        var $msgBox = $form.find('.momo-cs-messagebox');
        $msgBox.removeClass('show').html('');
        $(this).addClass('momo-hidden').removeClass('momo-show');
        $form.addClass('momo-show').removeClass('momo-hidden');
    });
    $('body').on('click', '.momo-cs-cancel-new-plan', function () {
        var $parent = $(this).closest('.momo-be-main-tabcontent');
        var $form = $parent.find('.momo-cs-plan-form');
        var $addBtn = $parent.find('.momo-cs-add-plan-btn');
        $form.addClass('momo-hidden').removeClass('momo-show');
        $addBtn.addClass('momo-show').removeClass('momo-hidden');
    });
    $('body').on('click', '.momo-cs-create-new-plan', function () {
        var $parent = $(this).closest('.momo-be-main-tabcontent');
        var $form = $parent.find('.momo-cs-plan-form');
        var $msgBox = $form.find('.momo-cs-messagebox');
        $msgBox.removeClass('show').html('');
        var $mainMsgBox = $parent.find('.momo-be-msg-block');
        $mainMsgBox.removeClass('show').html('');
        var $working = $parent.find('.momo-be-working');
        $msgBox.html('');
        var title = $form.find('input[name="plan_title"]').val();
        var price = $form.find('input[name="plan_price"]').val();
        var tokens = $form.find('input[name="plan_tokens"]').val();
        if ('' === title || '' === price || '' === tokens) {
            $msgBox.html(momoacg_credit_system_admin.empty_input_fields);
            $msgBox.addClass('show');
            return;
        }
        var $table = $parent.find('.momo-be-current-plan-table');
        var $addBtn = $parent.find('.momo-cs-add-plan-btn');
        var ajaxdata = {};
        ajaxdata.security = momoacg_admin.momoacg_ajax_nonce;
        ajaxdata.action = 'momo_acg_cs_create_new_plan';
        ajaxdata.title = title;
        ajaxdata.price = price;
        ajaxdata.tokens = tokens;
        $.ajax({
            beforeSend: function () {
                $working.addClass('show');
                $form.removeClass('momo-show').addClass('momo-hidden');
            },
            type: 'POST',
            dataType: 'json',
            url: momoacg_admin.ajaxurl,
            data: ajaxdata,
            success: function (data) {
                if (data.status === 'bad') {
                    $msgBox.html(data.msg);
                } else if ('good' === data.status) {
                    $table.find('tbody').html(data.content);
                    $msgBox.html(data.msg);
                }
            },
            complete: function () {
                $working.removeClass('show');
                $addBtn.addClass('momo-show').removeClass('momo-hidden');
            }
        });
    });
    $('body').on('click', '.momo-cs-edit-cancel-plan', function () {
        var $parent = $(this).closest('.momo-be-main-tabcontent');
        var $editSection = $parent.find('.momo-be-cs-edit-secton');
        var $nonEditSection = $parent.find('.momo-be-cs-nonedit-secton');
        $editSection.addClass('momo-hidden').removeClass('momo-show');
        $nonEditSection.addClass('momo-show').removeClass('momo-hidden');
    });
    $('body').on('click', '.momo-cs-plan-edit', function () {
        var $parent = $(this).closest('.momo-be-main-tabcontent');
        var $msgBox = $parent.find('.momo-be-msg-block');
        $msgBox.removeClass('show').html('');
        var $working = $parent.find('.momo-be-working');
        var $editSection = $parent.find('.momo-be-cs-edit-secton');
        var $nonEditSection = $parent.find('.momo-be-cs-nonedit-secton');
        var $tr = $(this).closest('tr');
        var plan_id = $tr.data('plan_id');
        var ajaxdata = {};
        ajaxdata.security = momoacg_admin.momoacg_ajax_nonce;
        ajaxdata.action = 'momo_acg_cs_access_old_plan';
        ajaxdata.plan_id = plan_id;
        $.ajax({
            beforeSend: function () {
                $working.addClass('show');
                $nonEditSection.removeClass('momo-show').addClass('momo-hidden');
            },
            type: 'POST',
            dataType: 'json',
            url: momoacg_admin.ajaxurl,
            data: ajaxdata,
            success: function (data) {
                if (data.status === 'bad') {
                    $msgBox.html(data.msg);
                    $nonEditSection.removeClass('momo-hidden').addClass('momo-show');
                } else if ('good' === data.status) {
                    $editSection.removeClass('momo-hidden').addClass('momo-show');
                    var $form = $editSection.find('.momo-cs-plan-edit-form');
                    $form.find('input[name="edit_plan_title"]').val(data.title);
                    $form.find('input[name="edit_plan_price"]').val(data.price);
                    $form.find('input[name="edit_plan_tokens"]').val(data.tokens);
                    $form.find('input[name="edit_plan_id"]').val(data.plan_id);
                    $msgBox.html(data.msg);
                }
            },
            complete: function () {
                $working.removeClass('show');
            }
        });
    });
    $('body').on('click', '.momo-cs-update-old-plan', function () {
        var $parent = $(this).closest('.momo-be-main-tabcontent');
        var $form = $parent.find('.momo-cs-plan-edit-form');
        var $msgBox = $form.find('.momo-cs-messagebox');
        $msgBox.removeClass('show').html('');
        var $working = $parent.find('.momo-be-working');
        $msgBox.html('');
        var title = $form.find('input[name="edit_plan_title"]').val();
        var price = $form.find('input[name="edit_plan_price"]').val();
        var tokens = $form.find('input[name="edit_plan_tokens"]').val();
        var plan_id = $form.find('input[name="edit_plan_id"]').val();
        if ('' === title || '' === price || '' === tokens) {
            $msgBox.html(momoacg_credit_system_admin.empty_input_fields);
            $msgBox.addClass('show');
            return;
        }
        var $table = $parent.find('.momo-be-current-plan-table');
        var $editSection = $parent.find('.momo-be-cs-edit-secton');
        var $nonEditSection = $parent.find('.momo-be-cs-nonedit-secton');
        var ajaxdata = {};
        ajaxdata.security = momoacg_admin.momoacg_ajax_nonce;
        ajaxdata.action = 'momo_acg_cs_update_old_plan';
        ajaxdata.title = title;
        ajaxdata.price = price;
        ajaxdata.tokens = tokens;
        ajaxdata.plan_id = plan_id;
        $.ajax({
            beforeSend: function () {
                $working.addClass('show');
                $editSection.removeClass('momo-show').addClass('momo-hidden');
            },
            type: 'POST',
            dataType: 'json',
            url: momoacg_admin.ajaxurl,
            data: ajaxdata,
            success: function (data) {
                if (data.status === 'bad') {
                    $msgBox.html(data.msg);
                } else if ('good' === data.status) {
                    $table.find('tbody').html(data.content);
                    $msgBox.html(data.msg);
                }
            },
            complete: function () {
                $working.removeClass('show');
                $nonEditSection.addClass('momo-show').removeClass('momo-hidden');
            }
        });
    });
    $('body').on('click', '.momo-cs-plan-delete', function ()  {
        var result = confirm(momoacg_credit_system_admin.confirm_delete);
        if (result) {
            var $parent = $(this).closest('.momo-be-main-tabcontent');
            var $msgBox = $parent.find('.momo-be-msg-block');
            $msgBox.removeClass('show').html('');
            var $working = $parent.find('.momo-be-working');
            var $nonEditSection = $parent.find('.momo-be-cs-nonedit-secton');
            var $tr = $(this).closest('tr');
            var plan_id = $tr.data('plan_id');
            var ajaxdata = {};
            ajaxdata.security = momoacg_admin.momoacg_ajax_nonce;
            ajaxdata.action = 'momo_acg_cs_delete_old_plan';
            ajaxdata.plan_id = plan_id;
            $.ajax({
                beforeSend: function () {
                    $working.addClass('show');
                    $nonEditSection.removeClass('momo-show').addClass('momo-hidden');
                },
                type: 'POST',
                dataType: 'json',
                url: momoacg_admin.ajaxurl,
                data: ajaxdata,
                success: function (data) {
                    if (data.status === 'bad') {
                        $msgBox.html(data.msg);
                    } else if ('good' === data.status) {
                        var $table = $parent.find('.momo-be-current-plan-table');
                        $table.find('tbody').html(data.content);
                        $msgBox.html(data.msg);
                    }
                },
                complete: function () {
                    $nonEditSection.removeClass('momo-hidden').addClass('momo-show');
                    $working.removeClass('show');
                    $msgBox.addClass('show');
                }
            });
        }
    });
});