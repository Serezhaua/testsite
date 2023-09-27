
document.addEventListener('DOMContentLoaded', function() {
    var ajaxurl = ajax_object.ajaxurl;
    var filterButton = document.getElementById('filter-button');
    if (filterButton) {
        filterButton.addEventListener('click', function() {
            var floorCount = document.getElementById('floor-count-filter').value;
            var buildingType = document.getElementById('building-type-filter').value;

            var xhr = new XMLHttpRequest();
            xhr.open('POST', ajaxurl, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = xhr.responseText;
                    var targetElement = document.querySelector('.row-cols-1.row-cols-sm-2.row-cols-md-3.g-3');
                    if (targetElement) {
                        targetElement.innerHTML = response;
                    }
                }
            };

            xhr.onerror = function() {
                console.error('Помилка при виконанні Ajax запиту');
            };

            xhr.send('action=filter_realestate&floorCount=' + floorCount + '&buildingType=' + buildingType);
        });
    }
});
