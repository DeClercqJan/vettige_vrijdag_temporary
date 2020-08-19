import React, { Component, Fragment } from 'react';
import PropTypes from 'prop-types';
import OrderToggler from './OrderToggler';
import OrderForm from './OrderForm';
import OrderNav from './OrderNav';
import OrderEmpty from './OrderEmpty';
import CategorySelected from './CategorySelected';
import setLocalStorageItem from '../Utilities/setLocalStorageItem';
import getLocalStorageItemIfExists from '../Utilities/getLocalStorageItemIfExists';
import withContext from './withContext';

class OrderPageComponents extends Component {
  constructor(props) {
    super(props);
    this.state = {
      toggleClosed: true,
    };
    this.registerToggleClosed = this.registerToggleClosed.bind(this);
  }

  componentDidMount() {
    this.setState({
      toggleClosed: getLocalStorageItemIfExists(
        'toggleClosed',
        'boolean',
      ),
    });
  }

  registerToggleClosed() {
    if (this.state.toggleClosed === false) {
      setLocalStorageItem('toggleClosed', 'true');
      this.setState({ toggleClosed: true });
    }
    if (this.state.toggleClosed === true) {
      setLocalStorageItem('toggleClosed', 'false');
      this.setState({ toggleClosed: false });
    }
  }

  render() {
    const {
      handleCategorySelection,
      handleAddToBasket,
      handleRemoveFromBasket,
      orderBasket,
      categorySelected,
      categories,
      possibleVettigeVrijdagSlug,
      haveCategoriesLoaded,
      orderErrorMessage,
      setOrderErrorMessage,
    } = this.props;

    return (
      <div className="container-fluid">
        <OrderToggler
          registerToggleClosed={this.registerToggleClosed}
        />
        <div className="row">
          <OrderNav
            categories={categories}
            handleCategorySelection={handleCategorySelection}
            possibleVettigeVrijdagSlug={possibleVettigeVrijdagSlug}
            haveCategoriesLoaded={haveCategoriesLoaded}
          />
          {categorySelected.hasOwnProperty('id') ? (
            <CategorySelected
              categorySelected={categorySelected}
              handleAddToBasket={handleAddToBasket}
            />
          ) : (
            <>
              <OrderEmpty />
              {/* <SomeComponent /> */}
            </>
          )}
          <div
            id="divAboveForm"
            className={`col-lg-3 bg-secondary mh-100vh order text-white w-md-50 ml-md-auto w-lg-100 ${
              this.state.toggleClosed ? 'toggle-closed' : ''
            }`}
            data-toggle="toggling"
          >
            <OrderForm
              orderBasket={orderBasket}
              handleRemoveFromBasket={handleRemoveFromBasket}
              categories={categories}
              handleAddToBasket={handleAddToBasket}
              possibleVettigeVrijdagSlug={possibleVettigeVrijdagSlug}
              orderErrorMessage={orderErrorMessage}
              setOrderErrorMessage={setOrderErrorMessage}
            />
          </div>
        </div>
      </div>
    );
  }
}

export default withContext(OrderPageComponents);

CategorySelected.propTypes = {
  categories: PropTypes.func,
  categorySelected: PropTypes.object.isRequired,
  handleCategorySelection: PropTypes.func,
  handleAddToBasket: PropTypes.func.isRequired,
  handleRemoveFromBasket: PropTypes.func,
  orderBasket: PropTypes.array,
  possibleVettigeVrijdagSlug: PropTypes.string,
  saveSelectedSearchInput: PropTypes.func,
  registerAddClick: PropTypes.func,
  setOrderErrorMessage: PropTypes.func.isRequired,
  orderErrorMessage: PropTypes.string.isRequired,
};
