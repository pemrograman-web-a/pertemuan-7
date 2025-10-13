$(document).ready(function () {
  $("#ContactForm").submit(function (e) {
    e.preventDefault();

    let name = $("#name").val().trim();
    let email = $("#email").val().trim();
    let message = $("#message").val().trim();

    if (name === "") {
      showMessage("Enter your name!", "danger");
      return;
    }
    if (email === "") {
      showMessage("Enter your email!", "danger");
      return;
    }
    if (!validateEmail(email)) {
      showMessage("Invalid email!", "danger");
      return;
    }
    if (message === "") {
      showMessage("Enter your message!", "danger");
      return;
    }

    $.ajax({
      type: "POST",
      url: "ajax.php",
      data: { name: name, email: email, message: message },
      beforeSend: function () {
        $("#submitBtn").prop("disabled", true).addClass("sending");
        showMessage("Sending...", "info");
      },
      success: function (response) {
        $(".message_box").html(response);
        if ($(response).filter(".alert-success").length) {
          $("#ContactForm")[0].reset();
        }
        $("#submitBtn").prop("disabled", false).removeClass("sending");
      },
    });
  });
});

function validateEmail(email) {
  let pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return pattern.test(email);
}

function showMessage(text, type) {
  var cls = "alert-secondary";
  if (type === "danger") cls = "alert-danger";
  if (type === "success") cls = "alert-success";
  if (type === "info") cls = "alert-info";
  $(".message_box").html(
    '<div class="alert ' + cls + '" role="alert">' + text + "</div>"
  );
}
