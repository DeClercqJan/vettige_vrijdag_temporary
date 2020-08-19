import React, { Component } from 'react';
import MyContext from './MyContext';

export default class MyProvider extends Component {
  render() {
    const baseUrl = '';
    // note: id's, slugs, and other variable are not included here. The links here provided are cut off before a variable, if such a variabele exists, is encountered.
    // these need to be added where these links are used
    return (
      <MyContext.Provider
        value={{
          links: {
            baseUrl: `${baseUrl}`,
            uploadedIconsDirectory: `${baseUrl}/uploads/icons`,
            uploadedImagesDirectory: `${baseUrl}/uploads/images`,
            change_menu: `${baseUrl}/admin/change-menu`,
            close_vettige_vrijdag: `${baseUrl}/admin/change-menu/admin/close-vettige-vrijdag`,
            category_new: `${baseUrl}https://localhost:8000/admin/change-menu/admin/category/new`,
            vettige_vrijdag_create_pdf: `${baseUrl}/admin/change-menu/admin/vettige-vrijdag/`,
            product_new: `${baseUrl}/admin/change-menu/admin/product/new`,
            open_vettige_vrijdag: `${baseUrl}/admin/change-menu/admin/open-vettige-vrijdag`,
            category_update: `${baseUrl}/admin/change-menu/admin/category`,
            product_update: `${baseUrl}/admin/product/`,
            vettige_vrijdag_previous: `${baseUrl}admin/vettige-vrijdag/previous`,
            confirm_order: `${baseUrl}/confirm-order`,
            get_categories: `${baseUrl}/api/categories`,
            login: `${baseUrl}/login`,
            logout: `${baseUrl}/logout`,
            order_home: `${baseUrl}/order`,
            submit_order: `${baseUrl}/submit-order`,
            vettige_vrijdag: `${baseUrl}`,
          },
        }}
      >
        {this.props.children}
      </MyContext.Provider>
    );
  }
}
