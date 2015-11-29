
jQuery(document).ready(function() {

    var HeaderTitleView = function(option) {
        var $headerTitle = jQuery(option.headerTitle),
            $actionList = jQuery(option.mainContentHeader).find('.action__list');
            that = this;

        this.init = function() {
            bindEvents();
        };
        var bindEvents = function() {
            $headerTitle.on('click', showList);
            jQuery(document).click(clickOutSideList);
        };
        var showList = function(event) {
            if ($actionList.css('display') == 'none') {
                $actionList.show();
            } else {
                $actionList.hide();
            }
        };
        var clickOutSideList = function(event) {
            if ($(event.target).closest($headerTitle).length) return;
            $actionList.hide();
            event.stopPropagation();
        };
        this.init();
    };

    var headerTitleView = new HeaderTitleView({
        headerTitle: '.mainContent__title',
        mainContentHeader: '.mainContent__header'
    });
});