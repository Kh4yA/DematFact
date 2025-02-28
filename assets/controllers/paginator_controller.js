import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["paginationControls", "currentPage", "currentPageMoinsUn", "currentPagePlusUn"];

    connect() {
        this.currentPage = 1; // Page actuelle
        this.loadData(this.currentPage); // Charge la première page au démarrage
    }



    async loadData(page) {
        try {
            const section = this.element.dataset.section
            //Verification des paramètre passé en url
            if (typeof page !== "number") {
                console.error("❌ Erreur : `page` doit être un nombre !");
                return;
            }
            //Construction de l'url
            const url = `/api/${section}?page=${encodeURIComponent(page)}`;
            console.log("🔗 URL construite :", url);

            //creation de la requete
            const response = await fetch(url);
            const data = await response.json();

            console.log(data);
            // recuperation des objets dans la data
            if (!data.items || data.items.length === 0) {
                console.warn("⚠️ Aucune donnée reçue !");
                return;
            }

            let clientElement = document.querySelector(`[data-controller~=${section}]`);
            if (!clientElement) {
                console.error(`${section}Controller introuvable !`);
                return;
            }

            let clientController = this.application.getControllerForElementAndIdentifier(clientElement, `${section}`)
            if (clientController && typeof clientController.createTable === "function") {
                console.log("✅ `createTable()` appelée via ClientController !");
                clientController.createTable(data.items);
                console.log(data);

            } else {
                console.error("❌ `createTable()` non trouvée dans ClientController !");
            }

            // 🔹 Vérifie si les boutons existent avant d'essayer de les modifier
            if (this.hasPaginationControlsTarget) {
                let currentPage = data.current_page
                let totalPages = data.total_pages

                // Nombre max de pages visibles avant les "..."
                let pagination = document.querySelector('[data-container-paginator-target="paginationContainer"]');
                pagination.innerHTML = "";
                console.log(pagination);
                

                const maxVisiblePages = 5; // Nombre max de pages affichées
                const startPage = 1;

                // Déterminer les plages de pages à afficher
                let start = Math.max(startPage, currentPage - 2);
                let end = Math.min(totalPages, currentPage + 2);

                // Ajuster si on est au début
                if (currentPage <= 3) {
                    start = startPage;
                    end = Math.min(totalPages, maxVisiblePages);
                }

                // Ajuster si on est à la fin
                if (currentPage >= totalPages - 2) {
                    start = Math.max(startPage, totalPages - 4);
                    end = totalPages;
                }

                // Ajouter la première page si elle n'est pas affichée
                if (start > 1) {
                    this.createPage(startPage,false, pagination);
                    if (start > 2) this.createThreePoints(pagination);
                }

                // Ajouter les pages principales
                for (let i = start; i <= end; i++) {
                    this.createPage(i, i === currentPage, pagination);
                }

                // Ajouter la dernière page si elle n'est pas affichée
                if (end < totalPages) {
                    if (end < totalPages - 1) this.createThreePoints(pagination);
                    this.createPage(totalPages,false, pagination);
                }
                // Gestion des boutons précédent/suivant
                this.paginationControlsTarget.querySelector("button[data-action='click->paginator#previousPage']").disabled = (currentPage === 1);
                this.paginationControlsTarget.querySelector("button[data-action='click->paginator#nextPage']").disabled = (currentPage === totalPages);
            } else {
                console.warn("⚠️ Les boutons de pagination ne sont pas encore dans le DOM.");
            }
        } catch (error) {
            console.error("❌ Erreur lors du chargement des données :", error);
        }
    }
    nextPage() {
        this.currentPage++;
        this.loadData(this.currentPage);
    }

    previousPage() {
        if (this.currentPage > 1) {
            this.currentPage--;
            this.loadData(this.currentPage);
        }
    }
    createPage(number, isActive = false, pagination) {
        let page = document.createElement('a');
        page.className = "box-page flex space-center align-center";
        page.textContent = number;
        page.href = "#";
        if (isActive) {
            page.classList.add("current-page");
            page.classList.remove('box-page')
        }
        page.addEventListener("click", (event) => {
            event.preventDefault();
            this.loadData(number);
        });
        pagination.appendChild(page);
    }

    // Fonction pour créer les "..."
    createThreePoints(pagination) {
        let threePoints = document.createElement('span');
        threePoints.textContent = "...";
        threePoints.className = "three-points flex flex-column";
        pagination.appendChild(threePoints);
    }
}