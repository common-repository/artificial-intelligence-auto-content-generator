/*global jQuery*/
/*global define */
/*global window */
/*global this*/
/*global location*/
/*global document*/
/*global momoacg_admin*/
/*global momoacg_bulkcw_admin*/
/*global console*/
/*jslint this*/
/**
 * momowsw Admin Script
 */
jQuery(document).ready(function ($) {
    "use strict";
    $('body').on('momo_acg_datepicker', function () {
        $('.momo_jquery_date_selector').datepicker({
            minDate: 1
        });
    });
    $('body').trigger('momo_acg_datepicker');
    $('body').on('click', '.momo_bulkcw_add_new_title_row', function () {
        var $parent = $(this).closest('.momo-be-main-tabcontent');
        var $container = $parent.find('.momobulkcw-editor-main');
        var $msgBox = $container.find('.momo-be-msg-block');
        var $working = $parent.find('.momo-be-working');
        var $tbody = $container.find('table.momo-acg-bulkcw-titles-table').find('tbody');
        var ajaxdata = {};
        var rowcount = $tbody.data('row_count');
        ajaxdata.rowcount = rowcount;
        ajaxdata.security = momoacg_admin.momoacg_ajax_nonce;
        ajaxdata.action = 'momo_acg_bulkcw_add_new_title_row';
        $.ajax({
            beforeSend: function () {
                $working.addClass('show');
                $msgBox.html(momoacg_bulkcw_admin.generating_row);
                $msgBox.show();
            },
            type: 'POST',
            dataType: 'json',
            url: momoacg_admin.ajaxurl,
            data: ajaxdata,
            success: function (data) {
                if (data.status === 'bad') {
                    $msgBox.html(data.msg);
                    $msgBox.show();
                } else if ('good' === data.status) {
                    $msgBox.html(data.msg);
                    $msgBox.show();
                    $tbody.append(data.content);
                    $tbody.data('row_count', data.count);
                    $('.momo_jquery_date_selector').datepicker({
                        minDate: 1
                    });
                }
            },
            complete: function () {
                $working.removeClass('show');
            }
        });
    });
    $('body').on('click', '.momo_bulkcw_generate_bulk_content', function () {
        var $parent = $(this).closest('.momo-be-main-tabcontent');
        var $container = $parent.find('.momobulkcw-editor-main');
        var $msgBox = $container.find('.momo-be-msg-block');
        var $working = $parent.find('.momo-be-working');
        var $tbody = $container.find('table.momo-acg-bulkcw-titles-table').find('tbody');
        var $postType = $container.find('input[name="momo_bulkcw_post_type"]:checked');
        var ajaxdata = {};
        var postData = [];
        ajaxdata.security = momoacg_admin.momoacg_ajax_nonce;
        ajaxdata.action = 'momo_acg_bulkcw_queue_titles_to_generate';
        $tbody.find('tr').each(function (index, tr) {
            var formValues = {};
            var title = $(tr).find('input[name="momo_bulkcw_title_text"').val();
            var date = $(tr).find('input[name="momo_bulkcw_select_date"').val();
            var $image = $(tr).find('input[name="momo_bulkcw_enable_image"');
            var noofpara = $(tr).find('select[name="momo_bulkcw_noofpara"').val();
            var category = $(tr).find('select[name="momo_bulkcw_category"').val();
            var ptype = $postType.val();
            var addimage = 'off';
            if ($image.is(":checked")) {
                addimage = 'on';
            } else {
                addimage = 'off';
            }
            formValues.title = title;
            formValues.date = date;
            formValues.noofpara = noofpara;
            formValues.category = category;
            formValues.ptype = ptype;
            formValues.addimage = addimage;
            postData.push(formValues);
            $(tr).remove();
        });
        ajaxdata.post_data = postData;
        $.ajax({
            beforeSend: function () {
                $working.addClass('show');
                $msgBox.html(momoacg_bulkcw_admin.queueing_titles);
                $msgBox.show();
            },
            type: 'POST',
            dataType: 'json',
            url: momoacg_admin.ajaxurl,
            data: ajaxdata,
            success: function (data) {
                if (data.status === 'bad') {
                    $msgBox.html(data.msg);
                    $msgBox.show();
                } else if ('good' === data.status) {
                    $msgBox.html(data.msg);
                    $msgBox.show();
                }
            },
            complete: function () {
                $working.removeClass('show');
            }
        });
    });
    $('body').on('click', 'i.momo-bulkcw-remove-cron', function () {
        var $td = $(this).closest('td');
        var $holder = $td.find('span.momo-remove-holder');
        var $tr = $td.closest('tr');
        var $parent = $(this).closest('.momo-be-main-tabcontent');
        var $container = $parent.find('.momobulkcw-editor-main');
        var $msgBox = $container.find('.momo-be-msg-block');
        var cid = $td.data('id');
        var ajaxdata = {};
        ajaxdata.security = momoacg_admin.momoacg_ajax_nonce;
        ajaxdata.action = 'momo_acg_bulkcw_delete_cron_by_id';
        ajaxdata.cron_id = cid;
        $.ajax({
            beforeSend: function () {
                $holder.addClass('td-working');
            },
            type: 'POST',
            dataType: 'json',
            url: momoacg_admin.ajaxurl,
            data: ajaxdata,
            success: function (data) {
                if (data.status === 'bad') {
                    $msgBox.html(data.msg);
                    $msgBox.show();
                } else if ('good' === data.status) {
                    $tr.remove();
                    $msgBox.html(data.msg);
                    $msgBox.show();
                }
            },
            complete: function () {
                $holder.removeClass('td-working');
            }
        });
    });
});