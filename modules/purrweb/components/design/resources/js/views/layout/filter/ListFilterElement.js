var ListFilterElement = (function() {
    var listFilterElement = function(listElement) {
        this.listElement = listElement;
    };
    listFilterElement.prototype.show = function(containerEl) {
        containerEl.prepend(this.listElement);
        this.listElement.css('display', 'inline-block');
        this.listElement.parent().css('display', 'inline-block');
    };
    listFilterElement.prototype.hide = function(hiddenContainerEl) {
        hiddenContainerEl.prepend(this.listElement);
        this.listElement.hide();
        this.listElement.parent().hide();
    };
    listFilterElement.prototype.loadFromSave = function(container) {
        var listVal = container.find('input').val();
        this.listElement.find('select option:selected').removeAttr('selected');
        this.listElement.find('select option[value='+ listVal +']').attr('selected', 'selected');
        this.listElement.find('select option:selected').trigger("chosen:updated");
    };
    return listFilterElement;
})();
