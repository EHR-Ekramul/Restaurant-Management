function isValid(form) {
  // Get the input fields and error span elements
  const username = form.username.value;
  const email = form.email.value;
  const phone = form.phone.value;
  const fullname = form.fullname.value;
  const password = form.password.value;
  const confirmPassword = form.confirm_password.value;

  const usernameError = document.getElementById("rusererr");
  const emailError = document.getElementById("remailerr");
  const phoneError = document.getElementById("rphoneerr");
  const fullnameError = document.getElementById("rnameerr");
  const passwordError = document.getElementById("rpasserr");
  const confirmPasswordError = document.getElementById("rcpasserr");

  // Clear previous error messages
  usernameError.innerHTML = "";
  emailError.innerHTML = "";
  phoneError.innerHTML = "";
  fullnameError.innerHTML = "";
  passwordError.innerHTML = "";
  confirmPasswordError.innerHTML = "";

  // Flag to track if the form is valid
  let isFormValid = true;

  // Validate username
  if (username.trim() === "") {
    usernameError.innerHTML = "Username is required.";
    isFormValid = false;
  } else if (!/^[A-Za-z0-9]+$/.test(username)) {
    usernameError.innerHTML = "Username can only contain letters and numbers.";
    isFormValid = false;
  }

  // Validate email
  if (email.trim() === "") {
    emailError.innerHTML = "Email is required.";
    isFormValid = false;
  } else if (!/\S+@\S+\.\S+/.test(email)) {
    emailError.innerHTML = "Invalid email format.";
    isFormValid = false;
  }

  // Validate phone number
  if (phone.trim() === "") {
    phoneError.innerHTML = "Phone number is required.";
    isFormValid = false;
  } else if (!/^[0-9]{10,15}$/.test(phone)) {
    phoneError.innerHTML = "Phone number must be between 10 to 15 digits.";
    isFormValid = false;
  }

  // Validate full name
  if (fullname.trim() === "") {
    fullnameError.innerHTML = "Full name is required.";
    isFormValid = false;
  }

  // Validate password
  if (password.trim() === "") {
    passwordError.innerHTML = "Password is required.";
    isFormValid = false;
  }

  // Validate confirm password
  if (confirmPassword.trim() === "") {
    confirmPasswordError.innerHTML = "Confirm password is required.";
    isFormValid = false;
  } else if (password !== confirmPassword) {
    confirmPasswordError.innerHTML = "Passwords do not match.";
    isFormValid = false;
  }

  // Return the validation result
  return isFormValid; // This should correctly determine if the form should be submitted
}
