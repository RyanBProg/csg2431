function validateForm() {
  const form = document.create_form;
  const errors = [];

  form.uname.style.borderColor = "";
  form.email.style.borderColor = "";
  form.pword.style.borderColor = "";
  form.pword_conf.style.borderColor = "";
  form.dob.style.borderColor = "";
  form.profile.style.borderColor = "";

  // trim all input values and update the input fields with the trimmed values
  form.uname.value = form.uname.value.trim();
  form.email.value = form.email.value.trim();
  form.pword.value = form.pword.value.trim();
  form.pword_conf.value = form.pword_conf.value.trim();
  form.profile.value = form.profile.value.trim();

  if (form.uname.value === "") {
    errors.push("Username is empty.");
    form.uname.style.borderColor = "red";
  }

  if (!/^[a-zA-Z0-9]+$/.test(form.uname.value)) {
    errors.push(
      "Username may only contain letters and numbers (no spaces or symbols)."
    );
    form.uname.style.borderColor = "red";
  }

  if (form.uname.value.length < 6 || form.uname.value.length > 20) {
    errors.push("Username must be between 6 and 20 characters long.");
    form.uname.style.borderColor = "red";
  }

  // check email

  if (form.pword.value === "") {
    errors.push("Password is empty.");
    form.pword.style.borderColor = "red";
  }

  if (form.pword.value.length < 8) {
    errors.push("Password must be at least 8 characters long.");
    form.pword.style.borderColor = "red";
  }

  if (form.pword_conf.value === "") {
    errors.push("Confirm password is empty.");
    form.pword_conf.style.borderColor = "red";
  }

  if (form.pword.value != form.pword_conf.value) {
    errors.push("Password does not match confirmation.");
    form.pword.style.borderColor = "red";
    form.pword_conf.style.borderColor = "red";
  }

  if (form.dob.value === "") {
    errors.push("Date of birth not specified.");
    form.dob.style.borderColor = "red";
  }

  // check that the user is at least 14 years old
  if (form.dob.value !== "") {
    const dob = new Date(form.dob.value);
    const today = new Date();
    let age = today.getFullYear() - dob.getFullYear();
    const m = today.getMonth() - dob.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
      age--;
    }
    if (isNaN(dob.getTime())) {
      errors.push("Invalid date of birth.");
      form.dob.style.borderColor = "red";
    } else if (age < 14) {
      errors.push("You must be at least 14 years old to register.");
      form.dob.style.borderColor = "red";
    }
  }

  // check profile

  if (!form.agree.checked) {
    errors.push("You must agree to the terms and conditions.");
  }

  if (errors.length > 0) {
    alert("Form Errors:\n" + errors.join("\n"));
    return false;
  }
}
