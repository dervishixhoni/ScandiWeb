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
    axios.post('http://localhost:8000/api.php', product)
      .then(() => {
        window.location.href = '/';
      })
      .catch(error => {
        console.error('There was an error adding the product!', error);
      });
  };

  return (
    <form id="product_form" onSubmit={handleSubmit}>
      <input id="sku" type="text" value={sku} onChange={e => setSku(e.target.value)} placeholder="SKU" required />
      <input id="name" type="text" value={name} onChange={e => setName(e.target.value)} placeholder="Name" required />
      <input id="price" type="number" value={price} onChange={e => setPrice(e.target.value)} placeholder="Price" required />
      <select id="type" value={productType} onChange={e => setProductType(e.target.value)} required>
        <option value="DVD">DVD</option>
        <option value="Book">Book</option>
        <option value="Furniture">Furniture</option>
      </select>
      {productType === 'DVD' && (
        <input id="size" type="number" value={specificAttribute} onChange={e => setSpecificAttribute(e.target.value)} placeholder="Size (MB)" required />
      )}
      {productType === 'Book' && (
        <input id="weight" type="number" value={specificAttribute} onChange={e => setSpecificAttribute(e.target.value)} placeholder="Weight (Kg)" required />
      )}
      {productType === 'Furniture' && (
        <>
          <input id="height" type="number" value={specificAttribute.height} onChange={e => setSpecificAttribute({ ...specificAttribute, height: e.target.value })} placeholder="Height" required />
          <input id="width" type="number" value={specificAttribute.width} onChange={e => setSpecificAttribute({ ...specificAttribute, width: e.target.value })} placeholder="Width" required />
          <input id="length" type="number" value={specificAttribute.length} onChange={e => setSpecificAttribute({ ...specificAttribute, length: e.target.value })} placeholder="Length" required />
        </>
      )}
      <button type="submit">Save</button>
      <button type="button" onClick={() => window.location.href = '/'}>Cancel</button>
    </form>
  );
}

export default AddProduct;