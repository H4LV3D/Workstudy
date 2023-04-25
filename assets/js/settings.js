const preloader = document.getElementById("preloader");

preloader.style.display = "flex";
window.onload = () => {
  fetch(`${API_URL}/users/`, {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
      Authorization: `token ${token}`,
    },
  })
    .then((response) => response.json())
    .then((data) => {
      preloader.style.display = "none";
      buildPage(...data);
    })
    .catch((error) => {
      console.log(error);
    });
};

const buildPage = (data) => {
  const settingsUsername = document.getElementById("settings-username");
  settingsUsername.innerText = data.username;

  const username = document.getElementById("sidebar-name");
  username.innerText = data.fullname.split(" ")[0];

  const sbLevel = document.getElementById("sidebar-level");
  sbLevel.innerText = data.level || "No level set";
};

const resetPassword = (e) => {
  e.preventDefault();
  const password = document.getElementById("password").value;
  const confirmPassword = document.getElementById("confirm_password").value;

  if (!password || !confirmPassword) {
    alert("All fields are required");
    return;
  }

  if (password !== confirmPassword) {
    alert("Passwords do not match");
    return;
  }

  preloader.style.display = "flex";
  fetch(`${API_URL}/users/reset-password`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Authorization: `token ${token}`,
    },
    body: JSON.stringify({
      password: password,
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      preloader.style.display = "none";
      if (data.error) {
        alert(data.error);
        window.location.reload();
      } else {
        alert(data.message);
        logout();
      }
    });
};

function submitForm() {
  const bankName = document.getElementById("bankName").value;
  const accountNumber = document.getElementById("accountNumber").value;
  const accountName = document.getElementById("accountName").value;

  const data = {
    bankName: bankName,
    accountNumber: accountNumber,
    accountName: accountName,
  };

  console.log(data);

  fetch(`${API_URL}/user/bankdetails`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Authorization: `token ${token}`,
    },
    body: JSON.stringify(data),
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network Issues, please try again later");
      }
      return response.json();
    })
    .then((data) => {
      console.log("Form data sent successfully:", data);
    })
    .catch((error) => {
      console.error("There was a problem sending the form data:", error);
    });
}
