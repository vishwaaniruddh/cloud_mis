<?php
session_start();
include('config.php');

if ($_SESSION['username']) { 
    $id = $_SESSION['userid'];

    // Check if the menu data is cached in the session
    if (!isset($_SESSION['mainmenu'])) {
        $user = "SELECT * FROM mis_loginusers WHERE id = ".$id;
        $usersql = mysqli_query($con, $user);
        $usersql_result = mysqli_fetch_assoc($usersql);

        $permission = $usersql_result['permission'];
        $permission = explode(',', $permission);
        sort($permission);

        $cpermission = json_encode($permission);
        $cpermission = str_replace(['[', ']', '"'], '', $cpermission);
        $cpermission = explode(',', $cpermission);
        $cpermission = "'" . implode("', '", $cpermission) . "'";

        $mainmenu = [];

        foreach ($permission as $key => $val) {
            $sub_menu_sql = mysqli_query($con, "SELECT * FROM sub_menu WHERE id = '".$val."' AND status = 1");
            if (mysqli_num_rows($sub_menu_sql) > 0) {
                $sub_menu_sql_result = mysqli_fetch_assoc($sub_menu_sql);
                $mainmenu[] = $sub_menu_sql_result['main_menu'];
            }
        }
        $mainmenu = array_unique($mainmenu);

        // Cache the main menu data in session
        $_SESSION['mainmenu'] = $mainmenu;
        $_SESSION['cpermission'] = $cpermission;
    } else {
        // Use the cached data from session
        $mainmenu = $_SESSION['mainmenu'];
        $cpermission = $_SESSION['cpermission'];
    }
?>
    <!-- Your HTML and menu rendering code here -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <nav class="pcoded-navbar">
        <div class="pcoded-inner-navbar main-menu">
            <div class="pcoded-navigatio-lavel">Navigation</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="">
                    <a href="./index.php">
                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                        <span class="pcoded-mtext">Home</span>
                    </a>
                </li>
                
                <?php
                foreach ($mainmenu as $menu => $menu_id) {
                    $menu_sql = mysqli_query($con, "SELECT * FROM main_menu WHERE id = '".$menu_id."' AND status = 1");
                    $menu_sql_result = mysqli_fetch_assoc($menu_sql);
                    $main_name = $menu_sql_result['name']; 
                    $icon = $menu_sql_result['icon'];
                ?>
                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)">
                            <span class="pcoded-micon">
                                <?php
                                if ($main_name == 'Admin') {
                                    echo '<i class="fa fa-american-sign-language-interpreting"></i>'; 
                                } else if ($main_name == 'Sites') {
                                    echo '<i class="fa fa-sitemap"></i></span>';
                                } else if ($main_name == 'MIS') {
                                    echo '<i class="feather icon-check-circle"></i>';
                                } else if ($main_name == 'Accounts') {
                                    echo '<i class="feather icon-pie-chart"></i>';
                                } else if ($main_name == 'Report') {
                                    echo '<i class="feather icon-box"></i>';
                                } else if ($main_name == 'Footage Request') {
                                    echo '<i class="feather icon-image"></i>';
                                } else if ($main_name == 'Project') {
                                    echo '<i class="feather icon-aperture rotate-refresh"></i>';
                                } else if ($main_name == 'Engineer Fund Request') {
                                    echo '<i class="feather icon-unlock"></i>';
                                } else if ($main_name == 'Inventory') {
                                    echo '<i class="feather icon-shopping-cart"></i>';
                                }
                                ?>
                            </span>
                            <span class="pcoded-mtext"><?php echo $main_name; ?></span>
                        </a>
                        
                        <ul class="pcoded-submenu">
                            <?php
                            $submenu_sql = mysqli_query($con, "SELECT * FROM sub_menu WHERE main_menu = '".$menu_id."' AND id IN ($cpermission) AND status = 1 order by sub_menu asc");
                            while ($submenu_sql_result = mysqli_fetch_assoc($submenu_sql)) { 
                                $page = $submenu_sql_result['page'];
                                $submenu_name = $submenu_sql_result['sub_menu'];
                                $className = (basename($_SERVER['PHP_SELF'], PATHINFO_BASENAME) == $page) ? 'active' : '';
                            ?>
                                <li class="<?php echo $className; ?>">
                                    <a href="<?php echo $page; ?>">
                                        <span class="pcoded-mtext"><?php echo ucwords($submenu_name); ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
                
                <li class="">
                    <a href="logout.php">
                        <span class="pcoded-micon"><i class="feather icon-log-out"></i></span>
                        <span class="pcoded-mtext">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
<?php } ?>

   <script>
window.addEventListener('load', () => {
  // Delay the override to ensure the CDN file has loaded
  setTimeout(() => {
    const divElement = document.querySelector('#pcoded'); // Select the <div> element
    divElement.setAttribute('nav-type', 'st5'); // Override the nav-type attribute value to "st6"
  }, 1000); // Adjust the delay (in milliseconds) based on the CDN file's loading time
});




                    </script>
                    
<script>
    $(document).ready(function() {
        $('.pcoded-submenu li.active').parents('li.pcoded-hasmenu').addClass('pcoded-trigger');
    });

    window.addEventListener('load', () => {
        // Delay the override to ensure the CDN file has loaded
        setTimeout(() => {
            const divElement = document.querySelector('#pcoded'); // Select the <div> element
            divElement.setAttribute('nav-type', 'st5'); // Override the nav-type attribute value to "st6"
        }, 1000); // Adjust the delay (in milliseconds) based on the CDN file's loading time
    });
</script>