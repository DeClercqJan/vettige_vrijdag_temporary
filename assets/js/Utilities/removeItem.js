import axios from 'axios';

export function removeItem() {
  $('#delete-category').on('show.bs.modal', async function (event) {
    const button = event.relatedTarget;
    const name = button.dataset.categoryName;
    const id = button.dataset.categoryId;
    const modal = this;
    // find category-name-span
    modal.childNodes[1].childNodes[1].childNodes[3].childNodes[1].childNodes[1].textContent = name;
    const response = await axios.get(
      `/admin/category/${id}/remove`,
    );
    if (response.status == '200') {
      const div = document.createElement('div');
      div.innerHTML = response.data;
      // find delete-category-form
      modal.childNodes[1].childNodes[1].childNodes[3].childNodes[3].childNodes[1].replaceWith(
        div,
      );
    }
  });

  $('#delete-item').on('show.bs.modal', async function (event) {
    const button = event.relatedTarget;
    const name = button.dataset.productName;
    const id = button.dataset.productId;
    const modal = this;
    // find item-name-span
    modal.childNodes[1].childNodes[1].childNodes[3].childNodes[1].childNodes[1].textContent = name;
    const response = await axios.get(
      `/admin/product/${id}/remove`,
    );
    if (response.status == '200') {
      const div = document.createElement('div');
      div.innerHTML = response.data;
      // find delete-item-form
      modal.childNodes[1].childNodes[1].childNodes[3].childNodes[3].childNodes[1].replaceWith(
        div,
      );
    }
  });
}
