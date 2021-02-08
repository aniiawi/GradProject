function barFunction() {
const menuBtn = document.querySelector('.icon');
var x = document.getElementById("navLinks");
let menuOpen = false;
menuBtn.addEventListener('click', () => {
  if(x.style.display === "block") {
    menuBtn.classList.remove('open');
    menuOpen = true ;
    x.style.display = "none";
  } else {
    menuBtn.classList.add('open');
    menuOpen = false;
    x.style.display = "block";
  }
});}
