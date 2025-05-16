<html lang="en"><head>
  <meta charset="UTF-8">
  

    <link rel="apple-touch-icon" type="image/png" href="https://cpwebassets.codepen.io/assets/favicon/apple-touch-icon-5ae1a0698dcc2402e9712f7d01ed509a57814f994c660df9f7a952f3060705ee.png">

    <meta name="apple-mobile-web-app-title" content="CodePen">

    <link rel="shortcut icon" type="image/x-icon" href="https://cpwebassets.codepen.io/assets/favicon/favicon-aec34940fbc1a6e787974dcd360f2c6b63348d4b1f4e06c77743096d55480f33.ico">

    <link rel="mask-icon" type="image/x-icon" href="https://cpwebassets.codepen.io/assets/favicon/logo-pin-b4b4269c16397ad2f0f7a01bcdf513a1994f4c94b8af2f191c09eb0d601762b1.svg" color="#111">



  
    <script src="https://cpwebassets.codepen.io/assets/common/stopExecutionOnTimeout-2c7831bb44f98c1391d6a4ffda0e1fd302503391ca806e7fcc7b9b87197aec26.js"></script>


  <title>Dashboard Login</title>

    <link rel="canonical" href="https://codepen.io/jaegersims/pen/bGmoqXV">
  <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@dazzle/particles@2.11.1@particles.js">
  
<style>
html {
  height: 100%;
}
body {
  margin: 0;
  padding: 0;
  font-family: sans-serif;
  background: linear-gradient(to bottom, #1e90ff, #00008b);
  height 100%
}

.login-box {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 400px;
  padding: 40px;
  transform: translate(-50%, -50%);
  background: rgba(0, 0, 0, 0.5);
  box-sizing: border-box;
  box-shadow: 0 15px 25px rgba(0, 0, 0, 0.6);
  border-radius: 10px;
}

.login-box h2 {
  margin: 0 0 30px;
  padding: 0;
  color: #fff;
  text-align: center;
}

.login-box .user-box {
  position: relative;
}

.login-box .user-box input {
  width: 100%;
  padding: 10px 0;
  font-size: 16px;
  color: #fff !important;
  margin-bottom: 30px;
  border: none;
  border-bottom: 1px solid #fff;
  outline: none;
  background: transparent;
}
.login-box .user-box label {
  position: absolute;
  top: 0;
  left: 0;
  padding: 10px 0;
  font-size: 16px;
  color: #ffff;
  pointer-events: none;
  transition: 0.5s;
}

.login-box .user-box input:focus ~ label,
.login-box .user-box input:valid ~ label {
  top: -20px;
  left: 0;
  color: #ffff;
  font-size: 12px;
}

.login-box form a {
  position: relative;
  display: inline-block;
  padding: 10px 20px;
  color: #ffff;
  font-size: 16px;
  text-decoration: none;
  text-transform: uppercase;
  overflow: hidden;
  transition: 0.5s;
  margin-top: 40px;
  letter-spacing: 4px;
}

.login-box a:hover {
  background-color: #fff;
  color: #3f3f3f;
  outline: none;
}

.login-box a span:nth-child(1) {
  top: 0;
  left: -100%;
  width: 100%;
  height: 2px;
  background: linear-gradient(90deg, transparent, #03e9f4);
  animation: btn-anim1 1s linear infinite;
}

@keyframes btn-anim1 {
  0% {
    left: -100%;
  }
  50%,
  100% {
    left: 100%;
  }
}

.login-box a span:nth-child(2) {
  top: -100%;
  right: 0;
  width: 2px;
  height: 100%;
  background: linear-gradient(180deg, transparent, #03e9f4);
  animation: btn-anim2 1s linear infinite;
  animation-delay: 0.25s;
}

@keyframes btn-anim2 {
  0% {
    top: -100%;
  }
  50%,
  100% {
    top: 100%;
  }
}

.login-box a span:nth-child(3) {
  bottom: 0;
  right: -100%;
  width: 100%;
  height: 2px;
  background: linear-gradient(270deg, transparent, #03e9f4);
  animation: btn-anim3 1s linear infinite;
  animation-delay: 0.5s;
}

@keyframes btn-anim3 {
  0% {
    right: -100%;
  }
  50%,
  100% {
    right: 100%;
  }
}

.login-box a span:nth-child(4) {
  bottom: -100%;
  left: 0;
  width: 2px;
  height: 100%;
  background: linear-gradient(360deg, transparent, #03e9f4);
  animation: btn-anim4 1s linear infinite;
  animation-delay: 0.75s;
}

@keyframes btn-anim4 {
  0% {
    bottom: -100%;
  }
  50%,
  100% {
    bottom: 100%;
  }
}


input:-webkit-autofill {
  background-color: transparent !important;
  transition: background-color 5000s ease-in-out 0s;
  color:white !important;
}

input:-webkit-autofill:focus {
  background-color: transparent !important;
  color:white !important;
}



</style>

  <script>
  window.console = window.console || function(t) {};
</script>

  
  
</head>

<body translate="no">
  
<div id="particles-js"><canvas class="particles-js-canvas-el" width="1003" height="502" style="width: 100%; height: 100%;"></canvas></div>
<div class="login-box">
  <h2>Dashboard Access</h2>
  <form>
    <div class="user-box">

      <input type="text" name="" required="" placeholder="Username">

    </div>
    <div class="user-box">
      <input type="password" name="" required="" placeholder="Password">
    </div>
    <a href="#">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      Login
    </a>
  </form>
  <script src="particles.js"></script>
</div>
  <script src="https://cdn.jsdelivr.net/npm/@dazzle/particles@2.11.1@particles.js"></script>
      <script id="rendered-js">
function login() {
  var username = document.getElementById("username").value;
  var password = document.getElementById("password").value;

  if (username === "" || password === "") {
    alert("Please fill in all fields");
    return false;
  } else if (password !== "correctpassword") {
    // Replace "correctpassword" with the actual correct password
    var email = prompt(
    "Incorrect password. Please enter your email to reset your password.");

    if (email !== null && email !== "") {
      // Call a function to send a password reset email to the user's email address
      sendResetPasswordEmail(email);
    }
    return false;
  } else {
    // Perform login check here
  }
}

function sendResetPasswordEmail(email) {
  // Implement the logic for sending an email here
  alert(
  "An email has been sent to " +
  email +
  " with instructions to reset your password.");

}

particlesJS.load("particles-js", "./particles.json");

function togglePasswordVisibility() {
  const passwordInput = document.getElementById("password");
  if (passwordInput.type === "password") {
    passwordInput.type = "text";
  } else {
    passwordInput.type = "password";
  }
}
particlesJS("particles-js", {
  particles: {
    number: {
      value: 80,
      density: {
        enable: true,
        value_area: 800 } },


    color: {
      value: "#ffffff" },

    shape: {
      type: "circle",
      stroke: {
        width: 0,
        color: "#000000" },

      polygon: {
        nb_sides: 5 },

      image: {
        src: "img/github.svg",
        width: 100,
        height: 100 } },


    opacity: {
      value: 0.5,
      random: false,
      anim: {
        enable: false,
        speed: 1,
        opacity_min: 0.1,
        sync: false } },


    size: {
      value: 5,
      random: true,
      anim: {
        enable: false,
        speed: 40,
        size_min: 0.1,
        sync: false } },


    line_linked: {
      enable: true,
      distance: 150,
      color: "#ffffff",
      opacity: 0.4,
      width: 1 },

    move: {
      enable: true,
      speed: 8,
      direction: "none",
      random: true,
      straight: false,
      out_mode: "out",
      bounce: true,
      attract: {
        enable: false,
        rotateX: 600,
        rotateY: 1200 } } },



  interactivity: {
    detect_on: "canvas",
    events: {
      onhover: {
        enable: true,
        mode: "repulse" },

      onclick: {
        enable: true,
        mode: "push" },

      resize: true },

    modes: {
      grab: {
        distance: 400,
        line_linked: {
          opacity: 1 } },


      bubble: {
        distance: 400,
        size: 40,
        duration: 2,
        opacity: 8,
        speed: 3 },

      repulse: {
        distance: 200,
        duration: 0.4 },

      push: {
        particles_nb: 4 },

      remove: {
        particles_nb: 2 } } },



  retina_detect: true });
//# sourceURL=pen.js
    </script>

  



</body></html>