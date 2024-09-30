// Delete button js
let deleteButtons = document.querySelectorAll('.deleteBtn');

deleteButtons.forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();

        let product = this.dataset.name;
        let productID = this.dataset.id;

        let response = confirm('Are you sure you want to delete" ' + product + '?');

        if (response) {
            fetch('deleteBook.php?id=' + productID, {
                method: 'GET'
            })
            .then(response => response.text())
            .then(data => {
                if(data === 'success') {
                    window.location.href = 'index.php';
                }
            })
        }
    });        
});