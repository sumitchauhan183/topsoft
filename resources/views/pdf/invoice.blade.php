<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
  <!-- Meta Tags -->
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="ThemeMarch">
  <!-- Site Title -->
  <title>General Invoice</title>
  <link rel="stylesheet" href="{{asset('pdf/style.css')}}">
</head>

<body>
  <div class="cs-container">
    <div class="cs-invoice cs-style1">
      <div class="cs-invoice_in" id="download_section">
          <div class="cs-invoice_head cs-type1 cs-mb25" style="height:60px;">
             <div class="cs-invoice_left">
            <p class="cs-invoice_number cs-primary_color cs-mb5 cs-f16"><b class="cs-primary_color">Invoice No:</b> #{{$data->invoice_number}}</p>
            <p class="cs-invoice_date cs-primary_color cs-m0"><b class="cs-primary_color">Date: </b>{{date('d M Y', strtotime($data->created_at))}}</p>
          </div>

          </div>
          <div class="cs-invoice_head cs-mb10" style="min-height:125px;">
              <div class="cs-invoice_left">
                  <b class="cs-primary_color">Invoice To:</b>
                  <p>

                      {{$data->client->name}}
                      @if($data->client->address),
                          <br>{{$data->client->address}}
                          @if($data->client->city),
                              {{$data->client->city}}
                          @endif
                      @else
                          @if($data->client->city),
                              <br>{{$data->client->city}}
                          @endif
                      @endif
                      @if($data->client->region),
                          <br>{{$data->client->region}}
                          @if($data->client->postal_code),
                              {{$data->client->postal_code}}
                          @endif
                      @else
                          @if($data->client->postal_code),
                              <br>{{$data->client->postal_code}}
                          @endif
                      @endif
                      @if($data->client->email),
                          <br>Email: {{$data->client->email}}
                      @endif
                      @if($data->client->mobile),
                          <br>Mobile: {{$data->client->mobile}}
                      @endif
                  </p>
              </div>
              <div class="cs-invoice_right cs-text_right">
                  <b class="cs-primary_color">Pay To:</b>
                  <p>
                      {{$data->company->name}}
                      @if($data->company->address),
                          <br>{{$data->company->address}}
                          @if($data->company->city),
                              {{$data->company->city}}
                          @endif
                      @else
                          @if($data->company->city),
                              <br>{{$data->company->city}}
                          @endif
                      @endif
                      @if($data->company->region),
                          <br>{{$data->company->region}}
                          @if($data->company->postal_code),
                              {{$data->company->postal_code}}
                          @endif
                      @else
                          @if($data->company->postal_code),
                              <br>{{$data->client->postal_code}}
                          @endif
                      @endif
                      @if($data->company->public_key),
                          <br>Email: {{$data->company->public_key}}
                      @endif
                      @if($data->company->mobile),
                          <br>Mobile: {{$data->company->mobile}}
                      @endif
                  </p>
              </div>
          </div>
        <div class="cs-table cs-style1">
          <div class="cs-round_border">
            <div class="cs-table_responsive">
              <table>
                <thead>
                  <tr>
                    <th class="cs-width_2 cs-semi_bold cs-primary_color cs-focus_bg">Item</th>
                    <th class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg">Description</th>
                    <th class="cs-width_1 cs-semi_bold cs-primary_color cs-focus_bg">Qty</th>
                    <th class="cs-width_1 cs-semi_bold cs-primary_color cs-focus_bg">Price</th>
                    <th class="cs-width_1 cs-semi_bold cs-primary_color cs-focus_bg">Vat(%)</th>
                    <th class="cs-width_2 cs-semi_bold cs-primary_color cs-focus_bg cs-text_right">Total</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                      $total = 0;
                      $stotal = 0;
                      $tax   = 0;
                      $discount = 0;
                      $qty = 0;
                    @endphp
                    @foreach ($data->item_list as $item)
                        @php
                            $stotal += $item->price*$item->quantity;
                            //$discount   += $item->price * ($item->discount/100);
                            $vat = ($item->price * ($item->vat/100))*$item->quantity;
                            $tax   += $vat;
                            $qty += $item->quantity;
                        @endphp
                        <tr>
                            <td class="cs-width_2">{{$item->name}}</td>
                            <td class="cs-width_3">{{$item->description}}</td>
                            <td class="cs-width_1">{{$item->quantity}}</td>
                            <td class="cs-width_1">{{$item->price}}</td>
                            <td class="cs-width_1">{{$item->vat}}</td>
                            <td class="cs-width_2 cs-text_right">{{round(($item->price*$item->quantity)+$vat,2)}}</td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            <div class="cs-invoice_footer cs-border_top">
              <div class="cs-left_footer cs-mobile_hide">
                <p class="cs-mb0"><b class="cs-primary_color">Additional Information:</b></p>
                <p class="cs-m0">At check in you may need to present the credit <br>card used for payment of this ticket.</p>
              </div>
              <div class="cs-right_footer">
                  @php
                      $discount = ($data->client->discount/100)*($stotal+$tax);
                  @endphp
                <table>
                  <tbody>
                  <tr class="cs-border_left">
                      <td class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg">Total QTY</td>
                      <td class="cs-width_3 cs-semi_bold cs-focus_bg cs-primary_color cs-text_right">{{$qty}}</td>
                  </tr>
                    <tr class="cs-border_left">
                      <td class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg">Subtoal</td>
                      <td class="cs-width_3 cs-semi_bold cs-focus_bg cs-primary_color cs-text_right">{{round($stotal,2)}}</td>
                    </tr>
                    <tr class="cs-border_left">
                        <td class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg">Tax</td>
                        <td class="cs-width_3 cs-semi_bold cs-focus_bg cs-primary_color cs-text_right">{{round($tax,2)}}</td>
                    </tr>
                    <tr class="cs-border_left">
                      <td class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg">Discount({{$data->client->discount}}%)</td>
                      <td class="cs-width_3 cs-semi_bold cs-focus_bg cs-primary_color cs-text_right">{{round($discount,2)}}</td>
                    </tr>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="cs-invoice_footer">
            <div class="cs-left_footer cs-mobile_hide"></div>
            <div class="cs-right_footer">
              <table>
                <tbody>
                  <tr class="cs-border_none">
                    <td class="cs-width_3 cs-border_top_0 cs-bold cs-f16 cs-primary_color">Grand Total</td>
                    <td class="cs-width_3 cs-border_top_0 cs-bold cs-f16 cs-primary_color cs-text_right">{{round(($stotal+$tax)-$discount,2)}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="cs-note">
          <div class="cs-note_left">
            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path d="M416 221.25V416a48 48 0 01-48 48H144a48 48 0 01-48-48V96a48 48 0 0148-48h98.75a32 32 0 0122.62 9.37l141.26 141.26a32 32 0 019.37 22.62z" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><path d="M256 56v120a32 32 0 0032 32h120M176 288h160M176 368h160" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/></svg>
          </div>
          <div class="cs-note_right">
            <p class="cs-mb0"><b class="cs-primary_color cs-bold">Note:</b></p>
            <p class="cs-m0">Here we can write a additional notes for the client to get a better understanding of this invoice.</p>
          </div>
        </div><!-- .cs-note -->
      </div>
    </div>
  </div>
</body>
</html>
