// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
//var btn = document.getElementsByClassName("wp-doc-admin-link");
//var btn = document.getElementById("myBtn");
var btn = document.getElementById("wp-admin-bar-wp-doc");


// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  console.log("CLICKED!");
  if (event.target == modal) {
    modal.style.display = "none";
  }
}