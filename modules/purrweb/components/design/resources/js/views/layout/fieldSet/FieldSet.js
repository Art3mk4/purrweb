
jQuery(document).ready(function() {

    var FieldSet = function() {
        var $fieldSetTitle = jQuery('.viewFieldSet__title'),
            that = this;

        this.init = function() {
            bindEvents();
        };
        var bindEvents = function() {
            $fieldSetTitle.on('click', showData);
        };
        var showData = function(event) {
            var currentTitle = jQuery(event.target),
                dataList = currentTitle.parent().find('.viewFieldSet__content');
                
            if (dataList.css('display') == 'none') {
                that.showContent(currentTitle, dataList);
            } else {
                that.hideContent(currentTitle, dataList);
            }
        };
        this.showContent = function(currentTitle, dataList) {
            currentTitle.addClass('m-openViewFieldSet');
            dataList.addClass('viewFieldSet__enabled');
        };
        this.hideContent = function(currentTitle, dataList) {
            currentTitle.removeClass('m-openViewFieldSet');
            dataList.removeClass('viewFieldSet__enabled');
        };  
        this.init();
    };

    var fieldSet = new FieldSet({});

});