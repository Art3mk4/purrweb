var DateRangeFilterElement = (function() {
    var dateRangeFilterElement = function(dateElement) {
        this.dateElement = dateElement;
    };
    dateRangeFilterElement.prototype.show = function(containerEl) {
        containerEl.prepend(this.dateElement);
        this.dateElement.css('display', 'inline-block');
        this.dateElement.parent().css('display', 'inline-block');
        this.dateElement.find('#f-dateStart').datepicker();
        this.dateElement.find('#f-dateEnd').datepicker();
    };
    dateRangeFilterElement.prototype.hide = function(hiddenContainerEl) {
        hiddenContainerEl.prepend(this.dateElement);
        this.dateElement.hide();
        this.dateElement.parent().hide();
        this.dateElement.find('input').val('');
    };
    dateRangeFilterElement.prototype.loadFromSave = function(container) {
        var dateStart = container.find('.hidden__startDate').val(),
            dateEnd = container.find('.hidden__endDate').val();
        this.dateElement.find('#f-dateStart').val(dateStart);
        this.dateElement.find('#f-dateEnd').val(dateEnd);
    };
    return dateRangeFilterElement;
})();
