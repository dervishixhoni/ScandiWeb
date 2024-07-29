// react-frontend/src/App.js

import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import ProductList from './components/ProductList';
import AddProduct from './components/AddProduct';

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/" exact element={<ProductList/>} />
        <Route path="/add-product" element={<AddProduct/>} />
      </Routes>
    </Router>
  );
}

export default App;