import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["tableBody", "tableHead", "checkbox", "divAction"];

    connect() {
        console.log(`Contrôleur ${this.identifier} bien chargé !`);

        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || "";
        console.log("🔍 Token CSRF récupéré :", this.csrfToken);

        // Supprimer les anciens événements
        // this.removeExistingEvents()

        // this.observer = new MutationObserver(() => {

        //     this.observer.observe(this.tableTarget, { childList: true, subtree: true });

        //     // Attacher les événements existants
        //     // this.attachCheckboxEvents();

        // });
    }
    // attachCheckboxEvents() {
    //     this.tableTarget.querySelectorAll("input[type='checkbox']").forEach(checkbox => {
    //         checkbox.removeEventListener("change", this.toggleCheckbox);
    //         checkbox.addEventListener("change", this.toggleCheckbox.bind(this));
    //     });
    // }
    // removeExistingEvents() {
    //     this.tableTarget.querySelectorAll("input[type='checkbox']").forEach(checkbox => {
    //         checkbox.removeEventListener("change", this.toggleCheckbox);
    //     });
    // }


    createTable(datas) {
        // fetch(apiEndPoint)
        // .then(response => response.json())
        // .then(datas => {
        if (!datas.length) {
            console.warn("Aucune donnée reçue !");
            return;
        }
        console.log(datas);


        this.tableHeadTarget.innerHTML = '';
        this.tableBodyTarget.innerHTML = '';

        // Colonnes à ignorer ou à renommer
        const colonnesIgnorees = ['id', 'user', 'client', 'organisation'];
        const titresColonnes = {
            created_at: 'Créé le',
            total_ht: 'Total HT',
            total_ttc: 'Total TTC',
            total_tva: 'Total TVA',
            remise_pourcent: 'Remise (%)',
            date_emission: 'Date d\'émission',
            code_postal: 'Code postal',
            numero: 'Numéro',
            remise: 'Remise (€)',
            tel_portable: 'N° portable',
            tel_fixe: 'N° fixe',
            fax: 'N° fax',
            raison_sociale: 'Raison sociale'
        };

        // Récupération des clés utiles
        const keys = Object.keys(datas[0]).filter(key => !colonnesIgnorees.includes(key));

        // Création des en-têtes de colonnes
        const headerRow = document.createElement('tr');

        // Ajout checkbox globale
        const checkboxTh = document.createElement('th');
        const masterCheckbox = document.createElement('input');
        masterCheckbox.type = "checkbox";
        masterCheckbox.dataset.action = `change->${this.identifier}#toggleAllCheckboxs`;
        checkboxTh.appendChild(masterCheckbox);
        headerRow.appendChild(checkboxTh);

        // Génération dynamique des titres
        keys.forEach(key => {
            console.log(key);

            // Ne pas ajouter la colonne 'prenom' car elle est déjà fusionnée avec 'nom'
            if (key === 'prenom') {
                return;
            }
            const th = document.createElement('th');

            // Mettre la première lettre en majuscule pour un affichage propre
            let str = key.charAt(0).toUpperCase() + key.slice(1);

            // Définir le bon titre de colonne en fonction des règles
            if (key === 'nom') {
                th.textContent = 'Nom complet'; // Fusion de nom et prénom
            } else {
                th.textContent = titresColonnes[key] || str;
            }
            headerRow.appendChild(th);
        });
        this.tableHeadTarget.appendChild(headerRow);

        // Génération des lignes de données
        datas.forEach(d => {
            const row = document.createElement('tr');

            // Checkbox individuelle
            const checkboxCell = document.createElement('td');
            const checkbox = document.createElement('input');
            checkbox.type = "checkbox";
            checkbox.dataset.action = `change->${this.identifier}#toggleCheckbox`;
            checkbox.dataset.id = d.id;
            checkbox.dataset.baseTarget = "checkbox";
            checkboxCell.appendChild(checkbox);
            row.appendChild(checkboxCell);

            // Cellules dynamiques
            keys.forEach(key => {
                const td = document.createElement('td');
                if (key === 'nom') {
                    td.textContent = d['nom'] + ' ' + (d['prenom'] || '');
                    console.log(d);
                } else if (key === 'prenom') {
                    return;
                } else {
                    td.textContent = d[key];
                }
                if (key === 'actif') {
                    d['actif'] === true ? td.textContent = 'oui' : td.textContent = 'non'
                }
                if (key === 'created_at') {
                    const rawDate = d['created_at'];
                    const formattedDate = new Date(rawDate).toLocaleDateString('fr-FR', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                    td.textContent = formattedDate;
                }
                if (key === 'update_at') {
                    const rawDate = d['update_at'];
                    const formattedDate = new Date(rawDate).toLocaleDateString('fr-FR', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                    td.textContent = formattedDate;
                }
                if (key === 'date_emission') {
                    const rawDate = d['date_emission'];
                    const formattedDate = new Date(rawDate).toLocaleDateString('fr-FR', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                    td.textContent = formattedDate;
                }

                row.appendChild(td);
            });

            this.tableBodyTarget.appendChild(row);
        })
    }
    //     });
    // })
    // .catch(error => console.error(`Erreur lors du chargement (${this.identifier}) :`, error));
    // }
    /**
     * Envoi au serveur q'un bouton est checked ou non
     * @param {*} event 
     */
    toggleCheckbox(event) {
        let checkbox = event.target;
        let isChecked = checkbox.checked;
        let documentId = checkbox.dataset.id;
        let url = `/api/${this.identifier}/update`
        this.gestionShowBoutons(isChecked)
        console.log(checkbox);


        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': this.csrfToken  // 🔥 Ajoute le token si nécessaire
            },
            body: JSON.stringify({
                id: documentId,
                selected: isChecked
            })
        })
            .then(response => response.json())  // 🔥 Convertir la réponse JSON
            .then(data => console.log("Réponse API :", data))
            .catch(error => console.error("Erreur API :", error));
    }
    /**
     * Coche toute les checkbox si il est coche 
     * @param {*} event 
     */
    toggleAllCheckboxs(event) {
        let masterCheckbox = event.target;
        let isChecked = masterCheckbox.checked;

        console.log("Sélectionner tout :", isChecked);

        // Sélectionner/déselectionner toutes les checkboxes
        this.tableBodyTarget.querySelectorAll("input[type='checkbox']").forEach(checkbox => {
            checkbox.checked = isChecked;
            this.gestionShowBoutons(isChecked)
        });
    }
    /**
     * Creer un bouton de suppression
     */
    createRemoveButton() {
        const button = document.createElement('a');
        button.className = 'dynamic-btn-remove btn-remove'
        button.textContent = 'Supprimer';
        button.href = `/${this.identifier}/delete`;
        // On regarde si un bouton existe deja avant de le creer
        if (!this.divActionTarget.querySelector('.dynamic-btn-remove')) {
            this.divActionTarget.appendChild(button);
        }

    }
    /**
     * supprime un bouton dynamique
     */
    deleteRemoveButton(name) {
        // Sélectionne uniquement le bouton généré dynamiquement
        let button = this.divActionTarget.querySelector(`.dynamic-btn-${name}`);
        let btns = this.divActionTarget.querySelectorAll(`.dynamic-btn-${name}`);
        if (button) {
            button.remove();
        }
    }
    /**
     * Bouton pour editer un profil
     * @param {string} identifier
     */
    createEditButton() {
        const button = document.createElement('a');
        button.className = 'dynamic-btn-edit btn-principal'
        button.textContent = 'Editer';
        button.href = `/${this.identifier}/editer`;
        // si Deux checkbox ou plus sont checked alors on suprime le bouton editer 
        if (this.tableBodyTarget.querySelectorAll("input[type='checkbox']:checked").length > 1) {
            this.deleteRemoveButton('edit')
        } else {
            this.divActionTarget.appendChild(button);
        }
    }
    /**
     * Gestion des de l'affichage des bouttons quand les checbox sont checked
     */
    gestionShowBoutons(isChecked) {
        if (isChecked || this.tableBodyTarget.querySelectorAll("input[type='checkbox']:checked").length == 1) {
            this.createRemoveButton()
            this.createEditButton()
        } else if (this.tableBodyTarget.querySelectorAll("input[type='checkbox']:checked").length >= 1) {
            this.deleteRemoveButton('edit')
        } else if (this.tableBodyTarget.querySelectorAll("input[type='checkbox']:checked").length == 0) {
            this.deleteRemoveButton('edit')
            this.deleteRemoveButton('remove')
        }
    }
}