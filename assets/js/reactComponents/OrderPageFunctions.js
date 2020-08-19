import React, { Component } from 'react';
import axios from 'axios';
import PropTypes from 'prop-types';
import OrderPageComponents from './OrderPageComponents';
import MyProvider from './MyProvider';
import getLocalStorageItemIfExists from '../Utilities/getLocalStorageItemIfExists';
import setLocalStorageItem from '../Utilities/setLocalStorageItem';
import withContext from './withContext';
import Search from './Search';

class OrderPageFunctions extends Component {
  constructor(props) {
    super(props);
    this.state = {
      categories: [],
      haveCategoriesLoaded: false,
      categorySelected: {},
      orderBasket: [],
      possibleVettigeVrijdagSlug: window.location.pathname.substr(7),
      orderErrorMessage: '',
    };
    this.handleCategorySelection = this.handleCategorySelection.bind(
      this,
    );
    this.handleAddToBasket = this.handleAddToBasket.bind(this);
    this.handleRemoveFromBasket = this.handleRemoveFromBasket.bind(
      this,
    );
    this.registerClick = this.registerClick.bind(this);
    this.setOrderErrorMessage = this.setOrderErrorMessage.bind(this);
  }

  async componentDidMount() {
    const response = await axios.get(
      `${this.props.links.get_categories}`,
    );

    this.setState({
      categories: response.data,
      haveCategoriesLoaded: true,
      orderBasket: getLocalStorageItemIfExists(
        'orderBasket',
        'array',
      ),
    });
  }

  handleCategorySelection(categoryId) {
    this.state.categories.forEach((category) => {
      if (parseInt(categoryId) === category.id) {
        this.setState({ categorySelected: category });
      }
    });
  }

  handleAddToBasket(selectedProductId) {
    let productToAdd = {};
    this.state.categories.forEach((category) => {
      category.products.forEach((product) => {
        if (parseInt(selectedProductId) === product.id) {
          productToAdd = product;
        }
      });
    });

    let orderBasketNew = [];
    this.setState((prevState) => {
      const orderBasketCopy = prevState.orderBasket;
      const found = orderBasketCopy.find(
        (element) =>
          element.product.id === parseInt(selectedProductId),
      );
      if (found) {
        const index = orderBasketCopy.indexOf(found);
        const productWithAmount = {
          product: productToAdd,
          amount: found.amount + 1,
        };
        orderBasketNew = [...prevState.orderBasket];
        orderBasketNew[index] = productWithAmount;
      }
      if (!found) {
        const productWithAmount = {
          product: productToAdd,
          amount: 1,
        };
        orderBasketNew = [
          ...prevState.orderBasket,
          productWithAmount,
        ];
      }
      setLocalStorageItem('orderBasket', orderBasketNew);
      return { orderBasket: orderBasketNew };
    });

    this.registerClick(productToAdd.id, true);
  }

  handleRemoveFromBasket(selectedProductId) {
    this.setState((prevState) => {
      const orderBasketNew = prevState.orderBasket.filter(
        (element) => element.product.id !== selectedProductId,
      );
      // if closing browser page quickly, doesnt save correctly
      setLocalStorageItem('orderBasket', orderBasketNew);
      return { orderBasket: orderBasketNew };
    });

    this.registerClick(selectedProductId, false);
  }

  // needed to variably display button text by adding property to product
  // note: is forgotten on closing of page
  registerClick(productId, trueOrFalse) {
    let categoriesNew = [];
    let categoryFound = {};
    let productFound = {};
    this.setState((prevState) => {
      const categoriesCopy = prevState.categories;
      categoryFound = categoriesCopy.find((category) => {
        productFound = category.products.find((product) => {
          if (product.id == productId) {
            return product;
          }
        });
        if (productFound) {
          return category;
        }
      });
      if (categoryFound && productFound) {
        const indexCategory = categoriesCopy.indexOf(categoryFound);
        const indexProduct = categoriesCopy[
          indexCategory
        ].products.indexOf(productFound);
        productFound.alreadyAddedToBasket = trueOrFalse;
        categoriesNew = [...prevState.categories];
        categoriesNew[indexCategory].products[
          indexProduct
        ] = productFound;
        return { categories: categoriesNew };
      }
    });
  }

  setOrderErrorMessage(value) {
    this.setState({ orderErrorMessage: value });
  }

  render() {
    return (
      <MyProvider>
        <OrderPageComponents
          handleCategorySelection={this.handleCategorySelection}
          handleAddToBasket={this.handleAddToBasket}
          handleRemoveFromBasket={this.handleRemoveFromBasket}
          orderBasket={this.state.orderBasket}
          categorySelected={this.state.categorySelected}
          categories={this.state.categories}
          possibleVettigeVrijdagSlug={
            this.state.possibleVettigeVrijdagSlug
          }
          haveCategoriesLoaded={this.state.haveCategoriesLoaded}
          possibleVettigeVrijdagSlug={
            this.state.possibleVettigeVrijdagSlug
          }
          orderErrorMessage={this.state.orderErrorMessage}
          setOrderErrorMessage={this.setOrderErrorMessage}
        />
      </MyProvider>
    );
  }
}

export default withContext(OrderPageFunctions);

Search.propTypes = {
  links: PropTypes.object.isRequired,
};
