<?
include('config.php');
if($_SESSION['username']){ 
    $id = $_SESSION['userid'];

     $user = "select * from mis_loginusers_test where id=".$id;
    $usersql = mysqli_query($con,$user);
    $usersql_result = mysqli_fetch_assoc($usersql);
    $role = $usersql_result['role'];
    
    $rolesql = mysqli_query($con,"select * from role_permission where role_id = '".$role."' ");
    $rolesql_result = mysqli_fetch_assoc($rolesql);
    
    $permission = $rolesql_result['permission'];
    $permission = explode(',',$permission);
    sort($permission);

$cpermission=json_encode($permission);
$cpermission=str_replace( array('[',']','"') , ''  , $cpermission);
$cpermission=explode(',',$cpermission);
$cpermission = "'" . implode ( "', '", $cpermission )."'";


    $mainmenu = [];
    //  echo '<pre>';print_r($permission);echo '</pre>';
    foreach($permission as $key=>$val){
        
        
        $sub_menu_sql = mysqli_query($con,"select * from sub_menu where id='".$val."' and status=1");
        if(mysqli_num_rows($sub_menu_sql)>0){
          $sub_menu_sql_result = mysqli_fetch_assoc($sub_menu_sql);
        
          $mainmenu[] = $sub_menu_sql_result['main_menu'];
        }
        
    }
   // echo '<pre>';print_r($mainmenu);echo '</pre>';
$mainmenu    = array_unique($mainmenu);
//echo '<pre>';print_r($mainmenu);echo '</pre>';die;
?>
    





<nav class="pcoded-navbar">
                        <div class="pcoded-inner-navbar main-menu">
                            <div class="pcoded-navigatio-lavel">Navigation</div>
                        
                            <ul class="pcoded-item pcoded-left-item">
                                
                        <li class="">
                                    <a href="mis_call_dashboard.php">
                                        <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                        <span class="pcoded-mtext">Home</span>
                                    </a>
                                </li>
                        
                                
                        
                        <?
                        
                        foreach($mainmenu as $menu=>$menu_id){
                        
                        $menu_sql = mysqli_query($con,"select * from main_menu where id='".$menu_id."' and status=1");
                        $menu_sql_result = mysqli_fetch_assoc($menu_sql);
                         $main_name = $menu_sql_result['name']; 
                        
                        ?>

                            <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-layers"></i></span>
                                        <span class="pcoded-mtext"><? echo $main_name; ?></span>
                                    </a>
                                    
                                    
                                    <ul class="pcoded-submenu">                                    
                                        <?
                                        
                                        $submenu_sql = mysqli_query($con,"select * from sub_menu where main_menu = '".$menu_id."' and id in ($cpermission) and status=1");
                                        while($submenu_sql_result = mysqli_fetch_assoc($submenu_sql)){ 
                                        $page = $submenu_sql_result['page'];
                                        $submenu_name = $submenu_sql_result['sub_menu'];
                                        ?>
                                            
                                            <li class=" ">
                                                <a href="<? echo $page; ?>">
                                                    <span class="pcoded-mtext"><? echo $submenu_name; ?></span>
                                                </a>
                                            </li>
                                        
                                        <? } ?>
                                        
                                    </ul>
                                </li>
                                
                                
                        <? }
                        
                        ?>
                        <li class="">
                                    <a href="logout_test.php">
                                        <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                        <span class="pcoded-mtext">Logout</span>
                                    </a>
                                </li>
                                
                            
                            </ul>
                        </div>
                    </nav>
                    <? } ?>