@extends('layouts.app')

@section('title', 'Bus')
@section('header.title', 'Partenaires Particuliers')
@section('breadcumb.first.title', 'BUS')

@section('page.content')
    <?php
        $user = Auth::user();
        if (!$user) {
            $user_id = -1;
        } else {
            $user_id = $user->iduser;
        }
    ?>
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
                                            <th>Places remaining</th>
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

    <div class="modal fade" id="Modal_OK" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Booking</h5>
                </div>
                <div class="modal-body">
                    <div class="row dflex align-items-center justify-content-center">
                        <div class="col-xl-12">
                            <button type="button" class="btn btn-light-success" disabled="disabled">Your place has been reserved.</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="To_second_step" class="btn btn-primary font-weight-bold" onclick="Refresh()">Refresh</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="Modal_NOK" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Booking</h5>
                </div>
                <div class="modal-body">
                    <div class="row dflex align-items-center justify-content-center">
                        <div class="col-xl-12">
                            <button type="button" class="btn btn-light-success" disabled="disabled">Something happened. Please try again.</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="To_second_step" class="btn btn-primary font-weight-bold" onclick="Refresh()">Refresh</button>
                </div>
            </div>
        </div>
    </div>


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
                        data: 'places_remaining',
                    },
                    {
                        data: function (row, type, val, meta) {
                            if (row.places_remaining == 0) {
                                return '<button type="button" class="btn btn-light-danger font-weight-bold">Full</button>';
                            } else {
                                return '<button type="button" class="btn btn-light-primary font-weight-bold" onclick="book(' + row.idbus + ')">Book a seat</button>';
                            }
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
        $.ajax({
            url:  "/api/v1/book",
            type: 'POST',
            headers:{
                'token':token,
            },
            data:{
                'iduser' : {{$user_id}},
                'idbus' : bus,
            },
            success: function (response) {
                console.log(response);
                if (response == 0) {
                    Book_ok();
                }
                else {
                    Book_not_ok();
                }
            }
        })
    }

    function Book_ok() {
        console.log('OK');
        $('#Modal_OK').modal('show');
    }

    function Book_not_ok() {
        console.log('Cheh');
        $('#Modal_NOK').modal('show');
    }

    function Refresh() {
        window.location.replace("{{route('bus')}}");
    }
</script>
@endsection
