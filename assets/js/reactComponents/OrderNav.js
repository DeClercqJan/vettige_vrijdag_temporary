import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { changeColorMenuIcons } from '../Utilities/changeColorMenuIcons';
import OrderLogo from './OrderLogo';
import withContext from './withContext';

class OrderNav extends Component {
  componentDidMount() {
    changeColorMenuIcons();
  }

  componentDidUpdate(prevProps, prevState, snapshot) {
    changeColorMenuIcons();
  }

  render() {
    const {
      categories,
      handleCategorySelection,
      links,
      possibleVettigeVrijdagSlug,
      haveCategoriesLoaded,
    } = this.props;

    function handleClick(event, categoryId) {
      event.preventDefault();
      handleCategorySelection(categoryId);
    }

    if (!haveCategoriesLoaded) {
      return (
        <nav className="col-md-4 fixed-bottom d-md-flex flex-row bg-dark nav navbar-dark h-md-100vh p-0 navbar-menu">
          <div className="h-100 w-100 d-md-flex flex-md-column">
            <OrderLogo
              possibleVettigeVrijdagSlug={possibleVettigeVrijdagSlug}
            />
            <div className="navbar-nav w-100 flex-row flex-md-column d-md-flex flex-grow-1 {% block statusclass %}{% endblock statusclass %}">
              <a
                href=""
                className="flex-fill d-flex align-items-center nav-link nav-link-big nav-link-hamburger"
                id="category-menu"
              >
                <span className="d-none d-md-block text">
                  ...loading categories
                </span>
              </a>
            </div>
          </div>
        </nav>
      );
    }
    return (
      <nav className="col-md-4 fixed-bottom d-md-flex flex-row bg-dark nav navbar-dark h-md-100vh p-0 navbar-menu">
        <div className="h-100 w-100 d-md-flex flex-md-column">
          <OrderLogo
            possibleVettigeVrijdagSlug={possibleVettigeVrijdagSlug}
          />
          <div className="navbar-nav w-100 flex-row flex-md-column d-md-flex flex-grow-1 {% block statusclass %}{% endblock statusclass %}">
            {categories.map((category) => (
              <a
                href=""
                className="flex-fill d-flex align-items-center nav-link nav-link-big nav-link-hamburger"
                key={category.id}
                onClick={(event) => {
                  handleClick(event, category.id);
                }}
                id="category-menu"
              >
                <img
                  className="menu-image"
                  src={`${links.uploadedImagesDirectory}/${category.image}`}
                />
                <img
                  className="menu-icon d-md-none icon mx-auto"
                  src={`${links.uploadedIconsDirectory}/${category.icon}`}
                />
                <span className="d-none d-md-block text">
                  {category.name}
                </span>
              </a>
            ))}
          </div>
        </div>
      </nav>
    );
  }
}

export default withContext(OrderNav);

OrderNav.propTypes = {
  categories: PropTypes.array.isRequired,
  handleCategorySelection: PropTypes.func.isRequired,
  links: PropTypes.object.isRequired,
  possibleVettigeVrijdagSlug: PropTypes.string.isRequired,
  haveCategoriesLoaded: PropTypes.bool.isRequired,
};
