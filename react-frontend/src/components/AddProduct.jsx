import {useEffect, useState} from 'react';
import axios from 'axios';

function AddProduct() {
    const [sku, setSku] = useState('');
    const [name, setName] = useState('');
    const [price, setPrice] = useState('');
    const [productType, setProductType] = useState('DVD');
    const [specificAttribute, setSpecificAttribute] = useState('');
    const [errors, setErrors] = useState([]);
    const [showNotification, setShowNotification] = useState(false);

    const validateForm = async () => {
        const errors = [];

        if (!sku.trim()) errors.push('SKU is required.');
        else {
            const response = await axios.post('http://localhost:8000/checksku.php', {'sku': sku});
            if (!response.data.isSkuUnique) errors.push('SKU must be unique.');
        }

        if (!name.trim()) errors.push('Name is required.');
        if (!price || isNaN(price) || parseFloat(price) <= 0) errors.push('Valid price is required.');

        if (productType === 'DVD' && (!specificAttribute || isNaN(specificAttribute) || parseFloat(specificAttribute) <= 0)) {
            errors.push('Valid size is required for DVD.');
        }

        if (productType === 'Book' && (!specificAttribute || isNaN(specificAttribute) || parseFloat(specificAttribute) <= 0)) {
            errors.push('Valid weight is required for Book.');
        }

        if (productType === 'Furniture') {
            const {height, length, width} = specificAttribute;
            if (!height || isNaN(height) || parseFloat(height) <= 0) errors.push('Valid height is required for Furniture.');
            if (!length || isNaN(length) || parseFloat(length) <= 0) errors.push('Valid length is required for Furniture.');
            if (!width || isNaN(width) || parseFloat(width) <= 0) errors.push('Valid width is required for Furniture.');
        }

        return errors;
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        const errors = await validateForm();

        if (errors.length > 0) {
            setErrors(errors);
            setShowNotification(true);
            return;
        }

        const product = {
            sku,
            name,
            price,
            productType,
            specificAttribute
        };

        axios.post('http://localhost:8000/api.php', product)
            .then(() => {
                window.location.href = '/';
            })
            .catch(error => {
                console.error('There was an error adding the product!', error);
            });
    };

    useEffect(() => {
        if (showNotification) {
            const timer = setTimeout(() => {
                setShowNotification(false);
            }, 3000);

            return () => clearTimeout(timer);
        }
    }, [showNotification]);

    return (
        <div className='m-auto my-3 w-75'>
            <div className="d-flex justify-content-between my-4 border-3 border-black border-bottom">
                <h1>Add Product</h1>
                <div>
                    <button className='btn btn-primary' form="product_form" type="submit">Save</button>
                    <button className='btn btn-danger' type="button" onClick={() => window.location.href = '/'}>Cancel
                    </button>
                </div>
            </div>
            {showNotification && (
                <div className="alert alert-danger fade show position-fixed bottom-0 start-50 translate-middle-x"
                     role="alert">
                    {errors.map((error, index) => (
                        <div key={index}>{error}</div>
                    ))}
                </div>
            )}
            <form id="product_form" onSubmit={handleSubmit}>
                <div className="mb-3">
                    <label htmlFor='sku' className='form-label'>SKU:</label>
                    <input id="sku" type="text" value={sku} onChange={e => setSku(e.target.value)} placeholder="SKU"/>
                </div>
                <div className="mb-3">
                    <label htmlFor='name' className='form-label'>Name:</label>
                    <input id="name" type="text" value={name} onChange={e => setName(e.target.value)}
                           placeholder="Name"/>
                </div>
                <div className="mb-3">
                    <label htmlFor='price' className='form-label'>Price:</label>
                    <input id="price" type="number" value={price} onChange={e => setPrice(e.target.value)}
                           placeholder="Price"/>
                </div>
                <div className="mb-3">
                    <label htmlFor='type' className='form-label'>Type:</label>
                    <select id="productType" value={productType} onChange={e => setProductType(e.target.value)}>
                        <option value="DVD">DVD</option>
                        <option value="Book">Book</option>
                        <option value="Furniture">Furniture</option>
                    </select>
                </div>
                {productType === 'DVD' && (
                    <>
                        <div className="mb-3">
                            <label htmlFor='size' className='form-label'>Size (MB):</label>
                            <input id="size" type="number" value={specificAttribute}
                                   onChange={e => setSpecificAttribute(e.target.value)} placeholder="Size (MB)"/>
                        </div>
                        <p>Please, provide size</p>
                    </>
                )}
                {productType === 'Book' && (
                    <>
                        <div className="mb-3">
                            <label htmlFor='weight' className='form-label'>Weight (Kg):</label>
                            <input id="weight" type="number" value={specificAttribute}
                                   onChange={e => setSpecificAttribute(e.target.value)} placeholder="Weight (Kg)"/>
                        </div>
                        <p>Please, provide weight</p>
                    </>
                )}
                {productType === 'Furniture' && (
                    <>
                        <div className="mb-3">
                            <label htmlFor="height" className="form-label">Height (cm):</label>
                            <input id="height" type="number" value={specificAttribute.height || ''}
                                   onChange={e => setSpecificAttribute({...specificAttribute, height: e.target.value})}
                                   placeholder="Height (cm)"/>
                        </div>
                        <div className="mb-3">
                            <label htmlFor="length" className="form-label">Length (cm):</label>
                            <input id="length" type="number" value={specificAttribute.length || ''}
                                   onChange={e => setSpecificAttribute({...specificAttribute, length: e.target.value})}
                                   placeholder="Length (cm)"/>
                        </div>
                        <div className="mb-3">
                            <label htmlFor="width" className="form-label">Width (cm):</label>
                            <input id="width" type="number" value={specificAttribute.width || ''}
                                   onChange={e => setSpecificAttribute({...specificAttribute, width: e.target.value})}
                                   placeholder="Width (cm)"/>
                        </div>
                        <p>Please, provide dimensions</p>
                    </>
                )}
            </form>
        </div>
    );
}

export default AddProduct;