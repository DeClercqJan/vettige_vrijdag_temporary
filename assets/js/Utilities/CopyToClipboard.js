export class CopyToClipboard {
  constructor() {
    this.events();
  }

  events() {
    $(document).on(
      'click',
      '[data-copy="button"]',
      $.proxy(this.copyToClipboard, this),
    );
  }

  copyToClipboard() {
    const $copyText = $('[data-copy="link"]');
    const $tooltip = $('[data-copy="tooltip-text"]');
    $copyText.select();
    document.execCommand('copy');
    $tooltip[0].innerHTML = 'Gekopieerd!';
  }
}
