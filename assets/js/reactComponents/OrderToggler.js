import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { Toggle } from '../Utilities/Toggle';

export default class OrderToggler extends Component {
  componentDidMount() {
    new Toggle();
  }

  render() {
    const { registerToggleClosed } = this.props;

    function handleOnClick() {
      registerToggleClosed();
    }

    return (
      <div
        className="order-toggler d-lg-none"
        data-toggle="toggler"
        onClick={() => {
          handleOnClick();
        }}
      >
        <span className="sr-only">Toggle order</span>
        <div className="d-flex flex-row">
          <div className="dots">
            <span className="icon-dot top-dot" />
            <span className="icon-dot middle-dot" />
            <span className="icon-dot bottom-dot" />
          </div>
          <div className="bars">
            <span className="icon-bar top-bar" />
            <span className="icon-bar middle-bar" />
            <span className="icon-bar bottom-bar" />
          </div>
        </div>
      </div>
    );
  }
}

OrderToggler.propTypes = {
  registerToggleClosed: PropTypes.func.isRequired,
};
