function isValid(form) {
  // Get the input fields and error span elements
  const email = form.email.value;
  const phone = form.phone.value;
  const fullname = form.fullname.value;
  const password = form.password.value;
  const confirmPassword = form.confirm_password.value;

  const emailError = document.getElementById("remailerr");
  const phoneError = document.getElementById("rphoneerr");
  const nameError = document.getElementById("rnameerr");
  const passwordError = document.getElementById("rpasserr");
  const confirmPasswordError = document.getElementById("rcpasserr");

  // Clear previous error messages
  emailError.innerHTML = "";
  phoneError.innerHTML = "";
  nameError.innerHTML = "";
  passwordError.innerHTML = "";
  confirmPasswordError.innerHTML = "";

  // Flag to track if the form is valid
  let isFormValid = true;

  // Check if email is empty
  if (email === "") {
    emailError.innerHTML = "Email is required.";
    isFormValid = false;
  } else if (!emailRegex.test(email)) {
    emailError.innerHTML = "Invalid email format.";
    isFormValid = false;
  }

  // Check if phone number is empty
  if (phone.trim() === "") {
    phoneError.innerHTML = "Phone number is required.";
    isFormValid = false;
  } else {
    // Validate phone number
    const phonePattern = /^\d{10,14}$/;
    if (!phonePattern.test(phone)) {
      phoneError.innerHTML =
        "Invalid phone number. It must be between 10 and 14 digits.";
      isFormValid = false;
    }
  }

  // Check if full name is empty
  if (fullname.trim() === "") {
    nameError.innerHTML = "Full name is required.";
    isFormValid = false;
  }

  // Check if password is empty
  if (password.trim() === "") {
    passwordError.innerHTML = "Password is required.";
    isFormValid = false;
  }

  // Check if confirm password is empty
  if (confirmPassword.trim() === "") {
    confirmPasswordError.innerHTML = "Confirm password is required.";
    isFormValid = false;
  }

  // Check if passwords match
  if (password !== confirmPassword) {
    confirmPasswordError.innerHTML = "Passwords do not match.";
    isFormValid = false;
  }

  // Return the validation result
  return isFormValid;
}
