<img id="image" src="https://cssmumbai.sarmicrosystems.com/css/dash/esir/assets/plus.png" alt="">
<br>
<a id=waButton class="btn btn-success" href="">share image with whatsapp</a>

<script>
const button = document.getElementById('waButton');
let image = document.getElementById('image');
let imageURL = image.src;

// let sharehref = `whatsapp://send?text=${encodeURIComponent(imageSrc)}`;

button.setAttribute('href', 'whatsapp://send?text='+encodeURIComponent(imageURL));

//button.setAttribute('href', sharehref);
//console.log(button);

</script>