import "./bootstrap";
import { createApp } from "vue";
import ContactUs from "./views/ContactUs.vue";

const appElement = document.getElementById("app");
if (appElement) {
    createApp(ContactUs).mount("#app");
}
