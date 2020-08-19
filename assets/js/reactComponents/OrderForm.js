import React, {Component, Fragment} from 'react';
import PropTypes from 'prop-types';
import axios from 'axios';
import OrderBasketEmpty from './OrderBasketEmpty';
import OrderBasketFilled from './OrderBasketFilled';
import Search from './Search';
import ConfirmButton from './ConfirmButton';
import setLocalStorageItem from '../Utilities/setLocalStorageItem';
import getLocalStorageItemIfExists from '../Utilities/getLocalStorageItemIfExists';
import withContext from './withContext';

class OrderForm extends Component {
    constructor(props) {
        super(props);
        this.state = {
            customerName: '',
        };
        this.handleCustomerNameInput = this.handleCustomerNameInput.bind(
            this,
        );
    }

    componentDidMount() {
        this.setState({
            customerName: getLocalStorageItemIfExists(
                'customerName',
                'string',
            ),
        });
    }

    handleCustomerNameInput(event) {
        setLocalStorageItem('customerName', event.target.value);
        this.setState({customerName: event.target.value});
    }

    render() {
        const {
            orderBasket,
            handleRemoveFromBasket,
            categories,
            handleAddToBasket,
            links,
            possibleVettigeVrijdagSlug,
            orderErrorMessage,
            setOrderErrorMessage,
        } = this.props;

        async function confirmOrder(customerName) {
            const orderBasketFormatted = orderBasket.map((element) => {
                return {
                    productId: element.product.id,
                    amount: element.amount,
                };
            });
            try {
                const resp = await axios.post(
                    `${links.submit_order}/${possibleVettigeVrijdagSlug}`,
                    {name: customerName, orderLines: orderBasketFormatted},
                    {headers: {'Content-Type': 'application/json'}},
                );
                window.location.replace(`${links.confirm_order}?customerName=${customerName}`);
                // resets
                const orderBasketEmpty = [];
                setLocalStorageItem('orderBasket', orderBasketEmpty);
            } catch (err) {
                setOrderErrorMessage(err.response.data)
            }
        }

        return (
            <Fragment>
                <p>
                    {orderErrorMessage != '' ? orderErrorMessage : null}
                </p>
                <form action="" className="my-5">
                    <p className="text-center form-intro">Bestelling van</p>
                    <div className="form-group">
                        <label htmlFor="name" className="sr-only">
                            Naam
                        </label>
                        <input
                            type="text"
                            className="form-control name-field"
                            name="name"
                            id="name"
                            placeholder=""
                            required
                            value={
                                this.state.customerName !== ''
                                    ? this.state.customerName
                                    : ''
                            }
                            onChange={(event) => this.handleCustomerNameInput(event)}
                        />
                        <small>Vul hier je naam in</small>
                    </div>

                    <div className="order-list-wrapper bg-white text-dark mb-3 mt-5 p-3 p-xl-4">
                        {orderBasket.length !== 0 ? (
                            <OrderBasketFilled
                                orderBasket={orderBasket}
                                handleRemoveFromBasket={handleRemoveFromBasket}
                            />
                        ) : (
                            <OrderBasketEmpty/>
                        )}
                    </div>

                    <label htmlFor="add" className="d-block">
                        Toevoegen aan mijn bestelling
                    </label>
                    <Search
                        categories={categories}
                        handleAddToBasket={handleAddToBasket}
                    />
                    {orderBasket.length !== 0 &&
                    this.state.customerName !== '' ? (
                        <ConfirmButton
                            customerName={this.state.customerName}
                            confirmOrder={confirmOrder}
                        />
                    ) : null}
                </form>
            </Fragment>
        )
            ;
    }
}

export default withContext(OrderForm);

OrderForm.propTypes = {
    orderBasket: PropTypes.array.isRequired,
    handleAddToBasket: PropTypes.func.isRequired,
    handleRemoveFromBasket: PropTypes.func.isRequired,
    categories: PropTypes.array.isRequired,
    possibleVettigeVrijdagSlug: PropTypes.string.isRequired,
    links: PropTypes.object.isRequired,
    setOrderErrorMessage: PropTypes.func.isRequired,
    orderErrorMessage: PropTypes.string.isRequired,
};
