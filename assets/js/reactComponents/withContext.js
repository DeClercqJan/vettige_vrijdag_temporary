import React from 'react';
import MyContext from './MyContext';

export default function withContext(Component) {
  return function contextComponent(props) {
    return (
      <MyContext.Consumer>
        {(context) => <Component {...props} links={context.links} />}
      </MyContext.Consumer>
    );
  };
}
