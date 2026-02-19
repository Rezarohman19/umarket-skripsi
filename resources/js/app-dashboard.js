import "./bootstrap";
import { createApp } from "vue";
import Dashboard from "./views/Dashboard.vue";

const appElement = document.getElementById("app");
if (appElement) {
    createApp(Dashboard).mount("#app");
}
