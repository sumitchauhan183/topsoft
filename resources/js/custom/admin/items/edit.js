let edit = function(){
   
    
    let name        = $('#name');
    let quantity       = $('#quantity');
    let price      = $('#price');
    let description   = $('#description');
    let vat     = $('#vat');
    let discount        = $('#discount');
    let status      = $('#status');
    let company     = $('#company');
    let item        = $('#item');
    let baseurl     = '/topsoft/';
    let data = {
        'name':name.val(),
        'quantity':quantity.val(),
        'price':price.val(),
        'description':description.val(),
        'vat':vat.val(),
        'discount':discount.val(),
        'status':status.val(),
        'company':company.val(),
        'item_id':item.val()
    }

    name.mouseout(function(){
        data.name = name.val();
    });

    quantity.mouseout(function(){
        data.quantity = quantity.val();
    });

    price.mouseout(function(){
        data.price = price.val();
    });

    description.mouseout(function(){
        data.description = description.val();
    });

    vat.mouseout(function(){
        data.vat = vat.val();
    });

    discount.mouseout(function(){
        data.discount = discount.val();
    });

    status.mouseout(function(){
        data.status = status.val();
    });



    update.click(function(){
        $('.error').remove();
        if(data.item_id.length < 1){
            name.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*client id is missing</span>');
            return;
        }
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
        

       

        $('.loader').show();
        $.ajax({
            url: baseurl+"api/admin/items/update",
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