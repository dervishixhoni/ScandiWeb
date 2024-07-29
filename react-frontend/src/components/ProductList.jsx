import { useEffect, useState } from 'react';
import axios from 'axios';

function ProductList() {
  const [products, setProducts] = useState([]);

  useEffect(() => {
    axios.get('http://localhost:8000/api.php')
      .then(response => {
        setProducts(response.data.products);
      })
      .catch(error => {
        console.error('There was an error fetching the products!', error);
      });
  }, []);

  const handleDelete = () => {
    const selectedIDs = products.filter(product => product.isChecked).map(product => product.id);
    axios.delete('http://localhost:8000/api.php', { data: { ids: selectedIDs } })
      .then(() => {
        setProducts(products.filter(product => !selectedIDs.includes(product.id)));
      })
      .catch(error => {
        console.error('There was an error deleting the products!', error);
      });
  };

  return (
    <div>
      <h1>Product List</h1>
      <button onClick={() => window.location.href = '/add-product'}>ADD</button>
      <button onClick={handleDelete}>MASS DELETE</button>
      <ul>
        {products.map(product => (
          <li key={product.id}>
            <input
              type="checkbox"
              className="delete-checkbox"
              checked={product.isChecked || false}
              onChange={() => setProducts(products.map(p => p.sku === product.sku ? { ...p, isChecked: !p.isChecked } : p))}
            />
            {product.sku} - {product.name} - ${product.price} - {product.specificAttribute}
          </li>
        ))}
      </ul>
    </div>
  );
}

export default ProductList;