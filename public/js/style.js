document.addEventListener('DOMContentLoaded', () => {
    const burger = document.querySelector('#navbar-menu-button');

    burger.addEventListener('click', () => {
        const menu = document.getElementById("navbar-menu");
        if (menu.style.left == "0%") {
            menu.style.left = "-100%";
        } else {
            menu.style.left = "0%";
        }
    });
});