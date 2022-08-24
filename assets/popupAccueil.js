
// Get the modal
if(document.getElementById("popup")!== null){
    var modal = document.getElementById("popup");

    // Get the button that opens the modal
    var btn = document.getElementById("close_birthday");


    // When the user clicks the button, open the modal 
    modal.style.display = "grid";

    // When the user clicks anywhere outside of the modal, close it
    btn.onclick = function(event) {
        modal.style.display = "none";
    }
}