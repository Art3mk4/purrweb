
jQuery(document).ready(function() {

    var CreateQuestion = function(option) {
        var $typeAnswers = jQuery(option.typeAnswers),
            $typeQuestion = jQuery(option.typeQuestion),
            $addAnswerBtn = jQuery(option.addAnswerBtn),
            that = this;

        this.init = function() {
            bindEvents();
            $typeAnswers.chosen();
            $typeQuestion.chosen();
        };
        var bindEvents = function() {
            $addAnswerBtn.on('click', additem);
        };
        var additem = function(event) {
            var choseItemText = jQuery(event.target).parents('tr').find($typeAnswers).find('option:selected').text(),
                choseItemValue = jQuery(event.target).parents('tr').find($typeAnswers).find('option:selected').val(),
                choseItemCodeVal = jQuery(event.target).parents('tr').find('.f-codeAnswer'),
                choseItemNameVal = jQuery(event.target).parents('tr').find('.f-nameAnswer'),
                tbodyContent = jQuery(event.target).parents('tbody');

            tbodyContent.append('<tr>\
                                    <td><input class="f-answerType f-textFields" type="text" value="'+ choseItemText +'" /></td>\
                                    <td><input class="f-codeAnswer f-textFields" type="text" value="'+ choseItemCodeVal.val() +'" /></td>\
                                    <td><input class="f-nameAnswer f-textFields" type="text" value="'+ choseItemNameVal.val() +'" /></td>\
                                    <td><button class="deleteAnswerBtn"></button></td>\
                                \</tr>');  

            jQuery('.deleteAnswerBtn').on('click', deleteItem);

            choseItemCodeVal.val("");
            choseItemNameVal.val("");
            return false;         
        };  
        var deleteItem = function(event) {
            event.stopPropagation();
            jQuery(event.target).parents('tr').remove();
        };

        this.init();
    };

    var createQuestion = new CreateQuestion({
        typeQuestion: '#f-choseTypeQuestion',
        typeAnswers: '#f-choseTypeAnswer',
        addAnswerBtn: '.addAnswerBtn'
    });

});