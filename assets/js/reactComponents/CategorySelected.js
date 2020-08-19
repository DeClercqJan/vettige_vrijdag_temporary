import React, { Component } from 'react';
import PropTypes from 'prop-types';

export default class CategorySelected extends Component {
  render() {
    const { categorySelected, handleAddToBasket } = this.props;

    function handleOnClick(event, productId) {
      event.preventDefault();
      handleAddToBasket(productId);
    }

    return (
      <div className="col-md-8 col-lg-5 offset-md-4">
        <div className="content content-category mt-md-4 mb-md-0">
          <h1>
            {`Kies je ${categorySelected.name}`}
          </h1>
          {/* <!-- Items should be added to the list when clicked, and the page should stay on the same scroll-position --> */}
          {categorySelected.products.map((product) => (
            <a
              href=""
              className="card menu-item mb-3 d-flex flex-row align-items-center"
              data-order="add"
              key={product.id}
              onClick={(event) => {
                handleOnClick(event, product.id);
              }}
            >
              <span className="menu-item-name mr-auto p-2">
                {product.name}
              </span>
              <div className="btn btn-outline-primary align-self-stretch d-flex justify-content-center align-items-center">
                {!product.alreadyAddedToBasket
                  ? 'Da wil ik!'
                  : 'Nog eentje!'}
              </div>

              {/* <!-- add to list when clicked --> */}
            </a>
          ))}
        </div>
      </div>
    );
  }
}

CategorySelected.propTypes = {
  categorySelected: PropTypes.object.isRequired,
  handleAddToBasket: PropTypes.func.isRequired,
};
