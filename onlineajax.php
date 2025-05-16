<? include('config.php'); ?>
<? include('function.php'); ?>
<ul>
                                            
                                        
                                        <?
                                        
                                        $date_sql = mysqli_query($con,"select NOW() as now");
                                        $date_sql_result = mysqli_fetch_assoc($date_sql);
                                        $now = $date_sql_result['now'];

                                        $now = new DateTime($now); //current date/time
                                        $now->add(new DateInterval("PT9H29M50S"));
                                        $output = $now->format('Y-m-d H:i:s');
                                        
                                        $sql = mysqli_query($con,"select distinct(userid) as userid from mis_logintrack where created_at  >= '".$output."'");
                                        while($sql_result = mysqli_fetch_assoc($sql)){ 
                                        
                                        $online[] = $sql_result['userid']
                                        ?>
                                         
                                         <li style="border: 1px solid gray; padding: 10px;" class="card">
                                             <span class="empname"><? echo get_member_name($sql_result['userid']) . $sql_result['userid']; ?></span>
                                             <span class="online"></span>
                                        </li>
                                             
                                        <?
                                        
                                            
                                        }
                                        ?>
                                        
                                    </div>
                                    </ul>
                                    
                                    
                                    
                                    <? 
                                    
$online=json_encode($online);
$online=str_replace( array('[',']','"') , ''  , $online);
$online=explode(',',$online);
$online = "'" . implode ( "', '", $online )."'";




                                    $sql2 = mysqli_query($con,"Select * from mis_loginusers where id not in ($online) order by id asc");
                                    while($sql2_result = mysqli_fetch_assoc($sql2)){
                                        
                                        $users[] = $sql2_result['id'];
                                        
                                    }


                    foreach($users as $key=>$value){ ?>
                         
                         <li style="border: 1px solid gray; padding: 10px;" class="card">
                             <span class="empname"><? echo get_member_name($value) ; ?></span>
                             <span class="offline"></span>
                        </li>
                    <? } ?>