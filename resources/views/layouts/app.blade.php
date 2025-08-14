<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" type="image/x-icon" href="{{ asset('img/jetlouge_logo.png') }}">
  <title>Jetlouge Travels - Dashboard</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/dash-style-fixed.css') }}">
</head>
<body style="background-color: #f8f9fa !important;">



  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: var(--jetlouge-primary);">
    <div class="container-fluid">
      <button class="sidebar-toggle desktop-toggle me-3" id="desktop-toggle" title="Toggle Sidebar">
        <i class="bi bi-list fs-5"></i>
      </button>
      <a class="navbar-brand fw-bold">
        <i class="bi bi-airplane me-2"></i>Jetlouge Travels
      </a>
      <div class="d-flex align-items-center">
        <button class="sidebar-toggle mobile-toggle" id="menu-btn" title="Open Menu">
          <i class="bi bi-list fs-5"></i>
        </button>
      </div>
    </div>
  </nav>

  <!-- Sidebar -->
  <aside id="sidebar" class="bg-white border-end p-3 shadow-sm">
    <!-- Profile Section -->
    <div class="profile-section text-center">
<img src="{{ asset('img/default-profile.jpg') }}" alt="Driver Profile" class="profile-img mb-2">
      <h6 class="fw-semibold mb-1">John Doe</h6>
      <small class="text-muted">Jetlouge Driver</small>
    </div>

    <!-- Navigation Menu -->
    <ul class="nav flex-column">
        <!-- Dashboard -->
        <li class="nav-item">
            <a href="{{ route('dashboard') }}"
              class="nav-link text-dark {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>

        <!-- Trip Assignment -->
        <li class="nav-item">
            <a href="{{ route('trip-assignment') }}"
              class="nav-link text-dark {{ request()->routeIs('trip-assignment') ? 'active' : '' }}">
                <i class="bi bi-truck me-2"></i> Trip Assignment
            </a>
        </li>

        <!-- Live Tracking -->
        <li class="nav-item">
            <a href="{{ route('live-tracking') }}"
              class="nav-link text-dark {{ request()->routeIs('live-tracking') ? 'active' : '' }}">
                <i class="bi bi-geo-alt me-2"></i> Live Tracking
            </a>
        </li>

        <!-- Reports and Checklist -->
        <li class="nav-item">
            <a href="{{ route('reports-and-checklist') }}"
              class="nav-link text-dark {{ request()->routeIs('reports-and-checklist') ? 'active' : '' }}">
                <i class="bi bi-clipboard-check me-2"></i> Reports and Checklist
            </a>
        </li>

        <!-- Logout -->
        <li class="nav-item mt-3">
            <a href="" class="nav-link text-danger">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </li>
    </ul>
  </aside>

  <!-- Overlay for mobile -->
  <div id="overlay" class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50" style="z-index:1040; display: none;"></div>

  <!-- Main Content -->
  <main id="main-content">
    <!-- Page Header -->
      @yield('content')
  </main>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Sidebar toggle functionality -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const menuBtn = document.getElementById('menu-btn');
      const desktopToggle = document.getElementById('desktop-toggle');
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');
      const mainContent = document.getElementById('main-content');

      // Mobile sidebar toggle
      if (menuBtn && sidebar && overlay) {
        menuBtn.addEventListener('click', (e) => {
          e.preventDefault();
          sidebar.classList.toggle('active');
          overlay.classList.toggle('show');
          document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
        });
      }

      // Desktop sidebar toggle
      if (desktopToggle && sidebar && mainContent) {
        desktopToggle.addEventListener('click', (e) => {
          e.preventDefault();
          e.stopPropagation();

          const isCollapsed = sidebar.classList.contains('collapsed');

          // Toggle classes with smooth animation
          sidebar.classList.toggle('collapsed');
          mainContent.classList.toggle('expanded');

          // Store state in localStorage for persistence
          localStorage.setItem('sidebarCollapsed', !isCollapsed);

          // Trigger window resize event to help responsive components adjust
          setTimeout(() => {
            window.dispatchEvent(new Event('resize'));
          }, 300);
        });
      }

      // Restore sidebar state from localStorage
      const savedState = localStorage.getItem('sidebarCollapsed');
      if (savedState === 'true' && sidebar && mainContent) {
        sidebar.classList.add('collapsed');
        mainContent.classList.add('expanded');
      }

      // Close mobile sidebar when clicking overlay
      if (overlay) {
        overlay.addEventListener('click', () => {
          sidebar.classList.remove('active');
          overlay.classList.remove('show');
          document.body.style.overflow = '';
        });
      }

      // Add loading animation to quick action buttons
      document.querySelectorAll('.btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
          if (!this.classList.contains('loading')) {
            this.classList.add('loading');
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="bi bi-arrow-clockwise me-2"></i>Loading...';

            setTimeout(() => {
              this.innerHTML = originalText;
              this.classList.remove('loading');
            }, 1500);
          }
        });
      });

      // Handle window resize for responsive behavior
      window.addEventListener('resize', () => {
        // Reset mobile sidebar state on desktop
        if (window.innerWidth >= 768) {
          sidebar.classList.remove('active');
          overlay.classList.remove('show');
          document.body.style.overflow = '';
        }
      });

      // --- Persist only real route links (ignore hash toggles) ---
      document.querySelectorAll('.nav-link').forEach(link => {
        const href = link.getAttribute('href') || '';
        // persist only real route links (ignore hash toggles)
        if (!href.startsWith('#') && href.trim() !== '') {
          link.addEventListener('click', function () {
            // mark active link visually
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            this.classList.add('active');

            localStorage.setItem('activeLink', href);
            // clicking a real route should clear the open submenu state
            localStorage.removeItem('openSubmenu');
          });
        }
      });

      // --- Save submenu open/close, but only for collapse toggles ---
      document.querySelectorAll('.collapse-toggle').forEach(toggle => {
        toggle.addEventListener('click', function () {
          const targetId = this.getAttribute('href');
          const submenu = document.querySelector(targetId);
          const isOpen = submenu && submenu.classList.contains('show');
          // store either '' (none) or the selector to open
          localStorage.setItem('openSubmenu', isOpen ? '' : targetId);
        });
      });

      // --- Restore submenu state (defensive) ---
      const openSubmenu = localStorage.getItem('openSubmenu');
      if (openSubmenu) {
        const submenu = document.querySelector(openSubmenu);
        if (submenu) submenu.classList.add('show');
      }

      // --- Restore active link (only for real links) ---
      const activeLink = localStorage.getItem('activeLink');
      if (activeLink) {
        const link = document.querySelector(`.nav-link[href="${activeLink}"]`);
        if (link) {
          document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
          link.classList.add('active');
          // open its parent submenu if needed
          const parentCollapse = link.closest('.collapse');
          if (parentCollapse && !parentCollapse.classList.contains('show')) {
            parentCollapse.classList.add('show');
          }
        }
      }

    }); // Close DOMContentLoaded
  </script>

</body>
</html>
