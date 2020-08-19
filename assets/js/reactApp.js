import React from 'react';
import { render } from 'react-dom';
import OrderPageFunctions from './reactComponents/OrderPageFunctions';
import '@fortawesome/fontawesome-free/js/all';
import MyProvider from './reactComponents/MyProvider';

render(
  <React.StrictMode>
    <MyProvider>
      <OrderPageFunctions />
    </MyProvider>
  </React.StrictMode>,
  document.getElementById('reactApp'),
);
