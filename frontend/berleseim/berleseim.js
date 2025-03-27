document.querySelectorAll('.more-info').forEach(function(link) {
    link.addEventListener('click', function() {
        const details = this.nextElementSibling;
        details.classList.toggle('show');
    });
});

document.querySelectorAll('.tab-btn').forEach(function(button) {
    button.addEventListener('click', function() {
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(content => content.style.display = 'none');
        
        this.classList.add('active');
        document.getElementById(this.getAttribute('data-tab')).style.display = 'flex';
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
    const username = localStorage.getItem('username') || 'default';
    const rentalsKey = `rentals_${username}`;
    const rentals = JSON.parse(localStorage.getItem(rentalsKey)) || [];
    const currentDate = new Date();

    const activeTab = document.getElementById('active');
    const pendingTab = document.getElementById('pending');
    const futureTab = document.getElementById('future');
    const completedTab = document.getElementById('completed');
    const summaryContent = document.getElementById('summary-content');

    activeTab.innerHTML = '';
    pendingTab.innerHTML = '';
    futureTab.innerHTML = '';
    completedTab.innerHTML = '';

    if (!isLoggedIn || rentals.length === 0) {
        activeTab.innerHTML = '<p>Nem volt még bérlés erről a profilról.</p>';
        pendingTab.innerHTML = '<p>Nem volt még bérlés erről a profilról.</p>';
        futureTab.innerHTML = '<p>Nem volt még bérlés erről a profilról.</p>';
        completedTab.innerHTML = '<p>Nem volt még bérlés erről a profilról.</p>';
        summaryContent.innerHTML = `
            <p><strong>Összes bérlés:</strong> 0</p>
            <p><strong>Teljes költés:</strong> 0 Ft</p>
            <p><strong>Aktív bérlések száma:</strong> 0</p>
            <p><strong>Fizetésre váró összeg:</strong> 0 Ft</p>
        `;
    } else {
        let totalRentals = rentals.length;
        let totalCost = 0;
        let activeCount = 0;
        let pendingAmount = 0;

        rentals.forEach(rental => {
            const startDate = new Date(rental.startDate);
            const endDate = new Date(rental.endDate);
            const price = parseInt(rental.price.replace(/\D/g, '')) || 0;
            totalCost += price;

            const cardHTML = `
                <div class="berles-card">
                    <h4>${rental.carName}</h4>
                    <p><strong>Időtartam:</strong> ${rental.startDate} - ${rental.endDate}</p>
                    <p><strong>Ár:</strong> ${rental.price}</p>
                    <p><strong>Állapot:</strong> ${getStatus(startDate, endDate, rental.status)}</p>
                    <p><strong>Fizetési státusz:</strong> ${rental.paymentStatus}</p>
            `;

            if (rental.status === 'pending') {
                pendingTab.innerHTML += cardHTML;
                pendingAmount += price;
            } else if (startDate <= currentDate && endDate >= currentDate) {
                activeTab.innerHTML += cardHTML;
                activeCount++;
            } else if (startDate > currentDate) {
                futureTab.innerHTML += cardHTML;
                if (rental.paymentStatus === 'Nincs kifizetve') pendingAmount += price;
            } else {
                completedTab.innerHTML += cardHTML;
            }
        });

        summaryContent.innerHTML = `
            <p><strong>Összes bérlés:</strong> ${totalRentals}</p>
            <p><strong>Teljes költés:</strong> ${totalCost} Ft</p>
            <p><strong>Aktív bérlések száma:</strong> ${activeCount}</p>
            <p><strong>Fizetésre váró összeg:</strong> ${pendingAmount} Ft</p>
        `;
    }

    document.querySelector('.tab-content#active').style.display = 'flex';
});

function getStatus(startDate, endDate, status) {
    const currentDate = new Date();
    if (status === 'pending') return 'Függőben lévő';
    if (startDate <= currentDate && endDate >= currentDate) return 'Jelenleg zajlik';
    if (startDate > currentDate) return 'Jövőbeli bérlés';
    return 'Befejezve';
}