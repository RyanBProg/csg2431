function validateForm() {
  const form = document.login_form;
  const errors = [];

  form.email.style.borderColor = "";
  form.pword.style.borderColor = "";

  // trim all input values and update the input fields with the trimmed values
  form.email.value = form.email.value.trim();
  form.pword.value = form.pword.value.trim();

  if (form.email.value === "") {
    errors.push("Email is empty.");
    form.email.style.borderColor = "red";
  }

  if (form.pword.value === "") {
    errors.push("Password is empty.");
    form.pword.style.borderColor = "red";
  }

  if (errors.length > 0) {
    alert("Form Errors:\n" + errors.join("\n"));
    return false;
  }
}
