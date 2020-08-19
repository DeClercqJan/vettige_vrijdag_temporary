import axios from 'axios';
import regeneratorRuntime from 'regenerator-runtime';

export class Toggle {
  constructor() {
    this.events();
  }

  events() {
    $('[data-toggle="toggler"]').on('click', this.menuToggler);
    $('[data-toggle="switch-toggler"]').on(
      'click',
      this.switchToggler,
    );
  }

  menuToggler(e) {
    $('[data-toggle="toggling"]').toggleClass('toggle-closed');
    $('body').toggleClass('modal-open');
    $(e.currentTarget).toggleClass('toggle-open');
  }

  // button 'bokes/frieteuh
  async switchToggler() {
    $('[data-toggle="switch-toggling"]').toggleClass('no-fries');
    const response = await axios.get(
      '/admin/open-vettige-vrijdag',
    );
    if (response.status == '201') {
      location.reload();
    } else {
      console.log('er is al een vettige vrijdag open');
    }
  }
}
