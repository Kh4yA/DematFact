import BaseController from "./base_controller.js";

export default class extends BaseController {
    connect() {
        super.connect(); 
        console.log(`🔄 Contrôleur ${this.identifier} connecté !`);
    }
}