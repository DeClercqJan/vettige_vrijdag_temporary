import axios from 'axios';

export function openAddModal() {
    $('#add-item').on('show.bs.modal', async function (event) {
        const modal = this;
        const responseCat = await axios.get(
            `/admin/category/new-complex`,
        );
        const responseProduct = await axios.get(
            `/admin/product/new-complex`,
        );
        const div = document.createElement('div');
        if (responseCat.status == '200' && responseProduct.status == '200') {
            // default
            div.innerHTML = responseProduct.data;
            // to do: handle bad response
        }

        const navTabCategory = modal.childNodes[1].childNodes[1].childNodes[1].childNodes[1].childNodes[1].childNodes[1];
        const navTabProduct = modal.childNodes[1].childNodes[1].childNodes[1].childNodes[1].childNodes[1].childNodes[3];
        if (navTabCategory.classList.contains('active')) {
            div.innerHTML = responseCat.data;
        }
        if (navTabProduct.classList.contains('active')) {
            div.innerHTML = responseProduct.data;
        }

        $('#nav-tab-category').on('click', function (e) {
            div.innerHTML = responseCat.data;
        });
        $('#nav-tab-item').on('click', function (e) {
            div.innerHTML = responseProduct.data;
        });

        modal.childNodes[1].childNodes[1].childNodes[3].childNodes[1].childNodes[1].replaceWith(
            div,
        );
    });
}
