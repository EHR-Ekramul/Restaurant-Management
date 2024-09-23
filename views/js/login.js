function isValid(form) {
  // Get the input fields and error span elements
  const username = form.username.value;
  const password = form.password.value;

  const usernameError = document.getElementById("lusernameerr");
  const passwordError = document.getElementById("lpasserr");

  // Clear previous error messages
  usernameError.innerHTML = "";
  passwordError.innerHTML = "";

  // Flag to track if the form is valid
  let isFormValid = true;

  // Check if username is empty
  if (username.trim() === "") {
    usernameError.innerHTML = "Username is required.";
    isFormValid = false;
  }

  // Check if password is empty
  if (password.trim() === "") {
    passwordError.innerHTML = "Password is required.";
    isFormValid = false;
  }

  // Return the validation result
  return isFormValid; // This should correctly determine if the form should be submitted
}
