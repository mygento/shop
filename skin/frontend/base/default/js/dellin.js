jQuery(function() {
    function autocomp(name) {
        jQuery('input[name="' + name + '"]').autocomplete({
            source: function(request, response) {
                jQuery.ajax({
                    url: "/dellin/index/json/?callback=?",
                    dataType: "jsonp",
                    data: {
                        q: function() {
                            return jQuery('input[name="' + name + '"]').val()
                        }
                    },
                    success: function(data) {
                        response(jQuery.map(data.jsonresult, function(item) {
                            return {
                                label: item.name,
                                value: item.name,
                                id: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 3,
            close: function() {
            },
            select: function(event, ui) {
                jQuery('input[name="' + name + '"]').val(ui.item.id);
            }
        });
    }
    ;
    autocomp('billing[city]');
    autocomp('shipping[city]');
});