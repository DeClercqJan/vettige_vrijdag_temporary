import React, { Component } from 'react';

import AsyncSelect from 'react-select/async';
// import { colourOptions } from './docs/data';

// type State = {
//     inputValue: string,
// };

export default class TestReactSelect extends Component {
  constructor(props) {
    super(props);
    // Don't call this.setState() here!
    this.state = { inputValue: '' };
    this.handleInputChange = this.handleInputChange.bind(this);
  }

  handleInputChange(newValue) {
    const inputValue = newValue.replace(/\W/g, '');
    this.setState({
      inputValue,
    });
    return inputValue;
  }

  render() {
    // const colourOptions = [
    //     { value: 'ocean', label: 'Ocean', color: '#00B8D9', isFixed: true },
    //     { value: 'blue', label: 'Blue', color: '#0052CC', isDisabled: true },
    //     { value: 'purple', label: 'Purple', color: '#5243AA' },
    //     { value: 'red', label: 'Red', color: '#FF5630', isFixed: true },
    //     { value: 'orange', label: 'Orange', color: '#FF8B00' },
    //     { value: 'yellow', label: 'Yellow', color: '#FFC400' },
    //     { value: 'green', label: 'Green', color: '#36B37E' },
    //     { value: 'forest', label: 'Forest', color: '#00875A' },
    //     { value: 'slate', label: 'Slate', color: '#253858' },
    //     { value: 'silver', label: 'Silver', color: '#666666' },
    // ]

    const colourOptionsRaw = [
      {
        id: 1,
        name: 'snack',
        icon: 'snack-small-5efe3302ac4a1.svg',
        image: 'snack-big-5efe3302a8c64.svg',
        products: [
          {
            id: 2,
            name: 'worstenbroodje',
          },
          {
            id: 4,
            name: 'seitanbroodje',
          },
          {
            id: 5,
            name: 'korv och dryck',
          },
        ],
      },
      {
        id: 2,
        name: 'saus',
        icon: 'sauce-big-5efe330f2ee13.svg',
        image: 'sauce-big-5efe330f2ec75.svg',
        products: [
          {
            id: 1,
            name: 'mayo',
          },
          {
            id: 3,
            name: 'ketjap',
          },
        ],
      },
    ];

    const colourOptionsSemiProcessed = [];

    colourOptionsRaw.forEach((option) => {
      // console.log(option);
      option.products.forEach((product) => {
        colourOptionsSemiProcessed.push(product);
      });
    });

    const colourOptions = [];

    colourOptionsSemiProcessed.map((option) => {
      const colourOption = {
        value: option.name,
        label: option.name,
        id: option.id,
      };
      colourOptions.push(colourOption);
    });

    const filterColors = (inputValue) =>
      colourOptions.filter((i) =>
        i.label.toLowerCase().includes(inputValue.toLowerCase()),
      );

    const loadOptions = (inputValue, callback) => {
      setTimeout(() => {
        callback(filterColors(inputValue));
      }, 1000);
    };

    return (
      <div>
        <pre>
inputValue: "{this.state.inputValue}
"
</pre>
        <AsyncSelect
          cacheOptions
          loadOptions={loadOptions}
          defaultOptions
          onInputChange={this.handleInputChange}
        />
      </div>
    );
  }
}
