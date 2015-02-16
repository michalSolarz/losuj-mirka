/**
 * Created by bezimienny on 10.02.15.
 */
$(document).ready(function () {
    $('.long-list').toggle();
    $('.list-collapse').toggle();
    collapseList('.upVoters-list', '.hide-upVoters');
    collapseList('.activeUpVoters-list', '.hide-activeUpVoter');
    collapseList('.inactiveUpVoters-list', '.hide-inactiveUpVoter');
    $('.select').OneClickSelect();
});
$.fn.OneClickSelect = function () {
    return $(this).on('click', function () {

        var range, selection;

        if (window.getSelection) {
            selection = window.getSelection();
            range = document.createRange();
            range.selectNodeContents(this);
            selection.removeAllRanges();
            selection.addRange(range);
        } else if (document.body.createTextRange) {
            range = document.body.createTextRange();
            range.moveToElementText(this);
            range.select();
        }
    });
};
function collapseList(button, div) {
    $(button + ':button').click(function () {
        $(div).toggle();
        if ($(button).text() == 'Rozwiń') {
            $(button + ':button').text('Zwiń');
        }
        else {
            $(button + ':button').text('Rozwiń');
        }
    });
};