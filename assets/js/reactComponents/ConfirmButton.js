import React from 'react';
import PropTypes from 'prop-types';

export default function ConfirmButton(props) {
  const { customerName, confirmOrder } = props;

  function handleOnClick(event, customerName) {
    event.preventDefault();
    confirmOrder(customerName);
  }

  return (
    <div className="d-flex justify-content-end">
      <div className="btn-submit-wrapper">
        <a
          href=""
          type="submit"
          className="btn btn-submit btn-lg"
          onClick={(event) => {
            handleOnClick(event, customerName);
          }}
        >
          Bestellen!
        </a>
      </div>
    </div>
  );
}

ConfirmButton.propTypes = {
  customerName: PropTypes.string.isRequired,
  confirmOrder: PropTypes.func.isRequired,
};
