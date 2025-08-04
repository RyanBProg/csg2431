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
