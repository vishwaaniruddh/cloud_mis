<? include('config.php');

echo "select * from notification where notification_to='".$userid."'";

$noti_sql = mysqli_query($con,"select * from notification where notification_to='".$userid."'");


?>
   <li>
        <div class="media">
            <div class="media-body">
                <h6 class="notification-user">Some</h6>
                <p class="notification-msg">detailed notification.</p>
                <span class="notification-time">30 minutes ago</span>
            </div>
        </div>
    </li>