function showEditImageForm(id, kep_url, jarmuAz) {
    console.log('showEditImageForm called with:', { id, kep_url, jarmuAz });

    document.getElementById('editImageId').value = id;
    document.getElementById('edit_kep_url').value = kep_url;
    document.getElementById('edit_jarmuAz').value = jarmuAz;
    document.getElementById('editImageModal').style.display = 'flex';
}

function showEditCarForm(id, rendszam, marka, modell, evjarat, uzemanyag, szin, hengerur, kolcsonzesiAr, ulesekSzama, tipus, kategoria, allapot, telephelyAz, kep_url) {
    document.getElementById('editCarId').value = id;
    document.getElementById('edit_rendszam').value = rendszam;
    document.getElementById('edit_marka').value = marka;
    document.getElementById('edit_modell').value = modell;
    document.getElementById('edit_evjarat').value = evjarat;
    document.getElementById('edit_uzemanyag').value = uzemanyag;
    document.getElementById('edit_szin').value = szin;
    document.getElementById('edit_hengeres').value = hengerur;
    document.getElementById('edit_kolcsonzesiAr').value = kolcsonzesiAr;
    document.getElementById('edit_ulesekSzama').value = ulesekSzama;
    document.getElementById('edit_tipus').value = tipus;
    document.getElementById('edit_kategoria').value = kategoria;
    document.getElementById('edit_allapot').value = allapot;
    document.getElementById('edit_telephelyAz').value = telephelyAz;
    document.getElementById('edit_kep_url').value = kep_url;
    document.getElementById('editCarModal').style.display = 'flex';
}

function showModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = 'flex';
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = 'none';
}

function handleAction(action, id, modalIdToClose) {
    const isSuccess = Math.random() > 0.3;

    if (isSuccess) {
        if (action === 'edit') {
            showModal('resultModal');
            document.getElementById('resultMessage').textContent = 'Sikeresen szerkesztetted';
            if (modalIdToClose) {
                closeModal(modalIdToClose);
            }
        } else if (action === 'delete') {
            showModal('resultModal');
            document.getElementById('resultMessage').textContent = 'Sikeresen törölted';
            const row = document.querySelector(`tr[data-id="${id}"]`);
            if (row) row.remove();
        } else if (action === 'archive') {
            showModal('resultModal');
            document.getElementById('resultMessage').textContent = 'Sikeresen archiváltad';
            const row = document.querySelector(`tr[data-id="${id}"]`);
            if (row) row.remove();
        }
    } else {
        showModal('resultModal');
        document.getElementById('resultMessage').textContent = 'A műveletet nem sikerült végrehajtani';
        if (modalIdToClose) {
            closeModal(modalIdToClose);
        }
    }
}

function setupActionButtons() {
    document.querySelectorAll('button[data-action="delete"]').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.parentElement.parentElement.getAttribute('data-id');
            handleAction('delete', id);
        });
    });

    document.querySelectorAll('button[data-action="archive"]').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.parentElement.parentElement.getAttribute('data-id');
            handleAction('archive', id);
        });
    });
}

function setupFormSubmissions() {
    const editImageForm = document.getElementById('editImageForm');
    if (editImageForm) {
        editImageForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const id = document.getElementById('editImageId').value;
            handleAction('edit', id, 'editImageModal');
        });
    }

    const editCarForm = document.getElementById('editCarForm');
    if (editCarForm) {
        editCarForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const id = document.getElementById('editCarId').value;
            handleAction('edit', id, 'editCarModal');
        });
    }
}

window.onload = function() {
    const imagesTable = document.querySelector("table:nth-of-type(1)");
    const imagesRows = imagesTable.querySelectorAll("tr");
    if (imagesRows.length > 0) {
        const rowHeight = 100 / imagesRows.length;
        imagesRows.forEach(row => {
            row.style.height = `${rowHeight}%`;
        });
    }

    const archivedImagesTable = document.querySelector("table:nth-of-type(2)");
    const archivedImagesRows = archivedImagesTable.querySelectorAll("tr");
    if (archivedImagesRows.length > 0) {
        const rowHeight = 100 / archivedImagesRows.length;
        archivedImagesRows.forEach(row => {
            row.style.height = `${rowHeight}%`;
        });
    }

    const carsTable = document.querySelector("table:nth-of-type(3)");
    const carsRows = carsTable.querySelectorAll("tr");
    if (carsRows.length > 0) {
        const rowHeight = 100 / carsRows.length;
        carsRows.forEach(row => {
            row.style.height = `${rowHeight}%`;
        });
    }

    const archivedCarsTable = document.querySelector("table:nth-of-type(4)");
    const archivedCarsRows = archivedCarsTable.querySelectorAll("tr");
    if (archivedCarsRows.length > 0) {
        const rowHeight = 100 / archivedCarsRows.length;
        archivedCarsRows.forEach(row => {
            row.style.height = `${rowHeight}%`;
        });
    }

    setupActionButtons();
    setupFormSubmissions();
};