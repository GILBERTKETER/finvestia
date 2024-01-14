const sideLinks = document.querySelectorAll(
  ".sidebar .side-menu li a:not(.logout)"
);

sideLinks.forEach((item) => {
  const li = item.parentElement;
  item.addEventListener("click", () => {
    sideLinks.forEach((i) => {
      i.parentElement.classList.remove("active");
    });
    li.classList.add("active");
  });
});

const menuBar = document.querySelector(".content nav .bx.bx-menu");
const sideBar = document.querySelector(".sidebar");

menuBar.addEventListener("click", () => {
  sideBar.classList.toggle("close");
});

const searchBtn = document.querySelector(
  ".content nav form .form-input button"
);
const searchBtnIcon = document.querySelector(
  ".content nav form .form-input button .bx"
);
const searchForm = document.querySelector(".content nav form");

searchBtn.addEventListener("click", function (e) {
  if (window.innerWidth < 576) {
    e.preventDefault();
    searchForm.classList.toggle("show");
    if (searchForm.classList.contains("show")) {
      searchBtnIcon.classList.replace("bx-search", "bx-x");
    } else {
      searchBtnIcon.classList.replace("bx-x", "bx-search");
    }
  }
});

window.addEventListener("resize", () => {
  if (window.innerWidth < 768) {
    sideBar.classList.add("close");
  } else {
    sideBar.classList.remove("close");
  }
  if (window.innerWidth > 576) {
    searchBtnIcon.classList.replace("bx-x", "bx-search");
    searchForm.classList.remove("show");
  }
});

// Get the theme toggle switch element
const toggler = document.getElementById("theme-toggle");

// Check if a theme preference is already stored in local storage
const savedTheme = localStorage.getItem("theme");

// If a theme preference is found in local storage, set the toggle switch accordingly
if (savedTheme) {
  toggler.checked = savedTheme === "dark";
  if (savedTheme === "dark") {
    document.body.classList.add("dark");
  }
}

// Function to handle theme toggling
function toggleTheme() {
  if (toggler.checked) {
    document.body.classList.add("dark");
    localStorage.setItem("theme", "dark"); // Save the theme preference to local storage
  } else {
    document.body.classList.remove("dark");
    localStorage.setItem("theme", "light"); // Save the theme preference to local storage
  }
}

// Add event listener to the theme toggle switch
toggler.addEventListener("change", toggleTheme);
let userIcon = document.getElementById("userTab");
userIcon.addEventListener("click", () => {
  let userdetails = document.getElementsByClassName("userdetails")[0]; // Get the first element
  userdetails.classList.toggle("increaseHeight");
});

// JavaScript code to update notifications dynamically
let bell = document.getElementById("bell");
bell.addEventListener("click", () => {
  const sampleNotifications = [
    {
      message:
        "Welcome to FinVestia: Your Journey to Financial Growth Begins Here!",
    },
    {
      message:
        "Feel free to invest any amount. Your savings are secure with us!",
    },
     {
      message:
        "An update on periods of investments, check out!",
    }
  ];

  const notifsContainer = document.querySelector(".notifsNow");
  notifsContainer.innerHTML = ""; // Clear existing h1 tags

  // Loop through the sample notifications and create new h1 tags for each
  sampleNotifications.forEach((notification) => {
    const h1 = document.createElement("h1");
    h1.textContent = notification.message;
    notifsContainer.appendChild(h1);
  });
  // Update the notification count
  const notificationCount = document.getElementById("notificationCount");
  notificationCount.textContent = sampleNotifications.length;

  notifsContainer.classList.toggle("show_notifs"); // Show/hide the notifications container
});
