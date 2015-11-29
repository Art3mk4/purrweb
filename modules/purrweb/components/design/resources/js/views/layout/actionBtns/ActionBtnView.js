
jQuery(document).ready(function() {

    var ActionBtnView = (function () {
        var actionBtnView = function() {
            _.bindAll(this);
            
            this.typeVal = null;
            this._actionBtn = jQuery('.actionBtn');
            this._actionList = jQuery('.actionBtn').find('.action__list');
            this.questionSelectType = jQuery('.createQuestionForm').find('.questionType');
            this.addType = jQuery('.createQuestionForm').find('.actionActiveBtn');
            this.checkAllRowLink = jQuery('.a-checkAllTable__row');

            this.addListAnswers = jQuery('.a-addListAnswers');

            this._actionBtn.on('click', this.processShowActionList);
            this.questionSelectType.on('change', this.choseType);
            this.addType.on('click', this.processAddType);
            this.checkAllRowLink.on('click', this.checkAllRow);
            this.addListAnswers.on('click', function(e) {
                e.preventDefault();
                $('body').addClass('m-overlay');
                jQuery('.answersPopup').show();
            });

            jQuery(document).click(this.clickOutSideList);
        };
        actionBtnView.prototype.addListAnswers = function(e) {
            
        };
        actionBtnView.prototype.choseType = function(e) {
            this.typeVal = jQuery(e.target).find('option:selected').val();
            if (this.typeVal != '') {
                jQuery(e.target).next().removeClass('error');
            }
        };
        actionBtnView.prototype.processAddType = function(e) {
            if ((this.typeVal == null) || (that.typeVal == "")) {
                jQuery(e.target).parent().find('.chosen-container').addClass('error');
                // systemMessage.show('Заполнены не все поля', systemMessage.ERROR);
                e.preventDefault();
            } else {
                jQuery(e.target).parent().find('.chosen-container').removeClass('error');
            }
        };
        actionBtnView.prototype.processShowActionList = function(e) {
            var curList = jQuery(e.target).find('.action__list');
            if (this.isHide(curList)) {
                curList.show();
            } else {
                curList.hide();
            }
        };
        actionBtnView.prototype.isHide = function(curList) {
            return (curList.css('display') == 'none');
        };  
        actionBtnView.prototype.checkAllRow = function(e) {
            e.preventDefault();

            var checkbox = jQuery(e.target).parents('.mainContent__actionBtns').next('.tableViewContainer').find('.f-choseTableView__checkbox'),
                row = jQuery(e.target).parents('.mainContent__actionBtns').next('.tableViewContainer').find('.tableView__row');
            if (checkbox.is(':checked')) {
                checkbox.removeAttr('checked');
                row.removeClass('activeRow');
            } else {
                checkbox.attr('checked', true);
                row.addClass('activeRow');
            }
        };
        actionBtnView.prototype.clickOutSideList = function(e) {        
            if ($(event.target).closest(this._actionBtn).length) return;
            this._actionList.hide();
            e.stopPropagation();
        };
        return actionBtnView;
    })();


    var DeleteRow = function(option) {
        var $deleteRowLink = jQuery(option.deleteRowLink),
            $deleteBtn = jQuery(option.deleteBtn),
            that = this;

        this.init = function() {
            this.confirmDeleteView = new ConfirmDeleteView();
            bindEvents();
        };
        var bindEvents = function() {
            $deleteRowLink.on('click', deleteRow);
            $deleteBtn.on('click', processDeleteButton);
        };
        var deleteRow = function(e) {
            e.preventDefault();
            var url = jQuery(e.target).prop('href'),
                ids = serialiseTable(".tableView__col input:checked");  

            jQuery(e.target).parents('.action__list').hide();
            that.confirmDeleteView.show(ids, url);
        };
        var processDeleteButton = function(e) {
            e.preventDefault();
            var id = jQuery(e.target).data('id'),
                url = jQuery(e.target).prop('href');

            that.confirmDeleteView.show(id, url);

        };
        var serialiseTable = function(elements) {
            var elements = $(elements);
            var serialiseArray = [];
            elements.each(function(index, element){          
                serialiseArray.push($(element).val());
            });
            return serialiseArray;
        };

        this.init();
    };

    var actionBtnView = new ActionBtnView();
    
    var deleteRow = new DeleteRow({
        deleteRowLink: '.a-deleteTable__row',
        deleteBtn: '.deleteBtn'
    });

});
