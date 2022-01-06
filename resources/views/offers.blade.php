@extends('layouts.app')

@section('title', 'Offers')
@section('header.title', 'Partenaires Particuliers')
@section('breadcumb.first.title', 'OFFERS')

@section('page.content')

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <?php
                $host="localhost" ;
                $port=27015;
                $timeout=30;
                try {
                    $sk=fsockopen($host,$port,$errnum,$errstr,$timeout) ;
                    if (!is_resource($sk)) {
                        exit("connection fail: ".$errnum." ".$errstr) ;
                    } else {
                        echo "Connected";
                        fputs($sk, "Bonjour");
                    }
                }
                catch (Exception $e){
                    echo "Connection failed: No connection.";
                }
            ?>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->

@endsection

@section('page.script')

@endsection
