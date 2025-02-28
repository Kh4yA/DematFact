import './styles/app.scss';
import './bootstrap.js';
import { Application } from "@hotwired/stimulus";
import { definitionsFromContext } from "@hotwired/stimulus-webpack-helpers";

const application = Application.start();
window.Stimulus = application; // ✅ Exposer Stimulus globalement

const context = require.context("./controllers", true, /\.js$/);
const controllers = definitionsFromContext(context);
application.load(controllers);

console.log("📦 Stimulus chargé avec les contrôleurs :", controllers);