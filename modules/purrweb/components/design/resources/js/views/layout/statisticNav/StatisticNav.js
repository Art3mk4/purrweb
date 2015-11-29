// Главное меню
define([
],
function () {

    var StatisticNavView = Backbone.View.extend({
        navLink: $('.statisticNav__list__link'),
        mainNavSublist: $('.statisticNav__sublist'),

        initialize: function() {
            _.bindAll(this);
            $(this.navLink).on('click', this._processShowSubList);
        },
        _processShowSubList: function(e) {
            var currentLink = $(e.target),
                currentSubList = currentLink.parent().find(this.mainNavSublist);
            
            if (currentSubList.css('display') == 'none') {
                this._showSubList(currentLink, currentSubList);
            } else {
                this._hideSubLis(currentLink, currentSubList);
            }
            return false;
        },
        _showSubList: function(currentLink, currentSubList) {
            currentLink.addClass('openStatSublist');
            currentSubList.slideDown();
        },
        _hideSubLis: function(currentLink, currentSubList) {
            currentLink.removeClass('openStatSublist');
            currentSubList.slideUp();
        }
    });

    return StatisticNavView;
});