function login() {
  var login = document.getElementById("login"); 
  var uname = document.getElementById("username");
  var pword = document.getElementById("password");

  var linkurl = "login.php?Login="+login+"?username="+uname+"?password="+pword;

  window.location.href = linkurl;
}