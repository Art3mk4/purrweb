var TextFilterElement = (function() {
    var textFilterElement = function(textElement) {
        this.textElement = textElement;
    };
    textFilterElement.prototype.show = function(containerEl) {
        containerEl.prepend(this.textElement);
        this.textElement.css('display', 'inline-block');
        this.textElement.parent().css('display', 'inline-block');
    };
    textFilterElement.prototype.hide = function(hiddenContainerEl) {
        hiddenContainerEl.prepend(this.textElement);
        this.textElement.hide();
        this.textElement.parent().hide();
        this.textElement.find('input').val('');
    };
    textFilterElement.prototype.loadFromSave = function(container) {
        var textVal = container.find('input').val();
        this.textElement.find('input').val(textVal);
    };
    return textFilterElement;
})();
