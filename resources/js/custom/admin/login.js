let login = function(){
   
    let data = {  
                  email:'',
                  password:''
    }
    
    let email      = $('#email');
    let password   = $('#password');
    let submit     = $('#login');

    let baseurl = '/topsoft/';
  
  email.change(function(){
      data.email = $(this).val();
      if(!validateEmail(data.email)){
        alert('please enter valid email');
        data.email = '';
        email.val('');
      }
      $.ajax({
        type: "POST",
        url: baseurl+"api/admin/mail/check",
        data: { email: data.email }
      })
        .done(function( msg ) {
          d = JSON.parse(msg);
          if(d.error){
             alert(d.message);
             data.email = '';
             email.val('');
          }
        });
  });
  password.change(function(){
      data.password = $(this).val();
      if(data.password.length<8 || data.password.length>16){
        alert('password must have 8-16 characters');
        data.password = '';
        password.val('');
      }
  });
  
  submit.click(function () {
      
      if(data.email==''){
          alert('Please enter your email');
          return;
      }
      if(!validateEmail(data.email)){
          alert('Please enter valid email');
          return;
      }
      if(data.password==''){
          alert('Please enter password');
          return;
      }
      if(data.password.length<8 || data.password.length>16){
        alert('password must have 8-16 characters');
        data.password = '';
        password.val('');
        return;
      }
      $('.loader').show();
      $.ajax({
          url: baseurl+"api/admin/login",
          data: data,
          type: "POST",
          dataType: 'json'
        })
          .done(function( d ) {
            
            $('.loader').hide();
            if(d.error){
               alert(d.message);
               data.password = '';
               password.val('');
            }else{
                window.location.href = baseurl+"admin/dashboard";
            }
          });
  });
  
  function validateEmail($email) {
      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
      return emailReg.test( $email );
    }
  
    return {
      init: function(){
  
      }
  }  
  }();