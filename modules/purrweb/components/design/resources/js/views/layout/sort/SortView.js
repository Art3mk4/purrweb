
jQuery(document).ready(function() {

    var SortView = (function () {
        var sortView = function(sortContainer) {
            _.bindAll(this);
            
            this._sortBtn = jQuery('.' + sortContainer).find('.sortBtn');
            this._sortList = jQuery('.' + sortContainer).find('.sort__list');
            this._sortListLink = jQuery('.' + sortContainer).find('.sort__list').find('a');

            this._sortBtn.on('click', this.processShowSortList);
            this._sortListLink.on('click', this.changeDirectionSort);

            jQuery(document).click(this.clickOutSideList);
        };
        sortView.prototype.processShowSortList = function(e) {
            
            var btn = jQuery(e.target);
            if (this.isHide()) {
                this._sortList.show();
            } else {
                this._sortList.hide();
            }
        };
        sortView.prototype.changeDirectionSort = function(e) {
            

        };
        sortView.prototype.isHide = function() {
            return (this._sortList.css('display') == 'none');
        };  
        sortView.prototype.clickOutSideList = function(e) {            
            if ($(event.target).closest(this._sortBtn).length) return;
            this._sortList.hide();
            e.stopPropagation();
        };
        return sortView;
    })();

    var sortView = new SortView('sortContainer');
});
