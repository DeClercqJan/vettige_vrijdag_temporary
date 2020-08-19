import React, { Component } from 'react';
import PropTypes from 'prop-types';
import AsyncSelect from 'react-select/async/dist/react-select.esm';
import getLocalStorageItemIfExists from '../Utilities/getLocalStorageItemIfExists';
import setLocalStorageItem from '../Utilities/setLocalStorageItem';

export default class Search extends Component {
  constructor(props) {
    super(props);
    this.state = {
      selected: {},
    };
    this.saveLastAddedProduct = this.saveLastAddedProduct.bind(this);
  }

  componentDidMount() {
    this.setState({
      selected: getLocalStorageItemIfExists('selected', 'object'),
    });
  }

  saveLastAddedProduct(product) {
    setLocalStorageItem('selected', product);
    this.setState({ selected: product });
  }

  render() {
    const { categories, handleAddToBasket } = this.props;

    const productOptions = [];

    categories.forEach((category) => {
      category.products.forEach((product) => {
        const productOption = {
          value: product.id,
          label: product.name,
        };
        productOptions.push(productOption);
      });
    });

    const filterOptions = (inputValue) => {
      return productOptions.filter((i) =>
        i.label.toLowerCase().includes(inputValue.toLowerCase()),
      );
    };

    const loadOptions = (inputValue, callback) => {
      setTimeout(() => {
        callback(filterOptions(inputValue));
      }, 1000);
    };

    function onChangeAsyncSelect(option, async) {
      handleAddToBasket(option.value);
    }

    function handleOnClick(selected, async) {
      handleAddToBasket(selected.value);
    }

    return (
      <div className="input-group mb-3">
        <AsyncSelect
          className="form-control"
          aria-label="Add"
          id="add"
          aria-describedby="button-addon"
          cacheOptions
          loadOptions={loadOptions}
          defaultOptions={productOptions}
          placeholder={
            this.state.selected.label ? this.state.selected.label : ''
          }
          onChange={(option) => {
            onChangeAsyncSelect(
              option,
              this.saveLastAddedProduct(option),
            );
          }}
        />

        <div className="input-group-append">
          <button
            className="btn btn-primary mb-3 px-3 h-100"
            type="button"
            onClick={(event) => {
              handleOnClick(
                this.state.selected,
                this.saveLastAddedProduct(this.state.selected),
              );
            }}
            id="button-addon"
          >
            +
          </button>
        </div>
      </div>
    );
  }
}

Search.propTypes = {
  categories: PropTypes.array.isRequired,
  handleAddToBasket: PropTypes.func.isRequired,
};
