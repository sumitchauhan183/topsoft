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
                            <div class="input-group input-group-outline mx-3 focused is-focused">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" value="{{$client->name}}" autocomplete="off">
                                <input type="hidden" class="form-control" id="client_id" value="{{$client->client_id}}" autocomplete="off">
                            </div>
                            <div class="input-group input-group-outline mx-3 focused is-focused">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" disabled value="{{$client->email}}" readonly autocomplete="off">
                            </div>
                            <div class="input-group input-group-outline mx- focused is-focused">
                                <label class="form-label">Mobile</label>
                                <input type="number" class="form-control" id="mobile" value="{{$client->mobile}}"  autocomplete="off">
                            </div>
                            <div class="input-group input-group-outline mx-3 focused is-focused">
                                <label class="form-label">Telephone</label>
                                <input type="number" class="form-control" id="telephone" value="{{$client->telephone}}"  autocomplete="off">
                            </div>
                    </div>
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center  mb-4">
                            <div class="input-group input-group-outline mx-3  focused is-focused">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" value="{{$client->address}}"  autocomplete="off">
                            </div>
                            <div class="input-group input-group-outline mx-3  focused is-focused">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control" id="city" value="{{$client->city}}"  autocomplete="off">
                            </div>
                            <div class="input-group input-group-outline mx-3  focused is-focused">
                                <label class="form-label">Region</label>
                                <input type="text" class="form-control" id="region" value="{{$client->region}}"  autocomplete="off">
                            </div>
                            <div class="input-group input-group-outline mx-3  focused is-focused">
                                <label class="form-label">postal Code</label>
                                <input type="text" class="form-control" id="postal-code" value="{{$client->postal_code}}"  autocomplete="off">
                            </div>
                    </div>
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center mb-4">
                            <div class="input-group input-group-outline mx-3  focused is-focused">
                                <label class="form-label">Tax Number</label>
                                <input type="text" class="form-control" id="tax-number" value="{{$client->tax_number}}"  autocomplete="off">
                            </div>
                            <div class="input-group input-group-outline mx-3  focused is-focused">
                                <label class="form-label">Tax Post</label>
                                <input type="text" class="form-control" id="tax-post" value="{{$client->tax_post}}"  autocomplete="off">
                            </div>
                            <div class="input-group input-group-outline mx-3 focused is-focused"> 
                                <label class="form-label">Occupation</label>
                                <input type="text" class="form-control" id="occupation" value="{{$client->occupation}}"  autocomplete="off">
                            </div>
                            <div class="input-group input-group-outline mx-3 focused is-focused"> 
                                <label class="form-label">Discount</label>
                                <input type="text" class="form-control" id="discount" value="{{$client->discount}}"  autocomplete="off">
                            </div>
                            
                    </div>

                    <div class="ms-md-auto pe-md-3 d-flex align-items-center  mb-4">
                            
                            <div class="input-group input-group-outline mx-3 focused is-focused">
                                <label class="form-label">Note</label>
                                <input type="text" class="form-control" id="note" value="{{$client->note}}"  autocomplete="off">
                            </div>
                            <div class="input-group input-group-outline mx-3 focused is-focused"> 
                                <label class="form-label">Note 2</label>
                                <input type="text" class="form-control" id="note2" value="{{$client->note2}}"  autocomplete="off">
                            </div>
                    </div>


                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    <div class="sidenav-footer w-100 bottom-0 ">
                        <div class="mx-3 text-center">
                            <button class="btn bg-gradient-primary mt-4 w-40" id="update-clients"  type="button">Update</button>
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