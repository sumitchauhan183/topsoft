@if($url=='company')
  
  <script type="text/javascript" charset="utf8" src="{{asset('DataTables/datatables.js')}}"></script>
  <script src="{{asset('js/custom/admin/company/list.js')}}"></script>
  <script>
        //close the alert after 3 seconds.
        $(document).ready(function(){
          list.init(); 
        });
    </script>
  @endif

  @if($url=='company/add')
  
  <script src="{{asset('js/custom/admin/company/add.js')}}"></script>
  <script>
        //close the alert after 3 seconds.
        document.onload = add.init(); 
    </script>
  @endif

  @if($url=='company/edit')
  
  <script src="{{asset('js/custom/admin/company/edit.js')}}"></script>
  <script>
        //close the alert after 3 seconds.
        document.onload = edit.init(); 
    </script>
  @endif