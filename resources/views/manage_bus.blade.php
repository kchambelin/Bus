@extends('layouts.app')

@section('title', 'Bus management')
@section('header.title', 'Partenaires Particuliers')
@section('breadcumb.first.title', 'Bus management')

@section('page.content')

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card card-custom card-stretch gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">
                                    Create a new bus
                                </h3>
                            </div>
                        </div>
                        <div class="card-body">
                            Here, you can create a new bus, providing its route, its number of places and its date.
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <button type="button" class="btn btn-light-info font-weight-bold" onclick="show_modal_first_step()" id="Create_bus">
                                <span>Create bus</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->

    <div class="modal fade" id="Modal_first_step" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Define the route of the bus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reset_bus()">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row dflex align-items-center justify-content-center">
                        <div class="col-xl-5">
                            <label>From:</label>
                            <input id="from_city" type="text" class="form-control" placeholder="From" onchange="update_route()"/>
                        </div>
                        <div class="col-xl-2">
                        </div>
                        <div class="col-xl-5">
                            <label>To:</label>
                            <input id="to_city" type="text" class="form-control" placeholder="To" onchange="update_route()"/>
                        </div>
                    </div>
                    <div class="row mt-10 dflex align-items-center justify-content-center">
                        <div class="col-xl-5" id="first_wait" style="display: block">
                            <button type="button" class="btn btn-light active">Waiting for input!</button>
                        </div>
                        <div class="col-xl-5" id="first_ok" style="display: none">
                            <button type="button" class="btn btn-light-success" disabled="disabled">Both inputs are good!</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal" onclick="reset_bus()">Cancel</button>
                    <button type="button" id="To_second_step" class="btn btn-primary font-weight-bold" disabled="disabled" onclick="Go_to_second_step()">Next step</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="Modal_second_step" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Define the date of the bus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reset_bus()">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-10">
                        <div class="col-xl-12">
                            <button type="button" class="btn btn-light-warning" disabled="disabled">The date can be today or later.</button>
                        </div>
                    </div>
                    <div class="row dflex align-items-center justify-content-center mb-10">
                        <div class="col-lg-5">
                            <div class="input-group date">
                                <input type="text" class="form-control" readonly="readonly" id="datepicker" onchange="update_date()">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2">
                        </div>
                        <div class="col-xl-5" id="second_display">
                            <button type="button" class="btn btn-light-info" disabled="disabled" id="second_display_button">Waiting for input!</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal" onclick="reset_bus()">Cancel</button>
                    <button type="button" id="To_third_step" class="btn btn-primary font-weight-bold" disabled="disabled" onclick="Go_to_third_step()">Next step</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="Modal_third_step" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Define the number of places in the bus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reset_bus()">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-10">
                        <div class="col-xl-12">
                            <button type="button" class="btn btn-light-warning" disabled="disabled">The number is supposed to be between 10 and 50.</button>
                        </div>
                    </div>
                    <div class="row dflex align-items-center justify-content-center mb-10">
                        <div class="col-xl-5">
                            <label>Number of places:</label>
                            <input id="nb_places" type="text" class="form-control" placeholder="15" onchange="update_nb_places()"/>
                        </div>
                        <div class="col-xl-2">
                        </div>
                        <div class="col-xl-5" id="third_display">
                            <button type="button" class="btn btn-light-info" disabled="disabled" id="third_display_button">Waiting for input!</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal" onclick="reset_bus()">Cancel</button>
                    <button type="button" id="To_recap" class="btn btn-primary font-weight-bold" disabled="disabled" onclick="Update_recap(), Go_to_recap()">Next step</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="Modal_recap" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Bus recap</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reset_bus()">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="my-5">
                                <div class="form-group row">
                                    <label class="col-3">Date</label>
                                    <div class="col-9">
                                        <input class="form-control form-control-solid" disabled="disabled" type="text" value="" id="recap_date">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3">From</label>
                                    <div class="col-9">
                                        <input class="form-control form-control-solid" disabled="disabled" type="text" value="" id="recap_from">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3">To</label>
                                    <div class="col-9">
                                        <input class="form-control form-control-solid" disabled="disabled" type="text" id="recap_to">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3">Number of places</label>
                                    <div class="col-9">
                                        <input class="form-control form-control-solid" disabled="disabled" type="text" id="recap_nb_places">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal" onclick="reset_bus()">Cancel</button>
                    <button type="button" id="Do_virement" class="btn btn-primary font-weight-bold" onclick="Create_bus()">Create the bus</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page.script')
<script>

    var today = new Date();
    console.log(today);

    $('#datepicker').datepicker(

        {

            format: 'yyyy-mm-dd',
            disableTouchKeyboard: true,
            startDate: today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate(),
            todayHighlight: true,
            toggleActive: true,
            weekStart: 1,

        }

    );

</script>
<script>
    function show_modal_first_step() {
        $('#Modal_first_step').modal('show');
    }

    function update_route() {
        document.getElementById('first_wait').style.display = 'block';
        document.getElementById('first_ok').style.display = 'none';
        $("#To_second_step").prop('disabled', 'disabled');

        var from_city = $('#from_city').val();
        var to_city = $('#to_city').val();

        if (from_city == '' || to_city == '') {
            return
        } else {
            document.getElementById('first_wait').style.display = 'none';
            document.getElementById('first_ok').style.display = 'block';
            $("#To_second_step").removeAttr('disabled');
        }
    }

    function Go_to_second_step() {
        $('#Modal_first_step').modal('hide');
        $('#Modal_second_step').modal('show');
    }

    function update_date() {
        var date = $('#datepicker').val();

        document.getElementById('second_display_button').innerHTML = "Waiting for input!";
        $("#To_third_step").prop('disabled', 'disabled');

        if (date != '') {

            document.getElementById('second_display_button').innerHTML = "The bus will be the " + date + " !";
            $("#To_third_step").removeAttr('disabled');
        
        }
    }

    function Go_to_third_step() {
        $('#Modal_second_step').modal('hide');
        $('#Modal_third_step').modal('show');
    }

    function update_nb_places() {
        document.getElementById('third_display_button').innerHTML = "Waiting for input!";
        $("#To_recap").prop('disabled', 'disabled');

        var nb_places = $('#nb_places').val();

        if (nb_places == '') {

            return;

        } else if (!Number.isNaN(Number.parseInt(nb_places)) && nb_places >= 10 && nb_places <= 50) {

            document.getElementById('third_display_button').innerHTML = "There will be " + nb_places + " places in the bus!";
            $("#To_recap").removeAttr('disabled');

        } else {

            document.getElementById('third_display_button').innerHTML = "The input is not a valid one!";

        }
    }

    function Update_recap() {
        $('#recap_date').val($('#datepicker').val());
        $('#recap_from').val($('#from_city').val());
        $('#recap_to').val($('#to_city').val());
        $('#recap_nb_places').val($('#nb_places').val());
    }

    function Go_to_recap() {
        $('#Modal_third_step').modal('hide');
        $('#Modal_recap').modal('show');
    }

    function reset_bus() {
        $('#datepicker').val('');
        $('#from_city').val('');
        $('#to_city').val('');
        $('#nb_places').val('');
        $('#recap_date').val('');
        $('#recap_from').val('');
        $('#recap_to').val('');
        $('#recap_nb_places').val('');
    }


    function Create_bus() {



        $.ajax({
            url:  "/api/v1/admin/create_bus",
            type: 'POST',
            headers:{
                'token':token,
            },
            data:{
                'date' : $('#datepicker').val(),
                'from' : $('#from_city').val(),
                'to' : $('#to_city').val(),
                'nb_places' : $('#nb_places').val(),
            },
            success: function (response) {
                console.log(response);
                window.location.replace("{{route('manage_bus')}}")
            }
        })
    }
</script>
@endsection
