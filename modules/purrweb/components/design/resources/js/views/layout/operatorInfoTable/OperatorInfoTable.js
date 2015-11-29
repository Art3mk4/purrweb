jQuery(document).ready(function() {

    var OperatorInfoTableView = (function () {
        var operatorInfoTable = function() {

            this._tableRow = jQuery('.tableView__row');
            this.checkbox = jQuery('.f-choseTableView__checkbox');

            this.checkbox.on('click', this._checkedCheckbox);

            if (this._tableRow.length > 0) {
                this._tableRow.on('click', this._processChoseRow);
            }
        
            
        };
        operatorInfoTable.prototype._checkedCheckbox = function(e) {

            if (jQuery(this).is(':checked')) {
                jQuery(this).attr('checked', 'checked');
                jQuery(this).parents('.tableView__row').addClass('activeRow');
                
            } else {
                if (jQuery(this).parents('.tableView__row').find('.tableView__containerBtns').css('display') == 'block') {
                    jQuery(this).parents('.tableView__row').addClass('activeRow');
                } else {
                    jQuery(this).parents('.tableView__row').removeClass('activeRow');
                }
                jQuery(this).removeAttr('checked');
                
            }
            e.stopImmediatePropagation();
        };
        operatorInfoTable.prototype._processChoseRow = function(e) {
            var currentRow = jQuery(this),
                controlsBtn = currentRow.find('.tableView__containerBtns');

            if (jQuery(e.target).is('audio') || jQuery(e.target).is('div.mejs-audio') || jQuery(e.target).is('a, a>span, ul>li') || jQuery(e.target).is('input[type="submit"]') || currentRow.find('input, textarea').is(':focus')) {
                return;
            }
            if (controlsBtn.css('display') == 'none') {
                jQuery('.tableView__row').removeClass('activeRow');
                jQuery('.tableView__containerBtns').hide();
                controlsBtn.show();
                currentRow.addClass('activeRow');
            } else {
                if (currentRow.find('input').attr('checked')) {
                    currentRow.addClass('activeRow');
                } else {
                    currentRow.removeClass('activeRow');
                }
                controlsBtn.hide();
            }
        };
        return operatorInfoTable;
    })();

    var operatorInfoTable = new OperatorInfoTableView();
});
