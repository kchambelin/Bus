@extends('layouts.app')

@section('title', 'Bus')
@section('header.title', 'Partenaires Particuliers')
@section('breadcumb.first.title', 'BUS')

@section('page.content')

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div class="row">
                <div class='col-lg-12'>
                    <div class="card card-custom">
                        <div class="card-header">
                            <div class="card-title">
                                <span class="card-icon">
                                    <i class="flaticon2-delivery-package text-primary"></i>
                                </span>
                                <h3 class="card-label">Our buses</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="kt_datatable_wrapper" id="dataTables_wrapper dt-bootstrap4">
                                <table class="table table-bordered table-hover table-checkable dataTable dtr-inline collapsed dt-responsive" id="kt_datatable" role="grid" aria-describedby="kt_datatable_info" style="width: 1235px;">
                                    <thead>
                                        <tr>
                                            <th>Number</th>
                                            <th>Date</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Places</th>
                                            <th>Book</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <!--end: Datatable-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->

@endsection

@section('page.script')
<script src={{asset("assets/plugins/custom/datatables/datatables.bundle.js")}}></script>

<script>
    "use strict";
    var KTDatatablesSearchOptionsAdvancedSearch = function() {

        $.fn.dataTable.Api.register('column().title()', function() {
            return $(this.header()).text().trim();
        });

        var initTable1 = function() {
            // begin first table
            var table = $('#kt_datatable').DataTable({
                autoWidth: false,
                responsive: true,
                columnDefs: [{
                    className: 'control',
                    orderable: false,
                    target: 0,
                }],
                language: {
                    processing:     "Loading...",
                    lengthMenu:     'Buses _MENU_',
                    info:           "Buses _START_ to _END_ out of _TOTAL_",
                    infoEmpty:      "Buses 0 to 0 out of 0",
                    loadingRecords: "Loading...",
                    emptyTable:     "No bus available",
                    paginate: {
                        first:      "First",
                        previous:   "Previous",
                        next:       "Next",
                        last:       "Last"
                    },
                },

                dom: `<'row'<'col-sm-12'tr>>
                <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,

                lengthMenu: [5, 10, 25, 50],
                order: [[0, 'asc']],
                ajax: {
                    url: "{{url('display_buses')}}",
                    type: 'GET',
                    dataSrc: "",
                },
                columns: [{
                        data: 'idbus',
                        width: '100px'
                    }, 
                    {
                        data: 'date',
                        width: '130px'
                    },
                    {
                        data: 'from_city',
                    },
                    {
                        data: 'to_city',
                    },
                    {
                        data: 'place_number',
                    },
                    {
                        data: function (row, type, val, meta) {
                            return '<button type="button" class="btn btn-light-primary font-weight-bold" onclick="book(' + row.idbus + ')">Book seats</button>';
                        },
                        width: '130px'
                    }
                ],

            });

        };



        return {

            //main function to initiate the module
            init: function() {
                initTable1();
            },
        };

    }();

    jQuery(document).ready(function() {
	KTDatatablesSearchOptionsAdvancedSearch.init();
});
</script>
<script>

    function book(bus) {
        console.log(bus);
    }
</script>
@endsection
