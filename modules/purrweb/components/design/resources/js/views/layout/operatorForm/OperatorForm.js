// Главное меню
define([
],
function () {

	var OperatorFormView = Backbone.View.extend({
        el: $('.viewOperatorData__title'),

        initialize: function() {
            _.bindAll(this);
            
            $('#f-operatorAccount, #f-filterByName').chosen();
        },
	});

	return OperatorFormView;
});