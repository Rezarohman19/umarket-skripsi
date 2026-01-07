import "./bootstrap";
import { createApp } from "vue";
import Checkout from "./views/TermsAndConditions.vue";

const appElement = document.getElementById("app");
if (appElement) {
    createApp(Checkout).mount("#app");
}
