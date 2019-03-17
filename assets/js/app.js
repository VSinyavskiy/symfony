/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/bootstrap.4.3.min.css');
require('../css/fixes.css');
require('../css/app.css');

$(function() {
    var $table = $('#employees');

    init = function() {
        $(document).on('submit',  '#employees-search',     submitEmployeesSearch);
        $(document).on('click',   '.order',                clickOrder);
    };

    submitEmployeesSearch = function(e) {
        e.preventDefault();

        var $form  = $(e.currentTarget),
            url    = $form.attr('action') + '?search=' + $form.find('input').val();

        resetOrder();

        submitSearch(url, $table);
    };

    clickOrder = function(e) {
        e.preventDefault();

        var $btn  = $(e.currentTarget),
            attr   = $btn.attr('attribute'),
            order  = getOrder($btn),
            $form  = $btn.parents('div').find('#employees-search'),
            url    = $form.attr('action') + '?search=' + $form.find('input').val() +
                                            '&order=' + attr + ':' + order;

        setOrder($btn, order);

        submitSearch(url, $table);
    };

    submitSearch = function(url) {
        $.ajax({
            type: 'GET',
            url:  url,
            success: function(success) {
                $table.find('tbody').html(success.items);
            },
            error: function(error) {
            }
        });
    };

    getOrder = function($btn) {
        var order,
            lastOrder = (typeof $btn.attr('order') !== 'undefined') ? $btn.attr('order') : false;

        switch(lastOrder) {
            case 'ASC':
                order = 'DESC';
                break;

            case 'DESC':
                order = '';
                break;

            default:
                order = 'ASC';
                break;
        }

        return order;
    };

    setOrder = function($btn, order) {
        $btn.attr('order', order);
    };

    resetOrder = function() {
        $('.order').attr('order', '');
    };

    $(init);
});
