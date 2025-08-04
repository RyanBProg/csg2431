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
