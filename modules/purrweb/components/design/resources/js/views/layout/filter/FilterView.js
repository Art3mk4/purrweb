
jQuery(document).ready(function() {


    var FilterView = (function () {
        var filter = function(filterContainer) {
            _.bindAll(this);

            this.initPlugins();

            this.filterElement = null;
            this.filterLink                  = filterContainer.find('.filter__link');
            this.filterList                  = filterContainer.find('.action__list');
            this.filterForm                  = filterContainer.find('.filterForm');
            this.filterTypeList              = filterContainer.find('.filterForm').find('.typeListContainer');
            this.filterFormContainerElements = filterContainer.find('.filterForm').find('.filterForm__containerElements');
            this.hiddenFilterElements        = filterContainer.find('.m-hiddenFilterElements');
            this.addFilterLink               = filterContainer.find('.addFilter__link');
            this.deleteFilterBtn             = filterContainer.find('.deleteFilterKey');
            this.deleteFilterText            = filterContainer.find('.i-deleteFilter');
            this.filterValueSaveText         = filterContainer.find('.filterValue__saveText');

            this.filterLink.on('click', this.processShowList);
            this.addFilterLink.on('click', this.show);
            this.filterTypeList.on('change', this.changeElement);

            this.deleteFilterBtn.on('click', this.hide);
            this.deleteFilterText.on('click', this.processDeleteFilterText);
            this.filterValueSaveText.on('click', this.processEditCondition);

            jQuery(document).click(this.clickOutSideList);
        };
        filter.prototype.initPlugins = function() {
            this._showDatePicker();
            jQuery('#f-filterTypeList, #f-filterKeyList, #f-filterFlagList').chosen({
                disable_search: true
            });
            
        };
        filter.prototype.processShowList = function(e) {
            var currentLink = jQuery(e.target),
                dataList = currentLink.parent().find('.action__list');
                
            if (dataList.css('display') == 'none') {
                dataList.show();
            } else {
                dataList.hide();
            }
            return false;
        };
        filter.prototype._showDatePicker = function() {
            this._setDatePickerDefaults();
        };
        filter.prototype.show = function(e) {
            e.preventDefault();
            var currentLink = jQuery(e.target);
            currentLink.parents('.action__list').hide();
            this.filterTypeList.css('display', 'inline-block');

        };
        filter.prototype.changeElement = function(e) {
            var filterElementId = jQuery(e.target).find('option:selected').val();
            this.showFilterElement(filterElementId);  
        };
        filter.prototype.showFilterElement = function(filterElementId) {
            if (this.filterElement) {
                this.filterElement.hide(this.hiddenFilterElements);
            }
            this.filterElement = FilterElement.create(this.hiddenFilterElements, filterElementId);
            this.filterElement.show(this.filterFormContainerElements);
        };
        filter.prototype.hide = function(e) {
            e.preventDefault();
            this.filterTypeList.hide();
            this.filterFormContainerElements.hide();
            this.filterElement.hide(this.hiddenFilterElements);
        };
        filter.prototype.processDeleteFilterText = function(e) {
            jQuery(e.target).parent().remove();
            this.filterForm.submit();  
        };
        filter.prototype.processEditCondition = function(e) {
            var listId = jQuery(e.target).parent().data('id'),
                containter = jQuery(e.target).parent();

            el = FilterElement.create(this.hiddenFilterElements, listId);
            el.loadFromSave(containter); 

            containter.remove();                                
            this.selectValue(listId);
        };
        filter.prototype.selectValue = function(listId) {
            this.filterTypeList.css('display', 'inline-block');
            this.filterTypeList.find('select option:selected').removeAttr('selected');
            this.filterTypeList.find('select option[value='+ listId +']').attr('selected', 'selected');

            this.filterTypeList.find('select option:selected').trigger("chosen:updated");
            this.filterTypeList.trigger('change');
        };
        filter.prototype.clickOutSideList = function(e) {            
            if ($(event.target).closest(jQuery('.filter')).length) return;
            this.filterList.hide();
            this.filterTypeList.hide();
            e.stopPropagation();
        };
        filter.prototype._setDatePickerDefaults = function() {
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
        return filter;
    })();

    var FilterElement = {
        types: {
            'text': TextFilterElement,
            'dateRange': DateRangeFilterElement,
            'flag': FlagFilterElement,
            'list': ListFilterElement
        },
        filterContainer: null,
        create: function(filterContainer, filterElementId) {
            var el = filterContainer.find('.filterForm__col[data-id='+ filterElementId +']'),
                type = el.data('type'), elementClass;

            this.filterContainer = filterContainer;

            if (this.types.hasOwnProperty(type)) {
                elementClass = this.types[type];
                return new elementClass(el);    
                
            }

            throw "Неверный тип фильтр элемента";
        }
    };

    jQuery('.filter').each(function(index, el) {
        var filter = new FilterView($(el));  
    });
    
});
