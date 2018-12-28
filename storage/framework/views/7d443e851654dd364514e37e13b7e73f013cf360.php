<nav class="navbar navbar-expand-lg navbar-dark bg-dark main-menu">
    <div class="container">

        <!-- Branding Image -->
        <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
            <img src="<?php echo e(asset('web-photos/selfee-logo.png')); ?>" class="img-fluid com-img" width="70" alt="Selfee.lk">
        </a>

        <!-- Collapsed Hamburger -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav menu-bar">
                <!--<li class="nav-item active">
                    <a class="nav-link" href="/">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>-->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(url('ads')); ?>">All Ads</a>
                </li>
            </ul>

            <!-- Middle Of Navbar -->
            <ul class="navbar-nav ml-auto menu-bar">
                
                <!-- Authentication Links -->
                <?php if(auth()->guard()->guest()): ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('login')); ?>"><i class="fa fa-user" aria-hidden="true"></i> Login</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('dashboard')); ?>"><i class="fa fa-user" aria-hidden="true"></i> My account</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('logout')); ?>"
                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                            <?php echo e(csrf_field()); ?>

                        </form>
                    </li>
                    <!--<li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            <i class="fa fa-user" aria-hidden="true"></i> My account<span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo e(route('logout')); ?>"
                                    onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                    <?php echo e(csrf_field()); ?>

                                </form>
                            </li>
                        </ul>
                    </li>-->
                <?php endif; ?>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right menu-bar">
                <li class="nav-item add-post">
                    <a class="nav-link" href="<?php echo e(url('ads/post-ad')); ?>">Post Your Add</a>
                </li>
            </ul>

        </div>
    </div>
</nav>