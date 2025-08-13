function validateLogin() {
  const form = document.login_form;
  const errors = [];

  form.username.style.borderColor = "";
  form.pword.style.borderColor = "";

  // trim all input values and update the input fields with the trimmed values
  form.username.value = form.username.value.trim();
  form.pword.value = form.pword.value.trim();

  if (form.username.value === "") {
    errors.push("Username is empty.");
    form.username.style.borderColor = "red";
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
    "Are you sure you want to delete this album? Deleting the album will delete all tracks, ratings and comments associated with it"
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
  form.current.style.borderColor = "";
  form.pword.style.borderColor = "";
  form.pword_conf.style.borderColor = "";

  form.current.value = form.current.value.trim();
  form.pword.value = form.pword.value.trim();
  form.pword_conf.value = form.pword_conf.value.trim();

  // password checks
  if (form.current.value === "") {
    errors.push("Please provide a current password.");
    form.current.style.borderColor = "red";
  }

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

function validateAlbum() {
  const form = document.album_form;
  const errors = [];
  form.title.style.borderColor = "";
  form.artist.style.borderColor = "";
  form.label.style.borderColor = "";
  form.release_year.style.borderColor = "";

  form.title.value = form.title.value.trim();
  form.artist.value = form.artist.value.trim();
  form.label.value = form.label.value.trim();
  form.release_year.value = form.release_year.value.trim();

  if (form.title.value === "") {
    errors.push("Title is required.");
    form.title.style.borderColor = "red";
  }

  if (form.artist.value === "") {
    errors.push("Artist is required.");
    form.artist.style.borderColor = "red";
  }

  if (form.label.value === "") {
    errors.push("Label is required.");
    form.label.style.borderColor = "red";
  }

  if (form.release_year.value === "") {
    errors.push("Release date is required.");
    form.release_year.style.borderColor = "red";
  }

  const year = parseInt(form.release_year.value, 10);
  const currentYear = new Date().getFullYear();

  if (isNaN(year) || year < 1940 || year > currentYear) {
    errors.push(
      `Release year must be an integer between 1940 and ${currentYear}.`
    );
    form.release_year.style.borderColor = "red";
  }

  if (errors.length > 0) {
    alert("Form Errors:\n" + errors.join("\n"));
    return false;
  }
}
