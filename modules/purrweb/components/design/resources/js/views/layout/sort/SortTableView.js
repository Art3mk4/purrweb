var SortTable = function(option) {
    var $sortLink = jQuery(option.sortLink),
        $btnsContainer = jQuery(option.btnsContainer),
        $table = jQuery(option.table),

        $tableActionBtns = jQuery(option.btnsContainer).find('.tableActionBtns'),
        $tableSortBtns = jQuery(option.btnsContainer).find('.tableSortBtns'),
        $saveSortBtn = jQuery(option.btnsContainer).find('.saveSortBtn'),
        $cancelSortBtn = jQuery(option.btnsContainer).find('.cancelSortBtn'),
        that = this;

    this.init = function() {
        bindEvents();
    };
    var bindEvents = function() {
        $sortLink.on('click', initSort);
        $saveSortBtn.on('click', saveSortData);
        $cancelSortBtn.on('click', cancelSortData);
    };
    var initSort = function(event) {
        
        var curBtn = jQuery(this);
        showSortBtns(curBtn);
        initSortPlugin(curBtn);
        
        event.preventDefault();
    };
    var cancelSortData  = function() {
        var curBtn = jQuery(this),
            table = jQuery(this).parents('.mainContent__actionBtns').next().find('.tableView');
        table.sortable( "cancel" );
        table.sortable( "destroy" );
        table.find('.tableView__row').removeClass('moveRow');
        hideSortBtns(curBtn);
    };
    var showSortBtns = function(curBtn) {
        curBtn.parents('.tableActionBtns').hide();
        curBtn.parents('.mainContent__actionBtns').find('.tableSortBtns').css('display', 'inline-block');
    };
    var hideSortBtns = function(curBtn) {
        curBtn.parents('.mainContent__actionBtns').find('.tableActionBtns').css('display', 'inline-block');
        curBtn.parents('.tableSortBtns').hide();
        $('.otherPage___row').hide();
    };
    var initSortPlugin = function(curBtn) {

        var table = curBtn.parents('.mainContent__actionBtns').next().find('.tableView');
        table.sortable({
            placeholder: "currentPlaceRow",
            opacity: 0.9,
            start: function(event, ui) {
                table.find('.otherPage___row').show();
            }
        }).disableSelection();
        table.find('.tableView__row').addClass('moveRow');
    };
    var saveSortData = function(e) {
        var curBtn = jQuery(this),
            table = jQuery(this).parents('.mainContent__actionBtns').next().find('.tableView');
            serialiseArray = getSortData(table);

        appRequest.send($(e.target).data('urlsort'), 'POST', serialiseArray, {
            success: function() {
                var rows = table.find('.tableView__row'),
                    count = table.find('.tableView__row').length;

                rows.each(function(indx, el) {
                    $(this).removeClass('otherPage___row');
                    if ((indx == 0 || indx == count - 1) && $(this).hasClass('otherPage___row')) {
                        $(this).addClass('otherPage___row').attr('style', '');
                    }
                });
                rows.removeClass('moveRow');
                table.sortable( "destroy" );
                hideSortBtns(curBtn);
                window.location.reload();
            },
            error: function() {
                cancelSortData(curBtn);
            }
        });
    };
    var getSortData = function(table) {
        var sortData = {},
            beginSort = table.data('beginsort') + '';
        table.find('input:checkbox').each(function(index, el) {
            var sortIndex = parseInt(beginSort + index),
                id = $(this).val();
            sortData[id] = sortIndex;
        });
        return sortData;
    }

    this.init();
};

jQuery(document).ready(function() {
    var sortTable = new SortTable({
        sortLink: '.a-changeSort',
        btnsContainer: '.mainContent__actionBtns',
        table: '.tableView'
    });

});
