import React from 'react';
import PropTypes from 'prop-types';
import Sumos_dark from '../../images/sumos_dark.svg';
import Sumos_white from '../../images/sumos_white.svg';
import withContext from './withContext';

function OrderLogo(props) {
  return (
    <div className="fixed-top bg-light p-md-static bg-md-dark">
      <a
        href={`${props.links.order_home}/${props.possibleVettigeVrijdagSlug}`}
        className="navbar-brand d-flex justify-content-center pt-3 pt-md-0 my-md-5 mx-md-2 w-100"
      >
        <div className="d-flex align-items-center flex-column">
          <img
            src={`${props.links.baseUrl}${Sumos_dark}`}
            alt="Sumo's"
            className="d-md-none"
          />
          <img
            src={`${props.links.baseUrl}${Sumos_white}`}
            alt="Sumo's"
            className="d-none d-md-inline-block"
          />
          <p className="text-center">
            <span className="d-md-none">Vettige vrijdag</span>
            <span className="d-none d-md-inline">
              Vettige
              <br />
              vrijdag
            </span>
          </p>
        </div>
      </a>
    </div>
  );
}

export default withContext(OrderLogo);

OrderLogo.propTypes = {
  links: PropTypes.object.isRequired,
  possibleVettigeVrijdagSlug: PropTypes.string.isRequired,
};
