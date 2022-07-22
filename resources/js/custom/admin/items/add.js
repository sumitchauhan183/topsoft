let add = function(){


    let name        = $('#name');
    let quantity       = $('#quantity');
    let price      = $('#price');
    let description   = $('#description');
    let vat     = $('#vat');
    let discount        = $('#discount');
    let status      = $('#status');
    let company     = $('#company');
    let barcode     = $('#barcode');
    let baseurl     = '/topsoft/';
    let add = $("#add-item");
    let data = {
        'name':name.val().trim(),
        'quantity':quantity.val().trim(),
        'price':price.val().trim(),
        'description':description.val().trim(),
        'vat':vat.val().trim(),
        'discount':discount.val().trim(),
        'status':status.val().trim(),
        'barcode':barcode.val().trim(),
        'company_id':company.val().trim()
    }

    name.mouseout(function(){
        data.name = name.val().trim();
    });

    quantity.mouseout(function(){
        data.quantity = quantity.val().trim();
    });

    price.mouseout(function(){
        data.price = price.val().trim();
    });

    description.mouseout(function(){
        data.description = description.val().trim();
    });

    company.change(function(){
        data.company_id = company.val().trim();
    });

    vat.mouseout(function(){
        data.vat = vat.val().trim();
    });

    discount.mouseout(function(){
        data.discount = discount.val().trim();
    });

    status.change(function(){
        data.status = status.val().trim();
    });

    barcode.change(function(){
        data.barcode = barcode.val().trim();
    });



    add.click(function(){
        $('.error').remove();
        if(data.name.length < 1){
            name.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }
        if(data.quantity < 1){
            quantity.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }

        if(data.price < 1){
            price.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }

        if(data.description.length < 1){
            description.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }
        if(data.company_id == ""){
            company.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }

        if(data.vat == ""){
            vat.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }

        if(data.discount == ""){
            discount.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }
        if(data.status == ""){
            status.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }

        if(data.barcode == ""){
            barcode.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }

        $('.loader').show();
        $.ajax({
            url: baseurl+"api/admin/items/add",
            data: data,
            type: "POST",
            dataType: 'json'
          })
        .done(function( d ) {
              $('.loader').hide();
              if(d.error){
                alert(d.message);
              }else{
                  alert(d.message);
                  location.reload();
              }
        });



    });

    return {
      init: function(){
      }
  }
  }();
