  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{ route('home') }}" class="brand-link text-center" style="text-decoration: none;">
          {{-- <img src="{{ asset('backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
          <i class="fa fa-paw"></i>
          <span class="brand-text font-weight-light">Dashboard</span>
      </a>
      
      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  @php
                      $profile = \Modules\Setting\Entities\CompanyProfile::first();
                  @endphp
                  <img src="{{ asset('upload/images/settings/' . $profile->logo) }}" class="img-circle elevation-2"
                      alt="User Image">
              </div>
              <div class="info">
                  <a href="{{ route('home') }}" class="d-block"
                      style="text-decoration: none;">{{ $profile->company_name }}</a>
              </div>
          </div>

          <!-- SidebarSearch Form -->
          <div class="form-inline">
              <div class="input-group" data-widget="sidebar-search">
                  <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                      aria-label="Search">
                  <div class="input-group-append">
                      <button class="btn btn-sidebar">
                          <i class="fas fa-search fa-fw"></i>
                      </button>
                  </div>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2 mb-4">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-item {{ request()->routeIs('home') ? 'menu-open' : '' }}">
                      <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Dashboard

                          </p>
                      </a>
                  </li>

                  @can('access_user_management')
                      <li
                          class="nav-item {{ request()->routeIs('users.*', 'roles.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link {{ request()->routeIs('users.*', 'roles.*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-user-shield text-info"></i>
                              <p>
                                  User Management
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>

                          <ul class="nav nav-treeview">

                              {{-- ================= ROLES ================= --}}
                              <li class="nav-item">
                                  <a href="{{ route('roles.index') }}"
                                      class="nav-link {{ request()->routeIs('roles.index') ? 'active' : '' }}">
                                      {{-- <i class="fas fa-user-tag nav-icon text-warning"></i> --}}
                                      <p>Roles</p>
                                  </a>
                              </li>

                              {{-- ================= USERS ================= --}}
                              <li class="nav-item">
                                  <a href="{{ route('users.index') }}"
                                      class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                                      {{-- <i class="fas fa-users nav-icon text-primary"></i> --}}
                                      <p>Users</p>
                                  </a>
                              </li>

                              {{-- ================= CREATE USER ================= --}}
                              <li class="nav-item">
                                  <a href="{{ route('users.create') }}"
                                      class="nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}">
                                      {{-- <i class="fas fa-user-plus nav-icon text-success"></i> --}}
                                      <p>Create User</p>
                                  </a>
                              </li>

                          </ul>
                      </li>
                  @endcan



                  <li
                      class="nav-item {{ request()->routeIs('student.*', 'payments.*', 'expenses.*', 'expense-types.*', 'balancesheet.*', 'finance.*') ? 'menu-is-opening menu-open' : '' }}">
                      <a href="#"
                          class="nav-link {{ request()->routeIs('student.*', 'payments.*', 'expenses.*', 'expense-types.*', 'balancesheet.*', 'finance.*') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-users"></i>
                          <p>
                              Student Management
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>

                      <ul class="nav nav-treeview">

                          {{-- ================= STUDENTS ================= --}}
                          <li class="nav-item">
                              <a href="{{ route('student.index') }}"
                                  class="nav-link {{ request()->routeIs('student.index') ? 'active' : '' }}">
                                  <i class="fas fa-user-check nav-icon text-success"></i>
                                  <p>Current Students</p>
                              </a>
                          </li>

                          <li class="nav-item">
                              <a href="{{ route('student.index2') }}"
                                  class="nav-link {{ request()->routeIs('student.index2') ? 'active' : '' }}">
                                  <i class="fas fa-user-clock nav-icon text-warning"></i>
                                  <p>Recovered Students</p>
                              </a>
                          </li>

                          {{-- ================= PAYMENTS ================= --}}
                          @can('access_payments')
                          <li class="nav-item">
                              <a href="{{ route('payments.index') }}"
                                  class="nav-link {{ request()->routeIs('payments.index') ? 'active' : '' }}">
                                  <i class="fas fa-hand-holding-usd nav-icon text-info"></i>
                                  <p>Payments</p>
                              </a>
                          </li>
                            @endcan

                          {{-- ================= EXPENSES ================= --}}
                          @can('show_expenses')
                          <li class="nav-item">
                              <a href="{{ route('expenses.index') }}"
                                  class="nav-link {{ request()->routeIs('expenses.index') ? 'active' : '' }}">
                                  <i class="fas fa-receipt nav-icon text-danger"></i>
                                  <p>Expenses</p>
                              </a>
                          </li>
                            @endcan
    
                            {{-- ================= EXPENSE TYPES ================= --}}

                          {{-- ================= BALANCE SHEET ================= --}}
                         @can('access_balance')
                          <li class="nav-item">
                              <a href="{{ route('balancesheet.index') }}"
                                  class="nav-link {{ request()->routeIs('balancesheet.index') ? 'active' : '' }}">
                                  <i class="fas fa-balance-scale nav-icon text-primary"></i>
                                  <p>Balance Sheet</p>
                              </a>
                          </li>
                          @endcan

                          {{-- ================= FINANCE SUMMARY ================= --}}
                          @can('access_finance')
                          <li class="nav-item">
                              <a href="{{ route('finance.summary') }}"
                                  class="nav-link {{ request()->routeIs('finance.summary') ? 'active' : '' }}">
                                  <i class="fas fa-chart-line nav-icon text-success"></i>
                                  <p>Finance Summary</p>
                              </a>
                          </li>
                          @endcan

                          {{-- ================= FEE STRUCTURE ================= --}}
                          @can('manage_fee_structures')
                          <li class="nav-item">
                              <a href="{{ route('fee-structures.index') }}"
                                  class="nav-link {{ request()->routeIs('fee-structures.index') ? 'active' : '' }}">
                                  <i class="fas fa-file-invoice-dollar nav-icon text-secondary"></i>
                                  <p>Fee Structure</p>
                              </a>
                          </li>
                          @endcan

                      </ul>
                  </li>






                  @can('access_sliders')
                      <li class="nav-item {{ request()->routeIs('sliders.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link" {{ request()->routeIs('sliders.*') ? 'active' : '' }}>
                              <i class="nav-icon fas fa-image"></i>
                              <p>
                                  Sliders
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('sliders.index') }}"
                                      class="nav-link {{ request()->routeIs('sliders.index') ? 'active' : '' }}">
                                      {{-- <i class="fas fa-images nav-icon text-primary"></i> --}}
                                      <p>Sliders</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('sliders.create') }}"
                                      class="nav-link {{ request()->routeIs('sliders.create') ? 'active' : '' }}">
                                      {{-- <i class="fas fa-images nav-icon text-primary"></i> --}}
                                      <p>Create Sliders</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endcan

                  @can('access_blogs')
                      <li class="nav-item {{ request()->routeIs('blogs.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link" {{ request()->routeIs('blogs.*') ? 'active' : '' }}>
                              <i class="nav-icon fas fa-newspaper"></i>
                              <p>
                                  Blogs
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('blogs.index') }}"
                                      class="nav-link {{ request()->routeIs('blogs.index') ? 'active' : '' }}">
                                      {{-- <i class="fas fa-blog nav-icon text-primary"></i> --}}
                                      <p>Blog</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('blogs.create') }}"
                                      class="nav-link {{ request()->routeIs('blogs.create') ? 'active' : '' }}">
                                      {{-- <i class="fas fa-pen-nib nav-icon text-success"></i> --}}
                                      <p>Create Blogs</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endcan

                  @can('access_teams')
                      <li class="nav-item {{ request()->routeIs('teams.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link" {{ request()->routeIs('teams.*') ? 'active' : '' }}>
                              <i class="nav-icon fas fa-user"></i>
                              <p>
                                  Teams
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('teams.index') }}"
                                      class="nav-link {{ request()->routeIs('teams.index') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Teams</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('teams.create') }}"
                                      class="nav-link {{ request()->routeIs('teams.create') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Create Teams</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endcan

                  @can('access_faqs')
                      <li class="nav-item {{ request()->routeIs('faqs.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link" {{ request()->routeIs('faqs.*') ? 'active' : '' }}>
                              <i class="nav-icon fas fa-question-circle"></i>
                              <p>
                                  FAQs
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('faqs.index') }}"
                                      class="nav-link {{ request()->routeIs('faqs.index') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>FAQs</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('faqs.create') }}"
                                      class="nav-link {{ request()->routeIs('faqs.create') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Create FAQs</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endcan

                  @can('access_testimonials')
                      <li class="nav-item {{ request()->routeIs('testimonials.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link" {{ request()->routeIs('testimonials.*') ? 'active' : '' }}>
                              <i class="nav-icon fas fa-comment"></i>
                              <p>
                                  Testimonial
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('testimonials.index') }}"
                                      class="nav-link {{ request()->routeIs('testimonials.index') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Testimonials</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('testimonials.create') }}"
                                      class="nav-link {{ request()->routeIs('testimonials.create') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Create Testimonials</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endcan

                  @can('access_galleries')
                      <li class="nav-item {{ request()->routeIs('galleries.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link" {{ request()->routeIs('galleries.*') ? 'active' : '' }}>
                              <i class="far fa-image nav-icon"></i>
                              <p>
                                  galleries
                              </p>
                              <i class="right fas fa-angle-left"></i>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('galleriescategory.index') }}"
                                      class="nav-link {{ request()->routeIs('galleriescategory.index') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>gallary Category</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('galleries.index') }}"
                                      class="nav-link {{ request()->routeIs('galleries.create') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Gallary</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endcan

                  @can('access_services')
                      <li class="nav-item {{ request()->routeIs('services.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link" {{ request()->routeIs('service.*') ? 'active' : '' }}>
                              <i class="nav-icon fas fa-image"></i>
                              <p>
                                  services
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('service.index') }}"
                                      class="nav-link {{ request()->routeIs('service.index') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Services</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('service.create') }}"
                                      class="nav-link {{ request()->routeIs('service.create') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Create</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('baf.index') }}"
                                      class="nav-link {{ request()->routeIs('baf.index') ? 'active' : '' }}">
                                      <p>Edit Before and After Image</p>
                                  </a> {{-- <i class="far fa-circle nav-icon"></i> --}}

                              </li>
                          </ul>
                      </li>
                  @endcan

                  @can('access_treatments')
                      <li class="nav-item {{ request()->routeIs('treatment.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link" {{ request()->routeIs('treatment.*') ? 'active' : '' }}>
                              {{-- <i class="nav-icon fas fa-image"></i> --}}
                              <i class="nav-icon fas fa-stethoscope"></i>
                              <p>
                                  Treatment
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('treatment.index') }}"
                                      class="nav-link {{ request()->routeIs('treatment.index') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Index</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('treatment.create') }}"
                                      class="nav-link {{ request()->routeIs('treatment.create') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Create</p>
                                  </a>
                              </li>
                          </ul>
                      @endcan

                      @can('access_inquiries')
                      <li class="nav-item {{ request()->routeIs('inquiries.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="{{ route('inquires.index') }}"
                              class="nav-link {{ request()->routeIs('inquires.index') ? 'active' : '' }}">
                              <i class="far fa-address-book nav-icon"></i>
                              <p>Inquiries</p>
                          </a>
                      </li>
                  @endcan

                  @can('access_appointments')
                      <li class="nav-item {{ request()->routeIs('appointments.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="{{ route('appoitment.index') }}" class="nav-link"
                              {{ request()->routeIs('appoitment.index') ? 'active' : '' }}>
                              <i class="far fa-address-book nav-icon"></i>
                              <p>
                                  Appoitment
                              </p>
                          </a>
                      </li>
                  @endcan


                  @can('access_settings')
                      <li class="nav-item {{ request()->routeIs('company.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link" {{ request()->routeIs('company.*') ? 'active' : '' }}>
                              <i class="nav-icon fas fa-cogs"></i>
                              <p>
                                  Setting
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('company.index') }}"
                                      class="nav-link {{ request()->routeIs('company.index') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Company Profile</p>
                                  </a>
                              </li>
                          </ul>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('whyus.index') }}"
                                      class="nav-link {{ request()->routeIs('whyus.index') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Why Choose Us</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endcan
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
