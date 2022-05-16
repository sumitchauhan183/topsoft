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
          <h6 class="font-weight-bolder mb-0">Items > Add New</h6>
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
                            <div class="input-group input-group-outline mx-3 is-focused">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" autocomplete="off">
                            </div>
                            <div class="input-group input-group-outline mx-3 is-focused">
                                <label class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" autocomplete="off">
                            </div>
                            <div class="input-group input-group-outline mx-3 is-focused">
                                <label class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" autocomplete="off">
                            </div>
                            <div class="input-group input-group-outline mx-3 is-focused">
                                <label class="form-label">Description</label>
                                <textarea id="description" class="form-control"  autocomplete="off"></textarea>
                            </div>
                    </div>
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center  mb-4">
                    <div class="input-group input-group-outline mx-3 focused is-focused" >
                                <label class="form-label">Company</label>
                                <select class="form-control" id="company_id" >
                                  <option value="">Select Company</option>
                                  @foreach ($companies as $c)
                                      <option value="{{$c->company_id}}">{{$c->name}}</option>
                                  @endforeach
                                </select> 
                            </div>
                            <div class="input-group input-group-outline mx-3 is-focused">
                                <label class="form-label">VAT</label>
                                <input type="text" class="form-control" id="vat"  autocomplete="off">
                            </div>
                            <div class="input-group input-group-outline mx-3 is-focused">
                                <label class="form-label">Discount</label>
                                <input type="text" class="form-control" id="discount"  autocomplete="off">
                            </div>
                            <div class="input-group input-group-outline mx-3 is-focused">
                                <label class="form-label">Status</label>
                                <select class="form-control" id="status" >
                                  <option value="">Select Status</option>
                                  <option value="available">Available</option>
                                  <option value="out of stock">Out of Stock</option>
                                </select> 
                            </div>

                            
                    </div>

                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    <div class="sidenav-footer w-100 bottom-0 ">
                        <div class="mx-3 text-center">
                            <button class="btn bg-gradient-primary mt-4 w-40 " id="add-item" type="button">Add</button>
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