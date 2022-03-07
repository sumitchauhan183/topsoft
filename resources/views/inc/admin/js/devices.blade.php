

  @if($url=='devices/add')
  
  <script src="{{asset('js/custom/admin/devices/add.js')}}"></script>
  <script>
        //close the alert after 3 seconds.
        document.onload = add.init(); 
    </script>
  @endif

  @if($url=='devices/edit')
  
  <script src="{{asset('js/custom/admin/devices/edit.js')}}"></script>
  <script>
        //close the alert after 3 seconds.
        document.onload = edit.init(); 
    </script>
  @endif

  @if($url=='devices')
  <script type="text/javascript" charset="utf8" src="{{asset('DataTables/datatables.js')}}"></script>
  <script src="{{asset('js/custom/admin/devices/list.js')}}"></script>
  <script>
        //close the alert after 3 seconds.
        document.onload = list.init(); 
    </script>
  @endif