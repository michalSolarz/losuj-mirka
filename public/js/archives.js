/**
 * Created by bezimienny on 10.02.15.
 */
$(document).ready(function () {
    var params = window.location.pathname.split('/').slice(1);
    if (params[1] == 0 || params[1] == null || !params[1]) {
        params[1] = 1;
    }
    if (params[2] == null) {
        params[2] = 10;
    }
    countPages('http://losuj.mirka.pl/countPages/', params[2])
        .done(function (data) {
            $('ul.pagination').empty();
            $('ul.pagination').twbsPagination({
                totalPages: data.pagesAmount,
                visiblePages: 5,
                onPageClick: function (event, page) {
                    params[1] = page;
                    useAjax('http://losuj.mirka.pl/archives/ajaxArchives/', params)
                        .done(function (data) {
                            $('#archives-table tbody').html(data.result);
                        })
                }
            });
        });
});

function countPages(url, limit) {
    return $.ajax({
        url: url + limit,
        data: {
            format: 'json'
        },
        dataType: 'json',
        type: 'GET'
    })
        .fail(function () {
            console.log('AJAX error.')
        });
}

function useAjax(url, params) {
    return $.ajax({
        url: url + params[1] + '/' + params[2],
        data: {
            format: 'json'
        },
        dataType: 'json',
        type: 'GET'
    })
        .fail(function () {
            console.log('AJAX error.')
        });
}
