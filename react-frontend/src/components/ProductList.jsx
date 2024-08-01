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
    <div className='w-75 m-auto my-3'>
      <div className="d-flex justify-content-between align-items-center border-3 border-black border-bottom pb-2 mb-4">
        <h1>Product List</h1>
        <div>
          <button className="btn btn-primary me-2" onClick={() => window.location.href = '/add-product'}>ADD</button>
          <button className="btn btn-danger" onClick={handleDelete}>MASS DELETE</button>
        </div>
      </div>
      <div className='row g-3'>
        {products.map(product => (
          <div className='col-12 col-sm-6 col-md-6 col-lg-3' key={product.id}>
            <div className='card border-3 border-black rounded-2 h-100'>
              <div className='card-body text-center p-4'>
                <input
                  type="checkbox"
                  className="delete-checkbox"
                  checked={product.isChecked || false}
                  onChange={() => setProducts(products.map(p => p.sku === product.sku ? { ...p, isChecked: !p.isChecked } : p))} />
                <p className='mb-1 fs-5 fw-bold'>{product.sku}</p>
                <p className='mb-1 fs-5 fw-bold'>{product.name}</p>
                <p className='mb-1 fs-5 fw-bold'>${product.price}</p>
                <p className='mb-1 fs-5 fw-bold'>{product.specificAttribute}</p>
              </div>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}

export default ProductList;
