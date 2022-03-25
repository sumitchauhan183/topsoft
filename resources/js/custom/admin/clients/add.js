let add = function(){
   
    
    let name        = $('#name');
    let email       = $('#email');
    let mobile      = $('#mobile');
    let telephone   = $('#telephone');
    let address     = $('#address');
    let city        = $('#city');
    let region      = $('#region');
    let postalCode  = $('#postal-code');
    let taxNumber   = $('#tax-number');
    let taxPost     = $('#tax-post');
    let discount    = $('#discount');
    let occupation  = $('#occupation');
    let note        = $('#note');
    let note2       = $('#note2');
    let add         = $('#add-client');
    let company     = $('#company_id');
    let baseurl     = '/topsoft/';
    let data = {
        'name':name.val(),
        'email':email.val(),
        'mobile':mobile.val(),
        'telephone':telephone.val(),
        'address':address.val(),
        'city':city.val(),
        'region':region.val(),
        'postalCode':postalCode.val(),
        'taxNumber':taxNumber.val(),
        'taxPost':taxPost.val(),
        'discount':discount.val(),
        'occupation':occupation.val(),
        'company_id':company.val(),
        'note':note.val(),
        'note2':note2.val()
    }

    name.mouseout(function(){
        data.name = name.val();
    });

    email.mouseout(function(){
        data.email = email.val();
    });

    mobile.mouseout(function(){
        data.mobile = mobile.val();
    });

    telephone.mouseout(function(){
        data.telephone = telephone.val();
    });

    address.mouseout(function(){
        data.address = address.val();
    });

    city.mouseout(function(){
        data.city = city.val();
    });

    region.mouseout(function(){
        data.region = region.val();
    });

    postalCode.mouseout(function(){
        data.postalCode = postalCode.val();
    });

    taxNumber.mouseout(function(){
        data.taxNumber = taxNumber.val();
    });

    taxPost.mouseout(function(){
        data.taxPost = taxPost.val();
    });

    discount.mouseout(function(){
        data.discount = discount.val();
    });

    occupation.mouseout(function(){
        data.occupation = occupation.val();
    });

    company.change(function(){
        data.company_id=company.val();
    });

    note.mouseout(function(){
        data.note = note.val();
    });

    note2.mouseout(function(){
        data.note2 = note2.val();
    });

    function validateEmail(){
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(data.email))
             {
               return (false)
             }
               return (true)
        
    }

    function checkEmailExist(){
        $('.loader').show();
        $.ajax({
            url: baseurl+"api/admin/clients/check/email",
            data: data,
            type: "POST",
            dataType: 'json'
          })
            .done(function( d ) {
              $('.loader').hide();
              if(d.error){
                 return d.message;
              }else{
                  return false;
              }
            });
    
}

    add.click(function(){
        $('.error').remove();
        if(data.name.length < 1){
            name.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }
        if(data.email.length < 1){
            email.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }else if(validateEmail()){
            email.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*You have entered an invalid email address!</span>');
            return;
        }else if(checkEmailExist()){
            email.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*email already used for other client</span>');
            return;
        }

        if(data.mobile.length < 1){
            mobile.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }

        if(data.telephone.length < 1){
            telephone.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }

        if(data.address.length < 1){
            address.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }

        if(data.city.length < 1){
            city.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }

        if(data.region.length < 1){
            region.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }

        if(data.postalCode.length < 1){
            postalCode.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }

        if(data.taxNumber.length < 1){
            taxNumber.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }

        if(data.taxPost.length < 1){
            taxPost.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }

       
        if(data.occupation.length < 1){
            occupation.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }
         
        if(data.company_id == ""){
            company.parent().append('<span class="text-danger position-absolute text-gradient text-xs py-3 mt-4 error">*required</span>');
            return;
        }

        $('.loader').show();
        $.ajax({
            url: baseurl+"api/admin/clients/add",
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