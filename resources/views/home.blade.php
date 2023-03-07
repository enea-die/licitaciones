@extends('layouts.app')

@section('contentHeader')
<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Home
    <span class="h-20px border-1 border-gray-200 border-start ms-3 mx-2 me-1"></span>
    <span class="text-muted fs-7 fw-bold ms-2">Mack Servicios</span>
</h1>
@endsection

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="row gy-5 g-xl-8">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body p-1" style="text-align: center;">
                    <br><br>
                    <img src="{{ url('extras/images/home/principal.png') }}" width="75%">
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
