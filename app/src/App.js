import React from 'react';
import Container from 'react-bootstrap';
import logo from './logo.svg';
import './App.css';
import PeepNav from './components/PeepNav';
import Footer from './components/Footer';
import Home from './components/Home';
import LogIn from './components/LogInForm';
import Profile from './components/Profile';

function App() {
  return (
    <div className="App">
       <PeepNav/>
       <Home/>
       <Footer/>
       <Profile/>
    </div>
  );
}

export default App;
