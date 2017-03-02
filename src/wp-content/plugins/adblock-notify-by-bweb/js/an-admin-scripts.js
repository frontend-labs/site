/*jshint scripturl:true*/
/*global anWidgetOptions */
/*global Chart */
/*global an_admin */

/*

 an_admin_scripts.js
 AdBlock Notify
 Copyright: (c) 2016 Themeisle, themeisle.com
 */
jQuery(document).ready(function ($) {

    $('.adblock-notify-options input[name="adblocker_notify_an_option_modal_template"]').each(function (i) {

        var th = jQuery(this);
        if (an_admin.pro !== 'yes') {
            if (i > 0) {
                th.attr('disabled', 'disabled').parent().addClass('template-disabled');
                th.parent().append('<a href="' + an_admin.pro_url + '" title="Buy Adblock Notify PRO" target="_blank" class="pro-badge">Only Pro</a>');
            }
        }

        th.parent().css('display', 'inline-block');
    });
    if (an_admin.pro !== 'yes') {
        if($('#an-only-pro-area').length === 0){
          $('#advanced-options').append('<a id="an-only-pro-area" href="' + an_admin.pro_url + '" title="Buy Adblock Notify PRO" target="_blank" class="pro-badge">Only Pro</a>');
        }
        $('#adblocker_notify_an_option_modal_after_pages, #adblocker_notify_an_option_modal_width').parent().find('.number-slider').off();
        $('#adblocker_notify_an_option_modal_after_pages, #adblocker_notify_an_option_modal_width').parent().css({'cursor': 'not-allowed'});
    }
    $('#adblocker_notify_an_option_modal_after_pages, #adblocker_notify_an_option_modal_width').show();
    if ($('.an-stats-table').length > 0) {

        //Widget
        var DataTotal = [
            {
                value: anWidgetOptions.totalNoBlocker,
                color: '#34495e',
                highlight: '#36526F'
            },
            {
                value: anWidgetOptions.anCountBlocked,
                color: '#e74c3c',
                highlight: '#F44938'
            }
        ];
        var DataToday = [
            {
                value: anWidgetOptions.totalNoBlockerToday,
                color: '#34495e',
                highlight: '#36526F'
            },
            {
                value: anWidgetOptions.anCountBlockedHistory,
                color: '#e74c3c',
                highlight: '#F44938'
            }
        ];

        var lineChartData = {
            labels: ['Today', 'Day -1', 'Day -2', 'Day -3', 'Day -4', 'Day -5', 'Day -6'],
            datasets: [
                {
                    fillColor: 'rgba(50, 82, 110,0.2)',
                    strokeColor: 'rgba(50, 82, 110,0.8)',
                    pointColor: 'rgba(50, 82, 110,1)',
                    pointStrokeColor: 'rgba(50, 82, 110,1)',
                    pointHighlightFill: 'rgba(250,250,250,1)',
                    pointHighlightStroke: 'rgba(50, 82, 110,1)',
                    data: anWidgetOptions.anDataHistotyTotal
                },
                {
                    fillColor: 'rgba(231, 76, 60,0.2)',
                    strokeColor: 'rgba(173, 52, 40,0.8)',
                    pointColor: 'rgba(231, 76, 60, 1)',
                    pointStrokeColor: 'rgba(231, 76, 60, 1)',
                    pointHighlightFill: 'rgba(250,250,250,0.8)',
                    pointHighlightStroke: 'rgba(173, 52, 40,0.8)',
                    data: anWidgetOptions.anDataHistotyBlocked
                }
            ]
        };
        //Load the charts
        new Chart(document.getElementById('an-canvas-donut').getContext('2d')).Doughnut(DataTotal, {
            segmentStrokeColor: '#fafafa',
            tooltipFontSize: 12,
            responsive: true
        });
        new Chart(document.getElementById('an-canvas-donut-today').getContext('2d')).Doughnut(DataToday, {
            segmentStrokeColor: '#fafafa',
            tooltipFontSize: 12,
            responsive: true
        });
        new Chart(document.getElementById('an-canvas-line').getContext('2d')).Line(lineChartData, {
            tooltipFontSize: 12,
            tooltipTitleFontSize: 12,
            scaleFontSize: 10,
            responsive: true,
        });

        //Admin page
        var resetButton = $('p.submit button.button-secondary[value!="save"]');
        var resetButtonVal = resetButton.attr('onclick');
        resetButton.attr('onclick', 'javascript:if(!confirm(\'Are you sure ? Your custom settings will be lost.\')) return false; ' + resetButtonVal);

    }

});