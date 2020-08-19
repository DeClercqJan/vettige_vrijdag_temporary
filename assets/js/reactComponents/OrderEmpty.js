import React from 'react';

export default function OrderEmpty() {
  return (
    <div className="col-md-8 col-lg-5 offset-md-4 mh-100vh bg-wrapper bg-image bg-hungry">
      <div className="content mt-md-4">
        {/* {% block content %} */}
        <h2 className="mr-5">Yes! ‘t Is weer vettige vrijdag!</h2>
        <div className="here-menu">
          <p>Stel hier je bestelling samen</p>
          <div className="arrow arrow-menu-md d-none d-md-block">
            <div className="arrow-body" />
          </div>
        </div>
        <p className="here-order d-lg-none">
          Hier vind je jouw bestelling
        </p>
        {/* {% endblock content %} */}
      </div>

      <div className="arrow arrow-order d-lg-none">
        <div className="arrow-body" />
      </div>

      <div className="arrow arrow-menu d-md-none">
        <div className="arrow-body" />
      </div>
    </div>
  );
}
