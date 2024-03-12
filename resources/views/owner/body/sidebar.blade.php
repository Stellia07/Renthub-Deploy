@php
$id = Auth::user()->id;
$ownerId = App\Models\User::find($id);
$status = $ownerId->status;
@endphp


<nav class="sidebar">
  <div class="sidebar-header">
    <a href="#" class="sidebar-brand">
      Rent<span>Hub</span>
    </a>
    <div class="sidebar-toggler not-active">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="sidebar-body">
    <ul class="nav">
      <li class="nav-item nav-category">Main</li>
      <li class="nav-item">
        <a href="{{ route('owner.dashboard') }}" class="nav-link">
          <i class="link-icon" data-feather="box"></i>
          <span class="link-title">Dashboard</span>
        </a>
      </li>

      @if($status === 'active')

      <li class="nav-item nav-category">Manage Property</li>



      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#property" role="button" aria-expanded="false" aria-controls="emails">
          <i class="link-icon" data-feather="mail"></i>
          <span class="link-title">Property</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="property">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ route('owner.all.property') }}" class="nav-link">All Property</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('owner.add.property') }}" class="nav-link">Add Property</a>
            </li>
          </ul>
        </div>
      </li>

      <!-- <li class="nav-item">
        <a href="{{ route('buy.package') }}" class="nav-link">
          <i class="link-icon" data-feather="calendar"></i>
          <span class="link-title">Buy Package</span>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('package.history') }}" class="nav-link">
          <i class="link-icon" data-feather="calendar"></i>
          <span class="link-title">Package History</span>
        </a>
      </li> -->

      <li class="nav-item">
        <a href="{{ route('owner.property.message') }}" class="nav-link">
          <i class="link-icon" data-feather="calendar"></i>
          <span class="link-title">Property Message</span>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('owner.schedule.request') }}" class="nav-link">
          <i class="link-icon" data-feather="calendar"></i>
          <span class="link-title">Schedule Request </span>
        </a>
      </li>

      <li class="nav-item nav-category">Components</li>

      <li class="nav-item">
        <a href="{{ route('owner.live.chat') }}" class="nav-link">
          <i class="link-icon" data-feather="calendar"></i>
          <span class="link-title">Live Chat </span>

          @php
          $unreadCount = app(\App\Http\Controllers\Backend\ChatController::class)->getUnreadMessageCount();
          @endphp
          @if ($unreadCount > 0)
          <span class="badge badge-info">{{ $unreadCount }}</span>
          @endif
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#tenants" role="button" aria-expanded="false" aria-controls="emails">
          <i class="link-icon" data-feather="mail"></i>
          <span class="link-title">Manage Tenants</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="tenants">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ route('owner.tenant.request') }}" class="nav-link">Tenant Request</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('owner.tenant.manager') }}" class="nav-link">Tenants</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('owner.payment.logs') }}" class="nav-link">View Payment Logs</a>
            </li>
          </ul>
        </div>
      </li>

      @else

      @endif


      <li class="nav-item nav-category">Docs</li>
      <li class="nav-item">
        <a href="#">
          <i class="link-icon" data-feather="hash"></i>
          <span class="link-title">Documentation</span>
        </a>
      </li>
    </ul>
  </div>
</nav>