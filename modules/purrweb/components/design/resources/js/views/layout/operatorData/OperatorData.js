// Главное меню
define([
],
function () {

	var OperatorDataView = Backbone.View.extend({
        el: $('.viewOperatorData__title'),

        initialize: function() {
            _.bindAll(this);
            
            this.$el.on('click', this._processShowData);
        },
        _processShowData: function(e) {
        	var currentLink = $(e.target),
        		dataList = currentLink.parent().find('.viewOperatorData__content');
                
        	if (dataList.css('display') == 'none') {
        		this._showList(currentLink, dataList);
        	} else {
        		this._hideList(currentLink, dataList);
        	}
            return false
        },
        _showList: function(currentLink, dataList) {
            currentLink.addClass('m-openViewOperatorData');
    		dataList.show();
        },
        _hideList: function(currentLink, dataList) {
            currentLink.removeClass('m-openViewOperatorData');
            dataList.hide();
        }
	});

	return OperatorDataView;
});