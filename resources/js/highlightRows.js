document.addEventListener('DOMContentLoaded', function() {
    const tables = document.querySelectorAll('table');

    tables.forEach(table => {
        const rows = table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            row.addEventListener('click', function() {
                rows.forEach(r => r.classList.remove('selected'));
                this.classList.add('selected');
            });
        });
    });
});
