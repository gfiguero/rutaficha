(function($) {
    $.fn.autocompleter = function(options) {
        var settings = {
            url_search: '',
            url_get: '',
        };
        return this.each(function() {
            if (options) {
                $.extend(settings, options);
            }
            var $this = $(this);
            var $fakeInput = $('<input type="text" name="fake_' + $this.attr('name') + '" required="required">');
            $this.hide().after($fakeInput);
            $fakeInput.addClass( "form-control" );
            $fakeInput.autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url: settings.url_search,
                        dataType: "jsonp",
                        data: {
                            q: request.term
                        },
                        success: function( data ) {
                            response( data );
                        }
                    });
                },
                minLength: 1,
                delay: 1000,
                autoFocus: true,
                select: function(event, ui) {
                    $this.val(ui.item.id);
                },
                change: function (event, ui) {
                    if (!ui.item) {
                        $this.val('');
                        $fakeInput.val('');
                    }
                },
                close: function(event, ui) {
                },
            });
            if ($this.val() != '') {
                $.ajax({
                    url: settings.url_get,
                    dataType: "jsonp",
                    data: {
                        id: $this.val()
                    },
                    success: function( data ) {
                        $fakeInput.val( data )
                    }
                });
            }
        });
    };
    $.fn.autocompleterPropiedad = function(options) {
        var settings = {
            url_search: '',
            url_get: '',
        };
        return this.each(function() {
            if (options) {
                $.extend(settings, options);
            }
            var $this = $(this);
            var $calle = $("#sig_fichasocialbundle_propiedad_calle");
            var $fakeInput = $('<input type="text" name="fake_' + $this.attr('name') + '" required="required">');
            $this.hide().after($fakeInput);
            $fakeInput.addClass( "form-control" );
            $fakeInput.autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url: settings.url_search,
                        dataType: "jsonp",
                        data: {
                            q: request.term
                        },
                        success: function( data ) {
                            response( data );
                        }
                    });
                },
                minLength: 1,
                delay: 1000,
                autoFocus: true,
                select: function(event, ui) {
                    $this.val(ui.item.id);
                    $calle.val(ui.item.value);
                },
                change: function (event, ui) {
                    if (!ui.item) {
                        $this.val('');
                        $fakeInput.val('');
                    }
                },
                close: function(event, ui) {
                },
            });
            if ($this.val() != '') {
                $.ajax({
                    url: settings.url_get,
                    dataType: "jsonp",
                    data: {
                        id: $this.val()
                    },
                    success: function( data ) {
                        $fakeInput.val( data )
                    }
                });
            }
        });
    };
    $.fn.autocompleterDomicilio = function(options) {
        var settings = {
            url_search: '',
            url_get: '',
            col: '',
        };
        return this.each(function() {
            if (options) {
                $.extend(settings, options);
            }
            var $this = $(this);
            var $domicilio = $("#sig_fichasocialbundle_persona_domicilio_id");
            //$domicilio.closest('.form-group').hide();
            var $calle = $("#sig_fichasocialbundle_persona_calle");
            var $numero = $("#sig_fichasocialbundle_persona_numero");
            var $complemento = $("#sig_fichasocialbundle_persona_complemento");
            $this.autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url: settings.url_search,
                        dataType: "jsonp",
                        data: {
                            col: settings.col,
                            calle: $calle.val(),
                            numero: $numero.val(),
                            complemento: $complemento.val()
                        },
                        success: function( data ) {
                            response( data );
                        }
                    });
                },
                minLength: 0,
                delay: 500,
                autoFocus: true,
                select: function(event, ui) {
                    $domicilio.val(ui.item.id);
                },
                change: function (event, ui) {
                    if (!ui.item) {
                        $domicilio.val('');
                        $calle.val('');
                        $numero.val('');
                        $complemento.val('');
                    }
                },
            });
/*
            if ($domicilio.val() != '') {
                $.ajax({
                    url: settings.url_get,
                    dataType: "jsonp",
                    data: {
                        id: $domicilio.val()
                    },
                    success: function( data ) {
                        $calle.val( data.calle ),
                        $numero.val( data.numero ),
                        $complemento.val( data.complemento )
                    }
                });
            }
*/
        });
    };
})(jQuery);