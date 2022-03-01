@if($url=='clients')
  
  <script type="text/javascript" charset="utf8" src="{{asset('DataTables/datatables.js')}}"></script>
  <script src="{{asset('js/custom/admin/clients/list.js')}}"></script>
  <script>
        //close the alert after 3 seconds.
        $(document).ready(function(){
          list.init(); 
        });
    </script>
  @endif

  @if($url=='clients/add')
  
  <script src="{{asset('js/custom/admin/clients/add.js')}}"></script>
  <script>
        //close the alert after 3 seconds.
        document.onload = add.init(); 
    </script>
  @endif

  @if($url=='clients/edit')
  
  <script src="{{asset('js/custom/admin/clients/edit.js')}}"></script>
  <script>
        //close the alert after 3 seconds.
        document.onload = edit.init(); 
    </script>
  @endif