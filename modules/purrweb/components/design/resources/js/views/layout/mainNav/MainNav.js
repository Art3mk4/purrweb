
jQuery(document).ready(function() {

    var MainNavView = (function () {
        var mainNav = function() {
            _.bindAll(this);

            this._navLink = jQuery('.mainNav__list__link');
            this._mainNavSublist = jQuery('.mainNav__sublist');

            this._navLink.on('click', this._processShowSubList);

            if (jQuery('.mainNav__list__link').next().hasClass('mainNav__sublist')) {

            }
        };
        mainNav.prototype._processShowSubList = function(e) {

            var currentLink = jQuery(e.target),
                currentSubList = jQuery(e.target).parent().find('.mainNav__sublist');
            
            if (currentLink.next().hasClass('mainNav__sublist')) {
                if (currentSubList.css('display') == 'none') {
                    currentLink.parent().addClass('openSubList');
                } else {
                    currentLink.parent().removeClass('openSubList');
                    currentLink.removeClass('m-singleLink');
                }
                return false;
            } else {
                currentLink.parent().addClass('openSubList');
                currentLink.addClass('m-singleLink');   
            }
            
        };
        return mainNav;
    })();

    var mainNav = new MainNavView();
});