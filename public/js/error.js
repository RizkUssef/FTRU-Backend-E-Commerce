document.addEventListener("DOMContentLoaded", function() {
    // Get the div element
    var myError = document.getElementById("myError");
    // Set a timeout to hide the div after 4 seconds
    setTimeout(function() {
      myError.remove();
    }, 4000);
});
  