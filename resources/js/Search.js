document.getElementById('search').addEventListener('input', function () {
    let searchValue = this.value.toLowerCase();
    let rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
        let cellText = row.textContent.toLowerCase();
        if (cellText.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});