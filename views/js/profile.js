function isValid(form) {
    // Get the input fields and error span elements
    const fullName = form.fullName.value.trim();
    const email = form.email.value.trim();
    const phoneNumber = form.phoneNumber.value.trim();

    const fullNameError = document.getElementById("pfullName");
    const emailError = document.getElementById("pemail");
    const phoneError = document.getElementById("pphone");

    // Clear previous error messages
    fullNameError.innerHTML = "";
    emailError.innerHTML = "";
    phoneError.innerHTML = "";

    // Flag to track if the form is valid
    let isFormValid = true;

    // Validate full name (should not be empty)
    if (fullName === "") {
        fullNameError.innerHTML = "Full name is required.";
        isFormValid = false;
    }

    // Validate email (should not be empty and should have valid format)
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (email === "") {
        emailError.innerHTML = "Email is required.";
        isFormValid = false;
    } else if (!emailPattern.test(email)) {
        emailError.innerHTML = "Invalid email format.";
        isFormValid = false;
    }

    // Validate phone number (should not be empty and should have valid format)
    const phonePattern = /^[0-9]{10,15}$/;
    if (phoneNumber === "") {
        phoneError.innerHTML = "Phone number is required.";
        isFormValid = false;
    } else if (!phonePattern.test(phoneNumber)) {
        phoneError.innerHTML = "Invalid phone number format.";
        isFormValid = false;
    }

    // Return the validation result
    return isFormValid;
}
