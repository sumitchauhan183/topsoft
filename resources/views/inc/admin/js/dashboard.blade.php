@if($url=='dashboard')
  <script src="{{asset('js/custom/admin/dashboard.js')}}"></script>
  <script>
        //close the alert after 3 seconds.
        $(document).ready(function(){
          dashboard.init(); 
        });
    </script>
  @endif