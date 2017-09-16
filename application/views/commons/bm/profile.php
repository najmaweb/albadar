<!-- start: User Dropdown -->
<li class="dropdown">
    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="halflings-icon white user"></i> <?php echo $_SESSION["username"];?>
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li class="dropdown-menu-title">
            <span>Account Settings</span>
        </li>
        <li><a href="/users/profile"><i class="halflings-icon user"></i> Profile</a></li>
        <li><a href="/main/logout"><i class="halflings-icon off"></i> Logout</a></li>
    </ul>
</li>
<!-- end: User Dropdown -->
