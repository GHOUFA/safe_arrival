jQuery.extend(jQuery.fn.dataTableExt.oSort, {
    "date-fr-pre": function (a) {
        if (jQuery.trim(a) != '') {
            var frDatea = jQuery.trim(a).split(' ');

            var frDatea2 = frDatea[0].split('/');
            if (typeof(frDatea[1]) !== 'undefined') {
                var frTimea = frDatea[1].split(':');
                return (frDatea2[2] + frDatea2[1] + frDatea2[0] + frTimea[0] + frTimea[1] + frTimea[2]) * 1;
            }
            else
                return (frDatea2[2] + frDatea2[1] + frDatea2[0]) * 1;
        }
        else
            return 0;
    },

    "date-fr-asc": function (a, b) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },

    "date-fr-desc": function (a, b) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
});

