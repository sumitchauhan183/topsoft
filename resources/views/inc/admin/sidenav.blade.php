<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
   
    <div class="collapse navbar-collapse  w-auto"  id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white @if($main=='dashboard') active bg-gradient-primary @endif " href="{{route('admin.dashboard')}}">
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link text-white @if($main=='company') active bg-gradient-primary @endif"  href="{{route('admin.company.list')}}">
            <span class="nav-link-text ms-1">Company</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white  @if($main=='clients') active bg-gradient-primary @endif " href="{{route('admin.clients.list')}}">
            <span class="nav-link-text ms-1">Clients</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white  @if($main=='items') active bg-gradient-primary @endif"  href="{{route('admin.items.list')}}">
            <span class="nav-link-text ms-1">Items</span>
          </a>
        </li>
        <li class="nav-item">
        <a class="nav-link text-white  @if($main=='invoices') active bg-gradient-primary @endif"  href="{{route('admin.invoices.list')}}">
            <span class="nav-link-text ms-1">Invoices</span>
          </a>
        </li>
        <li class="nav-item">
        <a class="nav-link text-white  @if($main=='receipts') active bg-gradient-primary @endif"  href="{{route('admin.receipts.list')}}">
            <span class="nav-link-text ms-1">Receipts</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="{{route('admin.logout')}}">
            
            <span class="nav-link-text ms-1">Logout</span>
          </a>
        </li>
      </ul>
    </div>
    
  </aside>