jQuery(function ($) {
    var f = {
        init: function (settings) {
            for (let elem in settings) {
                f[elem] = settings[elem];
            }
        },
        onReady: function () {
            f.counter.init();
            f.toolbar.init();
            f.priceFilter.init();
        },
        counter: {
            init: function () {

            }
        },
        toolbar: {
            viewKey: 'shop_view_mode',
            init: function () {
                // Restaurar modo de vista guardado en localStorage
                var saved = localStorage.getItem(f.toolbar.viewKey) || 'grid';
                f.toolbar.applyMode(saved);

                // Cambio de modo de vista
                $(document).on('click.toolbar', '.product-view-mode a', function (e) {
                    e.preventDefault();
                    var mode = $(this).data('target').trim();
                    f.toolbar.applyMode(mode);
                    localStorage.setItem(f.toolbar.viewKey, mode);
                });

                // Cambio de ordenamiento → recarga con ?orderby=
                $(document).on('change.toolbar', '#shop-orderby', function () {
                    var url = new URL(window.location.href);
                    url.searchParams.set('orderby', $(this).val());
                    url.searchParams.delete('paged');
                    window.location.href = url.toString();
                });

                // Cambio de cantidad por página → recarga con ?per_page=
                $(document).on('change.toolbar', '#shop-per-page', function () {
                    var url = new URL(window.location.href);
                    url.searchParams.set('per_page', $(this).val());
                    url.searchParams.delete('paged');
                    window.location.href = url.toString();
                });
            },
            applyMode: function (mode) {
                var $wrap = $('.shop-product-wrap');
                $('.product-view-mode a').removeClass('active');
                $('.product-view-mode a').each(function () {
                    if ($(this).data('target').trim() === mode) {
                        $(this).addClass('active');
                    }
                });
                $wrap.removeClass('grid grid-four list').addClass(mode);
            }
        },
        priceFilter: {
            init: function () {
                var $slider = $('.sb-range-slider');
                if (!$slider.length) return;

                var maxPrice   = $slider.data('max') || 1000;
                var currentMin = $slider.data('current-min') || 0;
                var currentMax = $slider.data('current-max') || maxPrice;
                var termId     = $slider.data('term-id') || 0;

                $slider.slider({
                    range: true,
                    min: 0,
                    max: maxPrice,
                    values: [currentMin, currentMax],
                    slide: function (event, ui) {
                        $('#amount').val('S/' + ui.values[0] + ' - S/' + ui.values[1]);
                    },
                    change: function (event, ui) {
                        f.priceFilter.fetch(ui.values[0], ui.values[1], termId);
                    }
                });

                $('#amount').val(
                    'S/' + $slider.slider('values', 0) + ' - S/' + $slider.slider('values', 1)
                );
            },
            fetch: function (minPrice, maxPrice, termId) {
                var ajaxurl      = typeof array_url !== 'undefined' ? array_url.ajaxurl : '/wp-admin/admin-ajax.php';
                var $grid        = $('.shop-product-wrap.grid');
                var $pagination  = $('.pagination-block');
                var url          = new URL(window.location.href);
                var author       = url.searchParams.get('autor_filtro') || url.searchParams.get('autor') || '';
                var format       = url.searchParams.get('formato') || '';

                $grid.css('opacity', '0.5');

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action:    'filter_products_by_price',
                        min_price: minPrice,
                        max_price: maxPrice,
						term_id:   termId,
                        autor:     author,
						formato:   format
                    },
                    success: function (res) {
                        $grid.css('opacity', '1');
                        if (res.success && res.data) {
                            $grid.html(res.data.html);
                            if ($pagination.length && res.data.pagination) {
                                $pagination.html(res.data.pagination);
                            }
                        }
                    },
                    error: function () {
                        $grid.css('opacity', '1');
                    }
                });
            }
        },
        width: () => {
            return $(window).width();
        },
    };
    f.init({
        home: {
            nav: '.main-nav',
        },
    });
    $(f.onReady);
});