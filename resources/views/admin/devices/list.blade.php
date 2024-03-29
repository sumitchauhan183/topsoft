@extends('layouts.admin.dapp')
@section('content')
@php 
  $device_count = count($devices);
  //echo $device_count;
  //echo '<pre>';print_r($licence);die();
@endphp
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{$title}}</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">{{$title}} > List</h6>
        </nav>
          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none">{{$admin->name}}</span>
              </a>
            </li>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0">
                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3 inline">{{$title}}</h6>
                @if(date('Y-m-d',strtotime($licence->expiration_date)) >= date('Y-m-d'))
                @if($device_count < $licence->device_count):
                <button class="btn revert fl-rgt inline">
                   <a href="app-users/add"> <i class="material-icons py-2 add-icon" title="Add new client">add</i></a>
                </button>
                @endif
                @else
                   <span style="color:black;float: right;margin-right: 20px;"> Licence Expired on {{date('d M Y',strtotime($licence->expiration_date))}} </span> 
                @endif
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <input type="hidden" id="company_id" value="{{$company_id}}"> 
              <div class="table-responsive p-0 mx-4">
                <table class="table align-items-center justify-content-center mb-0" id="devices_table">
                  <thead>
                    <tr>
                      <th class="text-uppercase  text-xxs font-weight-bolder opacity-7">Device ID</th>
                      <th class="text-uppercase  text-xxs font-weight-bolder opacity-7">Email</th>
                      <th class="text-uppercase  text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-uppercase  text-xxs font-weight-bolder opacity-7">Created on</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </main>
@endsection