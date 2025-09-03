document.addEventListener('DOMContentLoaded', function () {

    let counter = 0;
    const extraItemsContainer = document.getElementById('extra-items-container');

    document.addEventListener('click', function (event) {

        if (event.target.closest('.add-event-more')) {

            const addExtraItem = document.getElementById('add-extra-item').innerHTML;
            
           if (extraItemsContainer) {
                
                const newItem = document.createElement('div');
                newItem.innerHTML = addExtraItem;

                
                extraItemsContainer.appendChild(newItem);
                counter++;

                
            } 
        }

        if (event.target.closest('.remove-event-more')) {
            const deleteItem = event.target.closest('.delete-extra-item');
            if (deleteItem) {
                deleteItem.remove();
                counter--;
            }
        }
    });


});