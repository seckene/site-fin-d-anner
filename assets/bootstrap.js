import { startStimulusApp } from '@symfony/stimulus-bundle';

const app = startStimulusApp();
// register any custom, 3rd party controllers here
// app.register('some_controller_name', SomeImportedController);
document.addEventListener("DOMContentLoaded", function () {
        const toggle = document.getElementById("burgerToggle");
        const menu = document.getElementById("mobileMenu");

        toggle.addEventListener("click", function () {
            menu.classList.toggle("d-none");
        });
    });

