@if($url=='invoices')
  
  <script type="text/javascript" charset="utf8" src="{{asset('DataTables/datatables.js')}}"></script>
  <script src="{{asset('js/custom/admin/invoices/list.js')}}"></script>
  <script>
        //close the alert after 3 seconds.
        $(document).ready(function(){
          list.init(); 
        });
    </script>
  @endif