<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
  <!-- Sidebar Toggle (Topbar) -->
  <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" type="button">
    <i class="fa fa-bars"></i>
  </button>

  <!-- Topbar Navbar -->
  <ul class="navbar-nav ml-auto">

    <div class="topbar-divider d-none d-sm-block"></div>

    <!-- User Info -->
    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
         data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small">
          <?php echo e(auth()->user()->name); ?><br>
          <small class="text-muted"><?php echo e(auth()->user()->role_label); ?></small>
        </span>
        <img class="img-profile rounded-circle"
             src="<?php echo e(auth()->user()->profile_photo_url); ?>"
             alt="Profile Image"
             style="width: 40px; height: 40px; object-fit: cover;">
      </a>

      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown" role="menu">
        <a class="dropdown-item" href="<?php echo e(route('users.show', auth()->user()->id)); ?>">
          <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile
        </a>
        <a class="dropdown-item" href="<?php echo e(route('users.edit', auth()->user()->id)); ?>">
          <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> Settings
        </a>
        <a class="dropdown-item" href="<?php echo e(route('activity.logs')); ?>">
          <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i> Activity Log
        </a>
        <div class="dropdown-divider"></div>
        <form method="POST" action="<?php echo e(route('logout')); ?>">
          <?php echo csrf_field(); ?>
          <button class="dropdown-item" type="submit">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
          </button>
        </form>
      </div>
    </li>

  </ul>
</nav>
<?php /**PATH D:\Xammp\htdocs\bug-fixes v3\product_inventory\resources\views\layouts\navbar.blade.php ENDPATH**/ ?>