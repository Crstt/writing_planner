function printWACOutput() {

  // Hide elements with class "video"
  var videoElements = document.getElementsByClassName("video");
  var videoDisplayValues = [];
  for (var i = 0; i < videoElements.length; i++) {
    videoDisplayValues[i] = videoElements[i].style.display;
    videoElements[i].style.display = "none";
  }
  
  // Call the window.print() function
  window.print();
  
  // Show elements with class "video" again
  for (var i = 0; i < videoElements.length; i++) {
    videoElements[i].style.display = videoDisplayValues[i];
  }
}

var printButton = document.getElementById("printButton");
if (printButton.addEventListener) {
    printButton.addEventListener("click", printWACOutput, false);
} else if (printButton.attachEvent) {
    printButton.attachEvent("onclick", printWACOutput);
}
