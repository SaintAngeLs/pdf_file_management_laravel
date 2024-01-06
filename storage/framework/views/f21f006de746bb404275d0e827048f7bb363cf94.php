<style>
    .logo-before::before {
        content: '';
        display: block;
        width: 228px;
        height: 60px;
        /* background-image: url('images/logo.png'); Path to your image */
        background-size: contain;
        background-repeat: no-repeat;
        padding-top: 0px;
        /* transform: translateY(-10px) translateX(-10px); */
    }

    .dropdown .nav-link {
        display: flex;
        align-items: center;
    }

    .nav-item.active > .nav-link {
        position: relative;
    }

    .nav-item.active > .nav-link:not(.dropdown-toggle)::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -5px;
        width: 100%;
        height: 2px; /* Height of the underline */
        background-color: #FFD932;
    }

    .nav-item.dropdown > .nav-link.dropdown-toggle::after {
        content: '';
        position: relative;
        right: 0px;
        top: 50%;
        transform: translateY(-50%);
        border-top: 0.3em solid;
        border-right: 0.3em solid transparent;
        border-left: 0.3em solid transparent;
    }

    .nav-item.dropdown.active > .nav-link::after {
        left: auto;
        right: 0px;
        top: 0px;
    }

    .nav-item.dropdown.active > .nav-link {
        position: relative;
    }

    .dropdown-menu {
        background-color: #FFD932;
    }

</style>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
    <a class="navbar-brand" href="https://en.bridge.pl/index.php">
        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="bridge.pl">
    </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item dropdown  <?php echo e(request()->routeIs('document*') || request()->routeIs('user.*')  ? 'active' : ''); ?>">
                    <a class="nav-link dropdown-toggle <?php echo e(request()->routeIs('document*') || request()->routeIs('user.*') ? 'active' : ''); ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Documents
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo e(route('document')); ?>">View</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('document.add')); ?>">Add</a></li>
                    </ul>
                </li>

                <?php if(Auth::user()->role == 'admin'): ?>
                    <li class="nav-item <?php echo e(request()->routeIs('admin')  ? 'active' : ''); ?>">
                        <a class="nav-link" href="<?php echo e(route('admin')); ?>">Users</a>
                    </li>
                <?php endif; ?>

            </ul>

            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                <?php if(auth()->guard()->guest()): ?>
                    <?php if(Route::has('login')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a>
                        </li>
                    <?php endif; ?>

                    <!-- <?php if(Route::has('register')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('register')); ?>"><?php echo e(__('Register')); ?></a>
                        </li>
                    <?php endif; ?> -->
                <?php else: ?>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <?php echo e(Auth::user()->name); ?>

                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">


                            <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <?php echo e(__('Logout')); ?>

                            </a>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                <?php echo csrf_field(); ?>
                            </form>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>

        </div>
    </div>
</nav>
<?php /**PATH /home/kaliuser/Documents/portfolio/a_work/bridge_test/pdf-management-system/resources/views/layouts/navbar.blade.php ENDPATH**/ ?>