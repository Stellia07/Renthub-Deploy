<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            Tenant<span>Hub</span>
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
                <a href="{{ route('tenant.dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <!-- Additional tenant-specific links here -->
            @if(Auth::check() && Auth::user()->status == 'active')
            <!-- Existing Resources section -->

            <li class="nav-item nav-category">Payments</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#payments" role="button" aria-expanded="false" aria-controls="payments">
                    <i class="link-icon" data-feather="credit-card"></i>
                    <span class="link-title">Payments</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="payments">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('pay') }}" class="nav-link">Pay</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('view-payment-logs') }}" class="nav-link">Payment Logs</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item nav-category">Lease Agreement</li>
            <li class="nav-item">
                <a href="{{ route('my.lease.agreement') }}" class="nav-link">
                    <i class="link-icon" data-feather="file"></i>
                    <span class="link-title">Lease Agreement</span>
                </a>
            </li>
            
            <li class="nav-item nav-category">Utilities</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#utilities" role="button" aria-expanded="false" aria-controls="utilities">
                    <i class="link-icon" data-feather="sliders"></i>
                    <span class="link-title">Utilities</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="utilities">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('electricity.billing') }}" class="nav-link">Electricity</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('water.billing') }}" class="nav-link">Water</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('rent.billing') }}" class="nav-link">Rent Billing</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif
        </ul>
    </div>
</nav>