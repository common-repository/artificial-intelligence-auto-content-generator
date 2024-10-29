/*global jQuery*/
/*global define */
/*global window */
/*global this*/
/*global location*/
/*global document*/
/*global momoacg_chatbot*/
/*global momo_forms_script*/
/*global console*/
/*jslint this*/
/**
 * ACG chatbot Script
 */
jQuery(document).ready(function ($) {
    'use strict';
    $('body').on('click', '#momo-generate-output-from-form', function () {
        var formElements = [];
        var submit = $(this).data('value');
        var prompt = $(this).data('prompt');
        var $form = $(this).closest('.momo-acg-ai-form-container');
        var $working = $form.find('.momo-form-working');
        var $result = $form.find('.momo-forms-result-block');
        $result.html('');
        // Iterate over each form element
        $form.find('.momo-form-element-block').each(function () {
            var $container = $(this);
            var type = $container.data('type');
            var label, $element, ename, value;
            switch (type) {
            case 'text':
                $element = $container.find('input');
                label = $element.data('label');
                ename = $element.attr('name');
                value = $element.val();
                break;
            case 'textarea':
                $element = $container.find('textarea');
                label = $element.data('label');
                ename = $element.attr('name');
                value = $element.val();
                break;
            case 'select':
                $element = $container.find('select');
                label = $element.data('label');
                ename = $element.attr('name');
                value = $element.val();
                break;
            case 'radio':
                $element = $container.find('input');
                label = $element.data('label');
                ename = $element.attr('name');
                value = $container.find('input[type="radio"]:checked').val();
                break;
            case 'checkbox':
                $element = $container.find('input');
                label = $element.data('label');
                ename = $element.attr('name');

                var checkboxValues = [];
                $container.find('input[type="checkbox"]:checked').each(function () {
                    checkboxValues.push($(this).val());
                });
                value = checkboxValues.join(',');
                break;
            }

            // Create an object with label and value
            var element = {
                label: label,
                value: value,
                name: ename
            };

            formElements.push(element); // Add the element to the array
        });

        var ajaxdata = {};
        ajaxdata.submit = submit;
        ajaxdata.prompt = prompt;
        ajaxdata.forms = formElements;
        ajaxdata.security = momo_forms_script.momoacgforms_ajax_nonce;
        $.ajax({
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-WP-Nonce', momo_forms_script.momoacgforms_ajax_nonce);
                $working.addClass('show');
                $result.removeClass('show');
            },
            type: 'POST',
            dataType: 'json',
            url: momo_forms_script.rest_endpoint,
            data: ajaxdata,
            success: function (data) {
                $result.html(data.message);
                $result.addClass('show');
            },
            complete: function () {
                $working.removeClass('show');
            }
        });
    });
});