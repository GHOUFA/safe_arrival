/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(document).ready(function ($) {
    var table = $("#table-user").dataTable({
        "sPaginationType": "bootstrap",
        "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "bStateSave": true,
        "oLanguage": {
            oAria: {
                sSortAscending: ": {{ 'listing.sortasc'|trans({}) }}",
                sSortDescending: ": {{ 'listing.sortdes'|trans({}) }}"
            },
            oPaginate: {
                sFirst: "{{ 'listing.paginate.first'|trans({}) }}",
                sLast: "{{ 'listing.paginate.last'|trans({}) }}",
                sNext: "{{ 'listing.paginate.next'|trans({}) }}",
                sPrevious: "{{ 'listing.paginate.previous'|trans({}) }}"
            },
            sEmptyTable: "{{ 'listing.emptytable'|trans({}) }}",
            sInfo: "{{ 'listing.showing'|trans({}) }} _START_ {{ 'listing.to'|trans({}) }} _END_ {{ 'listing.of'|trans({}) }} _TOTAL_ {{ 'listing.entries'|trans({}) }}",
            sInfoEmpty: "{{ 'listing.showing'|trans({}) }} 0 {{ 'listing.to'|trans({}) }} 0 {{ 'listing.of'|trans({}) }} 0 {{ 'listing.entries'|trans({}) }}",
            sInfoFiltered: "({{ 'listing.infofiltred.from'|trans({}) }} _MAX_ {{ 'listing.infofiltred.total'|trans({}) }})",
            sLengthMenu: "_MENU_ {{ 'listing.lengthmenu'|trans({}) }}",
            sLoadingRecords: "{{ 'listing.loadingrecord'|trans({}) }}",
            sProcessing: "{{ 'listing.loadingrecord'|trans({}) }}",
            sSearch: "{{ 'listing.search'|trans({}) }}:",
            sZeroRecords: "{{ 'listing.zerorecord'|trans({}) }}"
        }
    });

    table.columnFilter({
        "sPlaceHolder": "head:after",
        "aoColumns": [
            {},
            {},
            {},
            {},
            {},
            {type: "select"}
        ]
    });
});


