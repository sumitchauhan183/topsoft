@extends('layouts.admin.dapp')
@section('content')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{$title}}</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Company > Add New</h6>
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
              </div>
            </div>
            <div class="card-body px-0 pb-2">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center mb-4">
                            <div class="input-group input-group-outline mx-3 focused is-focused">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" readonly value="{{$company->name}}" autocomplete="off">
                            </div>
                            <div class="input-group input-group-outline mx-3 focused is-focused">
                                <label class="form-label">Greek Name</label>
                                <input type="text" class="form-control" id="greek-name" value="{{$company->greek_name}}" readonly autocomplete="off">
                            </div>
                            <div class="input-group input-group-outline mx- focused is-focused">
                                <label class="form-label">Email (Public key)</label>
                                <input type="email" class="form-control" id="email" value="{{$company->public_key}}" readonly autocomplete="off">
                            </div>
                    </div>
                <div class="ms-md-auto pe-md-3 d-flex align-items-center mb-4">

                    <div class="input-group input-group-outline mx-3 is-filled">
                        <label class="form-label">Mobile</label>
                        <input type="text" class="form-control" id="mobile" onfocus="focused(this)" readonly onfocusout="defocused(this)" value="{{$company->mobile}}" autocomplete="off">
                    </div>
                    <div class="input-group input-group-outline mx-3 is-filled">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" id="address" onfocus="focused(this)" readonly onfocusout="defocused(this)"  autocomplete="off">{{$company->address}}</textarea>
                    </div>
                    <div class="input-group input-group-outline mx-3 is-filled">
                        <label class="form-label">City</label>
                        <input type="text" class="form-control" id="city" onfocus="focused(this)" readonly onfocusout="defocused(this)" value="{{$company->city}}" autocomplete="off">
                    </div>
                </div>
                <div class="ms-md-auto pe-md-3 d-flex align-items-center mb-4">

                    <div class="input-group input-group-outline mx-3 is-filled">
                        <label class="form-label">Region</label>
                        <input type="text" class="form-control" id="region" onfocus="focused(this)" readonly onfocusout="defocused(this)" value="{{$company->region}}" autocomplete="off">
                    </div>
                    <div class="input-group input-group-outline mx-3 is-filled">
                        <label class="form-label">Postal Code</label>
                        <input type="text" class="form-control" id="postal_code" onfocus="focused(this)" readonly onfocusout="defocused(this)" value="{{$company->postal_code}}" autocomplete="off">
                    </div>
                </div>

              </div>
          </div>
        </div>
      </div>

    </div>
  </main>
@endsection
