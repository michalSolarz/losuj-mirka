/**
 * Created by bezimienny on 10.02.15.
 */
$(document).ready(function () {
    removeClass('ul.nav > li.active', 'active');
    var url = window.location;
    url = url.href;
    url = url.replace(/[0-9]+\/[0-9]+/g, '');
// Will only work if string in href matches with location
    $('ul.nav a[href="' + url + '"]').parent().addClass('active');

// Will also work for relative and absolute hrefs
    $('ul.nav a').filter(function () {
        return this.href == url;
    }).parent().addClass('active');

});
function removeClass(target, input) {
    $(target).removeClass(input);
}