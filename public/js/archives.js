/**
 * Created by bezimienny on 10.02.15.
 */
//$(document).ready(function () {
//    $('a.page-link').each(function () {
//        $(this).attr('href', '#');
//    });
//});
//$('a.page-link').click(function () {
//    console.log('was clicked');
//
//    var target = $(this).children('span');
//    var targetName = target.attr('name');
//    var targetLocation = target.attr('id');
//    var params = [targetLocation, 1];
//    var activePage = $('li.active > a > span').attr('id')
//    var maxPage = $('span[name=last-page]').attr('id');
//    var activePage2 = activePage;
//    $('li.active').removeClass('active');
//    switch (targetName) {
//        case 'first-page':
//
//            break;
//        case 'previous-page':
//            var targetPage = --activePage;
//            $('span[name=page]#' + activePage2).parents('li').addClass('page');
//            $('span[name=page]#' + targetPage).parents('li').removeClass('page');
//            var element = $('span[name=page]#' + targetPage).parents('li').addClass('active');
//
//            $.each($('ul.pagination > li.page'), function () {
//                this.remove();
//            });
//
//            for (i = activePage - 2; i < activePage; ++i) {
//                if (i > 0){
//                    $('li.active').before('<li class="page"><a class="page-link" href="#"><span name="page" id="'+i+'">'+i+'</span></a></li>');
//                }
//
//            }
//
//            for (i = activePage + 2; i > activePage; --i) {
//                if (i < maxPage){
//                    $('li.active').after('<li class="page"><a class="page-link" href="#"><span name="page" id="'+i+'">'+i+'</span></a></li>');
//                }
//
//            }
//
//            break;
//        case 'page':
//
//            var targetPage = targetLocation;
//            $('span[name=page]#' + activePage2).parents('li').addClass('page');
//            $('span[name=page]#' + targetPage).parents('li').removeClass('page');
//            var element = $('span[name=page]#' + targetPage).parents('li').addClass('active');
//
//            $.each($('ul.pagination > li.page'), function () {
//                this.remove();
//            });
//
//            for (i = parseInt(targetPage) + 2; i > parseInt(targetPage); --i) {
//                if (i < maxPage){
//                    $('li.active').after('<li class="page"><a class="page-link" href="#"><span name="page" id="'+i+'">'+i+'</span></a></li>');
//                }
//
//            }
//
//            for (i = parseInt(targetPage) - 2; i < parseInt(targetPage); ++i) {
//                if (i > 0){
//                    $('li.active').before('<li class="page"><a class="page-link" href="#"><span name="page" id="'+i+'">'+i+'</span></a></li>');
//                }
//
//            }
//            break;
//        case 'next-page':
//            var targetPage = ++activePage;
//            $('span[name=page]#' + activePage2).parents('li').addClass('page');
//            $('span[name=page]#' + targetPage).parents('li').removeClass('page');
//            var element = $('span[name=page]#' + targetPage).parents('li').addClass('active');
//
//            $.each($('ul.pagination > li.page'), function () {
//                this.remove();
//            });
//
//            for (i = activePage + 2; i > activePage; --i) {
//                if (i < maxPage){
//                    $('li.active').after('<li class="page"><a class="page-link" href="#"><span name="page" id="'+i+'">'+i+'</span></a></li>');
//                }
//                    //console.log(i);
//            }
//
//            for (i = activePage - 2; i < activePage; ++i) {
//                if (i > 0){
//                    $('li.active').before('<li class="page"><a class="page-link" href="#"><span name="page" id="'+i+'">'+i+'</span></a></li>');
//                }
//
//            }
//
//            break;
//        case 'last-page':
//
//            break;
//    }
//
//});
//function getPages(url, params) {
//    return $.ajax({
//        url: url + params[1] + '/' + params[2],
//        data: {
//            format: 'json'
//        },
//        dataType: 'json',
//        type: 'GET'
//    })
//        //.done(function (data) {
//        //    //console.log(data);
//        //    return data;
//        //    //$('#myTable tbody').html(data.nextPage);
//        //    //console.log(data.nextPage);
//        //    //console.log(data.currentPage);
//        //})
//        .fail(function () {
//            console.log('AJAX error.')
//        });
//}