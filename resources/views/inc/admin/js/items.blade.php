@if($url=='items')
  
  <script type="text/javascript" charset="utf8" src="{{asset('DataTables/datatables.js')}}"></script>
  <script src="{{asset('js/custom/admin/items/list.js')}}"></script>
  <script>
        //close the alert after 3 seconds.
        $(document).ready(function(){
          list.init(); 
        });
    </script>
  @endif

  @if($url=='items/add')
  
  <script src="{{asset('js/custom/admin/items/add.js')}}"></script>
  <script>
        //close the alert after 3 seconds.
        document.onload = add.init(); 
    </script>
  @endif

  @if($url=='items/edit')
  
  <script src="{{asset('js/custom/admin/items/edit.js')}}"></script>
  <script>
        //close the alert after 3 seconds.
        document.onload = edit.init(); 
    </script>
  @endif