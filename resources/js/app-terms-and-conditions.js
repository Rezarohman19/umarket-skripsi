import "./bootstrap";
import { createApp } from "vue";
import TermsAndConditions from "./views/TermsAndConditions.vue";

const appElement = document.getElementById("app");
if (appElement) {
    createApp(TermsAndConditions).mount("#app");
}
