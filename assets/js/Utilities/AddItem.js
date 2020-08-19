export class AddItem {
  constructor() {
    this.events();
  }

  events() {
    $('[data-order="add"]').on('click', this.addEffect);
    $('[data-order="input-add-button"]').on('click', this.addItem);
  }

  /* Effect on mobile / tablet to indicate change and to get user to click the toggler */
  addEffect(e) {
    const $toggler = $('[data-toggle="toggler"]');
    e.preventDefault();
    $toggler.removeClass('add-effect');
    $toggler.addClass('add-effect');
    setTimeout(() => {
      $($toggler).removeClass('add-effect');
    }, 600);
  }

  addItem() {
    /* Get item from input field */
    const $inputfield = $('[data-order="input-add"]');
    const itemName = $inputfield.val();

    /* Append new row to table with effect */
    const $table = $('[data-order="table"]');
    $table
      .find('tbody')
      .append(
        `${
          '<tr class="new-effect">\n' +
          '                  <td class="order-list-item order-list-item-hamburger">'
        }${itemName}</td>\n` +
          `                  <td class="text-right" data-order="remove-button"><span class="sr-only delete">Delete</span><i class="far fa-trash-alt" aria-hidden="true"></i></td>\n` +
          `                </tr>`,
      );
    /* icon should be changed to the item of the category (order-list-item-category) */

    /* Get rid of the effect class */
    setTimeout(() => {
      $table.find('.new-effect').removeClass('new-effect');
    }, 300);

    /* Make the input field empty */
    $inputfield.val('');
  }
}
