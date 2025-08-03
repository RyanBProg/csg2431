function validateForm() {
  const form = document.create_form;
  const errors = [];

  form.uname.style.borderColor = "";
  form.email.style.borderColor = "";
  form.pword.style.borderColor = "";

  // trim all input values and update the input fields with the trimmed values
  form.uname.value = form.uname.value.trim();
  form.email.value = form.email.value.trim();
  form.pword.value = form.pword.value.trim();

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

  // check the email

  if (form.pword.value === "") {
    errors.push("Password is empty.");
    form.pword.style.borderColor = "red";
  }

  if (form.pword.value.length < 8) {
    errors.push("Password must be at least 8 characters long.");
    form.pword.style.borderColor = "red";
  }

  if (errors.length > 0) {
    alert("Form Errors:\n" + errors.join("\n"));
    return false;
  }
}
