var FlagFilterElement = (function() {
    var flagFilterElement = function(flagElement) {
        this.flagElement = flagElement;
    };
    flagFilterElement.prototype.show = function(containerEl) {
        
        containerEl.prepend(this.flagElement);
        this.flagElement.css('display', 'inline-block');
        this.flagElement.parent().css('display', 'inline-block');
    };
    flagFilterElement.prototype.hide = function(hiddenContainerEl) {
        hiddenContainerEl.prepend(this.flagElement);
        this.flagElement.hide();
        this.flagElement.parent().hide();
        this.flagElement.find('select').empty();
    };
    flagFilterElement.prototype.loadFromSave = function(container) {
        var flagVal = container.find('input').val();
        this.flagElement.find('select option:selected').removeAttr('selected');
        this.flagElement.find('select option[value='+ flagVal +']').attr('selected', 'selected');
        this.flagElement.find('select option:selected').trigger("chosen:updated");
    };
    return flagFilterElement;
})();
