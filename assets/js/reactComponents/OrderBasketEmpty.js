import React from 'react';
import PropTypes from 'prop-types';
import SadSumo from '../../images/sad-sumo.svg';
import withContext from './withContext';

function OrderBasketEmpty(props) {
  return (
    <p className="mb-0 text-muted">
      Je hebt nog niets gekozen
      <img
        src={`${props.links.baseUrl}${SadSumo}`}
        className="sad-sumo ml-2"
        alt=""
      />
      <img src="" className="sad-sumo ml-2" alt="" />
    </p>
  );
}

export default withContext(OrderBasketEmpty);

OrderBasketEmpty.propTypes = {
  links: PropTypes.object.isRequired,
};
