import axios from 'axios';

// to do: move somewhere else
// handle button "Bestelling afsluiten on (admin) index page"
export function closeVettigeVrijdagButton() {
  if (document.getElementById('close-vettige-vrijdag-button')) {
    document
      .getElementById('close-vettige-vrijdag-button')
      .addEventListener('click', async function () {
        const response = await axios.get(
          '/admin/close-vettige-vrijdag',
        );
        if (response.status == '200') {
          location.reload();
        } else {
          console.log('De vettigeVrijdag werd niet afgesloten');
        }
      });
  }
}
