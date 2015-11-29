jQuery(document).ready(function() {
    var ChangeDataFromList = function() {
        var $link = jQuery('.a-changeFromList'),
            $select = jQuery('.tableContainerVisibleRow .tableView__row').find('.f-fieldSetList'),
            that = this;

        this.init = function() {
            bindEvents();  
        };
        var bindEvents = function() {
            $link.on('click', showSelect);
            $select.on('change', changeOptions);
        };
        var changeOptions = function(e) {
            e.preventDefault();
            
            var selecVal = jQuery(this).find('option:selected').val(),
                selecText = jQuery(this).find('option:selected').text(),
                selectId = jQuery(this).prop('id'),
                selectName = jQuery(this).prop('name'),
                link = jQuery(this).parent().find('a');
                url = link.data('url'),
                obj = {}

            obj[selectName] = selecVal;

            jQuery(this).parent().find('.chosen-container').hide();
            // appRequest.send(url, 'POST', obj, {
            //     success: function(resp) {
            //         systemMessage.show('Данные успешно изменены', 2);
            //         link.show();
            //         link.text(selecText);
            //     },
            // });
        };
        var showSelect = function(e) {
            e.preventDefault();
            $link.show();
            jQuery('.chosen-container').hide();
            $(this).hide();
            $(this).parent().find('.chosen-container').show();
        };
        this.init();
    };

    var changeDataFromList = new ChangeDataFromList();
});