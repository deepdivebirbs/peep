import React from 'react';
import Container from 'react-bootstrap';
import logo from './logo.svg';
import './App.css';
import PeepNav from './components/PeepNav';
import Footer from './components/Footer';
import Home from './components/Home';

function App() {
  return (
    <div className="App">
       <PeepNav/>
       <Home/>
       <Footer/>
    </div>
  );
}

export default App;
