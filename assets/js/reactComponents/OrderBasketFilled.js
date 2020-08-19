import React, { Component } from 'react';
import PropTypes from 'prop-types';
import {RemoveEffect} from "../Utilities/RemoveEffect";

export default class OrderBasketFilled extends Component {
  render() {
    const { orderBasket, handleRemoveFromBasket } = this.props;

    new RemoveEffect();

    function handleClick(event, productId) {
      setTimeout(() => handleRemoveFromBasket(productId), 5000);
    }

    return (
      <table className="table order-list mb-0">
        <tbody>
          {orderBasket.map((orderBasketElement) => (
            <tr
              key={orderBasketElement.product.id}
              onClick={(event) =>
                handleClick(event, orderBasketElement.product.id)
              }
            >
              <td className="w-100 order-list-item order-list-item-hamburger">
                {orderBasketElement.amount} x{' '}
                {orderBasketElement.product.name}{' '}
              </td>
              <td className="w-100 text-right"
                data-order="remove-button"
              >
                <span className="sr-only delete">Delete</span>
                <i className="far fa-trash-alt" aria-hidden="true" />
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    );
  }
}

OrderBasketFilled.propTypes = {
  orderBasket: PropTypes.array.isRequired,
  handleRemoveFromBasket: PropTypes.func.isRequired,
};
