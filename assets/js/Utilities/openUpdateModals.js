import axios from 'axios';

export function openUpdateModals() {
    $('#edit-cat').on('show.bs.modal', async function (event) {
        const button = event.relatedTarget;
        const id = button.dataset.categoryId;
        const modal = this;
        const response = await axios.get(
            `/admin/category/${id}/update-complex`,
        );
        if (response.status == '200') {
            const div = document.createElement('div');
            div.innerHTML = response.data;
            // find update-category-form
            modal.childNodes[1].childNodes[1].childNodes[3].childNodes[1].replaceWith(
                div,
            );
        }
    });

    $('#edit-item').on('show.bs.modal', async function (event) {
        const button = event.relatedTarget;
        const id = button.dataset.productId;
        const modal = this;
        const response = await axios.get(
            `/admin/product/${id}/update-complex`,
        );
        if (response.status == '200') {
            const div = document.createElement('div');
            div.innerHTML = response.data;
            // find update-item-form
            modal.childNodes[1].childNodes[1].childNodes[3].childNodes[1].replaceWith(
                div,
            );
        }
    });
}
