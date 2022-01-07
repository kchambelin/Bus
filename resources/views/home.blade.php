@extends('layouts.app')

@section('title', 'Home')
@section('header.title', 'Partenaires Particuliers')
@section('breadcumb.first.title', 'HOME')

@section('page.content')


    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card card-custom card-stretch gutter-b bg-light-success">
                        <div class="card-header">
                            <div class="card-title">
                                <span class="card-icon">
                                    <i class="flaticon-truck text-primary"></i>
                                </span>
                                <h3 class="card-label">
                                    Partenaires Particuliers 
                                    <small>
                                        Company presentation 
                                    </small>
                                </h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Main presentation</h5>
                            Partenaires Particuliers is a French company dedicated in trucks transport. But, since January 2022, the company has made the decision to become a bus company.<br><br><br>
                            Our buses travel accross the whole Europe, but there are especially in France for now.<br><br><br>
                            You can see all our buses in the page Our buses. There, you will be able to purchase seats for your journey.
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->

@endsection

@section('page.script')

@endsection
