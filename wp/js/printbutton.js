function printWACOutput() {

  // Hide elements with class "video"
  var videoElements = document.getElementsByClassName("hideInPrint");
  //videoElements += document.getElementsByClassName("hideInPrint");
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

// onload of page add event listener to print button
window.onload = function() {
  var printButton = document.getElementById("printButton");
  printButton.addEventListener("click", printWACOutput);
}



