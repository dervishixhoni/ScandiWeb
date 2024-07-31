import { useState } from 'react';
import axios from 'axios';

function AddProduct() {
  const [sku, setSku] = useState('');
  const [name, setName] = useState('');
  const [price, setPrice] = useState('');
  const [productType, setProductType] = useState('DVD');
  const [specificAttribute, setSpecificAttribute] = useState('');

  const handleSubmit = (e) => {
    e.preventDefault();
    const product = {
      sku,
      name,
      price,
      productType,
      specificAttribute
    };
    axios.post('http://13.50.197.55/api/api.php', product)
      .then(() => {
        window.location.href = '/';
      })
      .catch(error => {
        console.error('There was an error adding the product!', error);
      });
  };

  return (
    <>
    <div className="d-flex justify-content-between my-4 border-3 border-black border-bottom">
        <h1>Add Product</h1>
        <div>
        <button className='btn btn-primary' type="submit">Save</button>
        <button className='btn btn-danger' type="button" onClick={() => window.location.href = '/'}>Cancel</button>
        </div>
    </div>
    <form id="product_form" onSubmit={handleSubmit}>
      <div className="mb-3">
        <label for='sku' className='form-label'>SKU:</label>
        <input id="sku" type="text" value={sku} onChange={e => setSku(e.target.value)} placeholder="SKU" required />
      </div>
      <div className="mb-3">
      <label for='sku' className='form-label'>Name:</label>
      <input id="name" type="text" value={name} onChange={e => setName(e.target.value)} placeholder="Name" required />  
      </div>
      <div className="mb-3">
      <label for='sku' className='form-label'>Price:</label>
      <input id="price" type="number" value={price} onChange={e => setPrice(e.target.value)} placeholder="Price" required />
      </div>
      <div className="mb-3">
        <label for='type' className='from-label'>Type</label>
      <select id="#productType" value={productType} onChange={e => setProductType(e.target.value)} required>
        <option value="DVD">DVD</option>
        <option value="Book">Book</option>
        <option value="Furniture">Furniture</option>
      </select>
      </div>
      {productType === 'DVD' && (
        <div className="mb-3">
        <label for='size' className='from-label'>Size</label>
        <input id="size" type="number" value={specificAttribute} onChange={e => setSpecificAttribute(e.target.value)} placeholder="Size (MB)" required />
        </div>
      )}
      
      {productType === 'Book' && (
        <div className="mb-3">
        <label for='weight' className='form-label'>Weight:</label>
      <input id="weight" type="number" value={specificAttribute} onChange={e => setSpecificAttribute(e.target.value)} placeholder="Weight (Kg)" required />
      </div>  
      )}
      {productType === 'Furniture' && (
        <>
        <div className="mb-3">
          <label for="height" className="form-label">Height:</label>
          <input id="height" type="number" value={specificAttribute.height} onChange={e => setSpecificAttribute({ ...specificAttribute, height: e.target.value })} placeholder="Height" required />    
        </div>
        <div className="mb-3">
        <label for="length" className="form-label">Length:</label>
      <input id="length" type="number" value={specificAttribute.length} onChange={e => setSpecificAttribute({ ...specificAttribute, length: e.target.value })} placeholder="Length" required />
      </div>
          <div className="mb-3">
        <label for="width" className="form-label">Width:</label>
      <input id="width" type="number" value={specificAttribute.width} onChange={e => setSpecificAttribute({ ...specificAttribute, width: e.target.value })} placeholder="Width" required />
      </div>
        </>
      )}
    </form>
    </>
  );
}

export default AddProduct;
