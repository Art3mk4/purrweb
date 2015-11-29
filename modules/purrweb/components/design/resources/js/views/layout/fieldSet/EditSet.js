
jQuery(document).ready(function() {

    var EditSet = function(option) {
        var $form = jQuery(option.form),
            that = this;

        this.init = function() {
            bindEvents();

            _setDatePickerDefaults();
            $('.f-fieldSetDate').datepicker({
                showOn: "both",
                buttonImage: $('meta[name=design_asset_url]').attr('content') + "/i/date_cal.png",
                buttonImageOnly: true
            });
        };
        var bindEvents = function() {
        };
        var _setDatePickerDefaults = function() {
            $.datepicker.regional['ru'] = {
                closeText: 'Закрыть',
                prevText: '&#x3c;Пред',
                nextText: 'След&#x3e;',
                currentText: 'Сегодня',
                monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
                    'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
                monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
                    'Июл','Авг','Сен','Окт','Ноя','Дек'],
                dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
                dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
                dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
                weekHeader: 'Нед',
                dateFormat: 'dd.mm.yy',
                firstDay: 1,
                isRTL: false,
                showOtherMonths: true,
                yearSuffix: ''
            };
            $.datepicker.setDefaults($.datepicker.regional['ru']);
        };

        this.init();
    };

    var editSet = new EditSet({
        form: '#viewFieldSetContainer'
    });

});
