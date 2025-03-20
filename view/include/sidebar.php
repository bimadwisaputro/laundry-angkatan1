<!-- class="active" ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link collapsed sidebarleft" id="dahsboard" parentid="" href="?page=dahsboard">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->
        <li class="nav-heading">Shortcut</li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="?page=orders&form=add">
                <i class="bi bi-basket2"></i>
                <span>Form Add Orders</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-heading">Master</li>
        <li class="nav-item">
            <a class="nav-link collapsed" id="masters" data-bs-target="#masters-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-folder"></i><span>Masters</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="masters-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="?page=users" id="users" parentid="masters" class="sidebarleft">
                        <i class="bi bi-play-fill"></i><span>Users</span>
                    </a>
                </li>
                <li>
                    <a href="?page=customers" id="customers" parentid="masters" class="sidebarleft">
                        <i class="bi bi-play-fill"></i><span>Customers</span>
                    </a>
                </li>
                <li>
                    <a href="?page=levels" id="levels" parentid="masters" class="sidebarleft">
                        <i class="bi bi-play-fill"></i><span>Level User</span>
                    </a>
                </li>
                <li>
                    <a href="?page=services" id="services" parentid="masters" class="sidebarleft">
                        <i class="bi bi-play-fill"></i><span>Services</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Tables Nav -->

        <li class="nav-heading">Transactions</li>
        <li class="nav-item">
            <a class="nav-link collapsed" id="transactions" data-bs-target="#transactions-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-folder"></i><span>Transactions</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="transactions-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="?page=orders" id="orders" parentid="transactions" class="sidebarleft">
                        <i class="bi bi-play-fill"></i><span>Orders</span>
                    </a>
                </li>
                <li>
                    <a href="?page=pickups" id="pickups" parentid="transactions" class="sidebarleft">
                        <i class="bi bi-play-fill"></i><span>Pick Ups</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Tables Nav -->

        <li class="nav-heading">Reports</li>
        <li class="nav-item">
            <a class="nav-link collapsed" id="reports" data-bs-target="#reports-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-folder"></i><span>Reports</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="reports-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="?page=allreports" id="allreports" parentid="reports" class="sidebarleft">
                        <i class="bi bi-play-fill"></i><span>Order Reports</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Tables Nav -->


    </ul>

</aside><!-- End Sidebar -->