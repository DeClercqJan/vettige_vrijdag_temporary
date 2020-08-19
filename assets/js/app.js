/* Bootstrap imports */
import 'bootstrap/dist/js/bootstrap';

/* Font Awesome */
import '@fortawesome/fontawesome-free/js/all';

/* Utilities imports */
import ResizeFunction from './Utilities/Resize';
import {Toggle} from './Utilities/Toggle';
import {ScrollTo} from './Utilities/ScrollTo';
import {CopyToClipboard} from './Utilities/CopyToClipboard';
import {AddItem} from './Utilities/AddItem';
import {RemoveEffect} from './Utilities/RemoveEffect';
import {removeItem} from './Utilities/removeItem';
import {closeVettigeVrijdagButton} from './Utilities/closeVettigeVrijdagButton';
import {changeColorMenuIcons} from './Utilities/changeColorMenuIcons';
import {openUpdateModals} from './Utilities/openUpdateModals';
import {openAddModal} from './Utilities/openAddModal';
import { updateViaContentEditable } from './Utilities/updateViaContentEditable';

import '../Sass/screen.scss';
/* import {Fancybox} from './Utilities/Fancybox'; */

/* Theme imports */
/* eg. import tooltip from './Theme/Tooltip'; */

/* Renders */
new ResizeFunction();
new Toggle();
new ScrollTo();
new CopyToClipboard();
new AddItem();
new RemoveEffect();

const imagesContext = require.context(
    '../images',
    true,
    /\.(png|jpg|jpeg|gif|ico|svg|webp)$/,
);
imagesContext.keys().forEach(imagesContext);

closeVettigeVrijdagButton();
removeItem();
changeColorMenuIcons();
openUpdateModals();
openAddModal();
updateViaContentEditable('h1-category-contenteditable', 'categoryId', 'category', "data-category-id");
updateViaContentEditable('span-item-contenteditable', 'productId', 'product', "data-product-id");
