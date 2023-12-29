// IMP: can issue js statments in console tab of Chrome F12
//console.log(variable)
function showHideControls() {

}
function hideSaveButton() {
  let saveBtn = document.querySelector("#saveButton");
  //sets button disabled by default
  saveBtn.setAttribute("disabled", "");

  //checks for error validation text to re-enable
  if (document.getElementById("ERROR").textContent == "No Errors! :)")
    saveBtn.removeAttribute("disabled");

}
function Validate() {
  //Dhanan: Added Js to check for input validation
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
  //makes the error label show the error message and 
  //aslo shows that there is no error.
  document.getElementById("ERROR").innerHTML =
    (errorMsg == "" ? "No Errors! :)" : errorMsg)

  hideSaveButton();
}
