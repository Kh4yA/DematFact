import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["formPro", "clientPro", "clientPart"]; // Déclare la cible formPro

    connect() {
        console.log("📌 Stimulus chargé pour form-client !");
        this.toggleFormPro()
    }

    toggleFormPro(event) {        
        let formPro = this.element.querySelector("[data-form-pro-target='formPro']");
        let clientPro = this.element.querySelector("[data-form-pro-target='clientPro']");
        let clientPart = this.element.querySelector("[data-form-pro-target='clientPart']");
        let toggleInput = this.element.querySelector("input[data-action='change->form-client#toggleFormPro']").checked;

        console.log(toggleInput);
        
        if (formPro) {
            formPro.classList.toggle("d-none");   
        }
        if(!toggleInput){
            clientPart.classList.add('type-client-no-selected')
            clientPro.classList.remove('type-client-no-selected')
            } else {
                clientPart.classList.remove('type-client-no-selected')
                clientPro.classList.add('type-client-no-selected')
                clientPart.classList.add('type-client-selected')
        }
    }
}