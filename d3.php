<?
$date = date('Y-m-d');
$insertid=1;
foreach($_FILES as $k => $v){
    
    $name = $k ;
    

    $target_dir = "visitupload/".$insertid.'/';
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}


    $target_file = $target_dir . basename($_FILES[$name]["name"]);

    if (move_uploaded_file($_FILES[$name]["tmp_name"], $target_file)) {
    echo htmlspecialchars( basename( $_FILES[$name]["name"])) . "The file  has been uploaded.";
    $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. htmlspecialchars( basename( $_FILES[$name]["name"])) ; 
    echo $sql = "insert into misvisit_images(name,link,status,created_at) values('".$name."','".$link."','1','".$date."')" ; 
    
    } else {
    echo "Sorry, there was an error uploading your file.";
    }
    

}


?>