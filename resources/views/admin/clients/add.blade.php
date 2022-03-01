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
          <h6 class="font-weight-bolder mb-0">Clients > Add New</h6>
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
                            <div class="input-group input-group-outline mx-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" onfocus="focused(this)" onfocusout="defocused(this)" autocomplete="off">
                            </div>
                            <div class="input-group input-group-outline mx-3">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" onfocus="focused(this)" onfocusout="defocused(this)" autocomplete="off">
                            </div>
                            <div class="input-group input-group-outline mx-3">
                                <label class="form-label">Mobile</label>
                                <input type="number" class="form-control" id="mobile" onfocus="focused(this)" onfocusout="defocused(this)" autocomplete="off">
                            </div>
                            <div class="input-group input-group-outline mx-3">
                                <label class="form-label">Telephone</label>
                                <input type="number" class="form-control" id="telephone" onfocus="focused(this)" onfocusout="defocused(this)" autocomplete="off">
                            </div>
                    </div>
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center  mb-4">
                            <div class="input-group input-group-outline mx-3">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" onfocus="focused(this)" onfocusout="defocused(this)" autocomplete="off">
                            </div>
                            <div class="input-group input-group-outline mx-3">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control" id="city" onfocus="focused(this)" onfocusout="defocused(this)" autocomplete="off">
                            </div>
                            <div class="input-group input-group-outline mx-3">
                                <label class="form-label">Region</label>
                                <input type="text" class="form-control" id="region" onfocus="focused(this)" onfocusout="defocused(this)" autocomplete="off">
                            </div>
                            <div class="input-group input-group-outline mx-3">
                                <label class="form-label">postal Code</label>
                                <input type="text" class="form-control" id="postal-code" onfocus="focused(this)" onfocusout="defocused(this)" autocomplete="off">
                            </div>
                    </div>
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center mb-4">
                            <div class="input-group input-group-outline mx-3">
                                <label class="form-label">Tax Number</label>
                                <input type="text" class="form-control" id="tax-number" onfocus="focused(this)" onfocusout="defocused(this)" autocomplete="off">
                            </div>
                            <div class="input-group input-group-outline mx-3">
                                <label class="form-label">Tax Post</label>
                                <input type="text" class="form-control" id="tax-post" onfocus="focused(this)" onfocusout="defocused(this)" autocomplete="off">
                            </div>
                            <div class="input-group input-group-outline mx-3"> 
                                <label class="form-label">Occupation</label>
                                <input type="text" class="form-control" id="occupation" onfocus="focused(this)" onfocusout="defocused(this)" autocomplete="off">
                            </div>
                            <div class="input-group input-group-outline mx-3"> 
                                <label class="form-label">Discount</label>
                                <input type="text" class="form-control" id="discount" onfocus="focused(this)" onfocusout="defocused(this)" autocomplete="off">
                            </div>
                            
                    </div>

                    <div class="ms-md-auto pe-md-3 d-flex align-items-center  mb-4">
                            
                            <div class="input-group input-group-outline mx-3">
                                <label class="form-label">Note</label>
                                <input type="text" class="form-control" id="note" onfocus="focused(this)" onfocusout="defocused(this)" autocomplete="off">
                            </div>
                            <div class="input-group input-group-outline mx-3"> 
                                <label class="form-label">Note 2</label>
                                <input type="text" class="form-control" id="note2" onfocus="focused(this)" onfocusout="defocused(this)" autocomplete="off">
                            </div>
                    </div>

                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    <div class="sidenav-footer w-100 bottom-0 ">
                        <div class="mx-3 text-center">
                            <button class="btn bg-gradient-primary mt-4 w-40 " id="add-client" type="button">Add</button>
                        </div>
                    </div>
                            
                    </div>


              </div>
          </div>
        </div>
      </div>

    </div>
  </main>
@endsection