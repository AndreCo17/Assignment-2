
function toggleHamburger() {
    let links = document.querySelector(".links");
    let nav = document.querySelector(".topnav");
    links.classList.toggle("toggleLinks");
    nav.classList.toggle("expanded");
    console.log("it works");
}

let icon = document.querySelector(".hamIcon");
icon.addEventListener("click", toggleHamburger);