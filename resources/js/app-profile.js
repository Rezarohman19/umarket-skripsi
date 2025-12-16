import "./bootstrap";
import { createApp } from "vue";
import Profile from "./views/Profile.vue";

// Mount Vue app untuk halaman profile jika elemen ada
const appElement = document.getElementById("app");
if (appElement) {
    createApp(Profile).mount("#app");
}
