export class RemoveEffect {
  constructor() {
    this.events();
  }

  events() {
    $(document).on(
      'click',
      '[data-order="remove-button"]',
      this.removeEffect,
    );
  }

  removeEffect(e) {
    /* TODO The item is just not visible anymore, should still be deleted from the list */
    const $row = $(e.currentTarget).parent();

    /* Add delete effect */
    $row.addClass('remove-effect');

    /* Make item not visible anymore */
    setTimeout(() => {
      $row.addClass('d-none');
    }, 800);
  }
}
