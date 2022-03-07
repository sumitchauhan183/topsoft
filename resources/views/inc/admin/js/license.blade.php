

  @if($url=='license/add')
  
  <script src="{{asset('js/custom/admin/license/add.js')}}"></script>
  <script>
        //close the alert after 3 seconds.
        document.onload = add.init(); 
    </script>
  @endif

  @if($url=='license/edit')
  
  <script src="{{asset('js/custom/admin/license/edit.js')}}"></script>
  <script>
        //close the alert after 3 seconds.
        document.onload = edit.init(); 
    </script>
  @endif