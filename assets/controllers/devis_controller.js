import BaseController from "./base_controller.js";

export default class extends BaseController {
    static targets = ["lignesContainer", "addButton", 'template'];
    connect() {
        super.connect()
    }


    addLigne(event) {
        event.preventDefault();

        // Récupération du contenu du template
        const container = this.lignesContainerTarget;
        const prototypeHtml = this.templateTarget.innerHTML;

        // Calcul de l'index en fonction du nombre de lignes existantes
        const index = container.querySelectorAll('.group-form').length;

        // Remplacement du placeholder __name__ par l'index
        const newFormHtml = prototypeHtml.replace(/__name__/g, index);

        // Création d'un conteneur temporaire pour insérer le nouveau bloc
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = newFormHtml;

        // Ajout du nouveau bloc dans le conteneur principal
        container.appendChild(tempDiv.firstElementChild);
    }

    updateLigne(event) {
        const select = event.currentTarget;
        const selectedOption = select.options[select.selectedIndex];
        const prixHt = parseFloat(selectedOption.dataset.prixht) || 0;
        const prixTtc = parseFloat(selectedOption.dataset.prixttc) || 0;
        const taxe = selectedOption.dataset.taxe || '';
    
        // Trouver la ligne associée
        const ligneForm = select.closest('.ligne-devis-container');
    
        // Sélectionner les champs input
        const prixhTInput = ligneForm.querySelector("input[name*='[prix_unitaire_ht]']");
        const prixTTCInput = ligneForm.querySelector("input[name*='[prix_unitaire_ttc]']");
        const taxeInput = ligneForm.querySelector("input[name*='[taxe]']");
        const ligneTotalTTC = ligneForm.querySelector("input[name*='[ligne_totale_ttc]']");
        const quantiteInput = ligneForm.querySelector("input[name*='[quantite]']");
    
        // Met à jour les champs avec les valeurs correctes
        if (prixhTInput) prixhTInput.value = prixHt;
        if (prixTTCInput){
             prixTTCInput.value = prixTtc;
             ligneTotalTTC.value = prixTtc
        }
        if (taxeInput) taxeInput.value = taxe;
    
        // Vérifier si la quantité change et recalculer le total
        if (quantiteInput && ligneTotalTTC) {
            quantiteInput.addEventListener("input", () => {
                ligneTotalTTC.value = this.countWithQuantite(quantiteInput.value, prixTtc);
            });
        }
    }
    
    countWithQuantite(quantite, prix) {
        return parseFloat(quantite || 0) * parseFloat(prix || 0);
    }
    removeLigne(event) {
        event.preventDefault();
        // On supprime la ligne parente du bouton cliqué
        const ligne = event.currentTarget.closest('.group-form');
        if (ligne) {
            ligne.remove();
        }
    }
}