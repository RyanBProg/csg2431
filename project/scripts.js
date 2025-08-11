function validateLogin() {
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

function validateRegister() {
  const form = document.register_form;
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

  // username checks
  if (form.uname.value.length < 6 || form.uname.value.length > 20) {
    errors.push("Username must be between 6 and 20 characters long.");
    form.uname.style.borderColor = "red";
  }

  if (!/^[a-zA-Z0-9]+$/.test(form.uname.value)) {
    errors.push(
      "Username may only contain letters and numbers (no spaces or symbols)."
    );
    form.uname.style.borderColor = "red";
  }

  // email checks
  if (form.email.value === "") {
    errors.push("Email is empty.");
    form.email.style.borderColor = "red";
  }

  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email.value)) {
    errors.push("Invalid email format.");
    form.email.style.borderColor = "red";
  }

  // password checks
  if (form.pword.value.length < 5) {
    errors.push("Password must be at least 5 characters long.");
    form.pword.style.borderColor = "red";
  }

  if (form.pword.value != form.pword_conf.value) {
    errors.push("Password does not match confirmation.");
    form.pword.style.borderColor = "red";
    form.pword_conf.style.borderColor = "red";
  }

  // date of birth checks
  if (form.dob.value === "") {
    errors.push("Date of birth not specified.");
    form.dob.style.borderColor = "red";
  } else {
    const dob = new Date(form.dob.value);
    const today = new Date();
    let age = today.getFullYear() - dob.getFullYear();
    const m = today.getMonth() - dob.getMonth();

    if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
      age--;
    }

    if (age < 14) {
      errors.push("You must be at least 14 years old to register.");
      form.dob.style.borderColor = "red";
    }
  }

  if (!form.agree.checked) {
    errors.push("You must agree to the terms and conditions.");
  }

  if (errors.length > 0) {
    alert("Form Errors:\n" + errors.join("\n"));
    return false;
  }
}

function validateSearch() {
  const form = document.search_form;
  const errors = [];
  form.search.style.borderColor = "";
  form.search.value = form.search.value.trim();

  if (form.search.value === "") {
    errors.push("Search is empty.");
    form.search.style.borderColor = "red";
  }

  if (errors.length > 0) {
    alert("Form Errors:\n" + errors.join("\n"));
    return false;
  }
}

function validateRating() {
  const form = document.rating_form;
  const errors = [];

  if (form.rating.value === "") {
    errors.push("Select a rating.");
  }

  if (errors.length > 0) {
    alert("Form Errors:\n" + errors.join("\n"));
    return false;
  }
}

function validateComment() {
  const form = document.comment_form;
  const errors = [];

  form.comment.value = form.comment.value.trim();

  if (form.comment.value === "") {
    errors.push("Comment is empty.");
  }

  if (errors.length > 0) {
    alert("Form Errors:\n" + errors.join("\n"));
    return false;
  }
}

function handleDelete() {
  return confirm(
    "Are you sure you want to delete this album? This action cannot be undone."
  );
}

function validateProfileUpdate() {
  const form = document.update_profile_form;
  const errors = [];
  form.email.style.borderColor = "";

  form.email.value = form.email.value.trim();
  form.profile.value = form.profile.value.trim();

  // email checks
  if (form.email.value === "") {
    errors.push("Email is empty.");
    form.email.style.borderColor = "red";
  }

  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email.value)) {
    errors.push("Invalid email format.");
    form.email.style.borderColor = "red";
  }

  if (errors.length > 0) {
    alert("Form Errors:\n" + errors.join("\n"));
    return false;
  }
}

function validatePasswordUpdate() {
  const form = document.update_password_form;
  const errors = [];
  form.pword_cur.style.borderColor = "";
  form.pword.style.borderColor = "";
  form.pword_conf.style.borderColor = "";

  form.pword_cur.value = form.pword.value.trim();
  form.pword.value = form.pword.value.trim();
  form.pword_conf.value = form.pword_conf.value.trim();

  // password checks
  if (form.pword.value.length < 5) {
    errors.push("New password must be at least 5 characters long.");
    form.pword.style.borderColor = "red";
  }

  if (form.pword.value != form.pword_conf.value) {
    errors.push("New password does not match confirmation.");
    form.pword.style.borderColor = "red";
    form.pword_conf.style.borderColor = "red";
  }

  if (errors.length > 0) {
    alert("Form Errors:\n" + errors.join("\n"));
    return false;
  }
}
