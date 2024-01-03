// IMP: can issue js statments in console tab of Chrome F12
//console.log(variable)
function showHideControls() {

}


function hideSaveButton() {
  console.log("hideSaveButton function called.");
  let saveBtn = document.querySelector("#f_Save");
  console.log("Save button element:", saveBtn);

  if (saveBtn) {
    // Button exists, so you can safely set attributes.
    console.log("Setting the disabled attribute on the save button.");
    saveBtn.setAttribute("disabled", "");

    // Checks for error validation text to re-enable
    let errorText = document.getElementById("ERROR") ? document.getElementById("ERROR").textContent : "ERROR element not found";
    console.log("Error text content:", errorText);

    if (errorText == "No Errors! :)") {
      console.log("Removing the disabled attribute from the save button.");
      saveBtn.removeAttribute("disabled");
    }
  } else {
    // The button doesn't exist in the DOM.
    console.error("Save button not found: #f_Save");
  }
}




function Validate() {
  //Added Js to check for input validation
  let dateCompare = new Date('2000-04-15')
  let dateEntered = new Date(document.getElementById("f_DateStamp").value)
  let errorMsg = ""
  //Validates liscense plate to not be empty
  if (document.getElementById("f_LicensePlate").value == "") {
    errorMsg += "License plate cannot be blank. "
  }
  //Validates for critical danger and makes speed below 50
  if (document.getElementById("f_DangerStatus").value == "Critical"
    && document.getElementById("f_Speed").value > 50) {
    errorMsg += "When Critical danger, speed must be below 50. "
  }
  //checks if the date entered is after April 15 2000
  if (dateCompare > dateEntered) {
    errorMsg += "Cannot be before, April 15, 2000."
  }
  //Trims off the trailing and leading whitespace in the error mesage
  errorMsg = errorMsg.trim()

  let errorMsgElement = document.getElementById("ERROR");
  errorMsgElement.innerHTML = (errorMsg == "" ? "No Errors! :)" : errorMsg);

  console.log("Validation completed. Error message: " + errorMsg);

  // Call hideSaveButton to update the button state
  hideSaveButton();
}
