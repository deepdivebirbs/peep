import React from 'react';
import { Switch, BrowserRouter, Route, Link } from "react-router-dom";
import Container from 'react-bootstrap';
import logo from './logo.svg';
import './App.css';
import PeepNav from './components/PeepNav';
import Footer from './components/Footer';
import Home from './components/Home';
import LogIn from './components/LogInForm';
import MyProfile from './components/MyProfile';
import SignUpForm from './components/SignUpForm';

function App() {
  return (
    <div className="App">
       <PeepNav/>
       <BrowserRouter>
          <Switch>
             <Route exact path="/" component={Home}/>
             <Route exact path="/my-profile" component={MyProfile}/>
             <Route exact path="/sign-up" component={SignUpForm}/>
          </Switch>
       </BrowserRouter>
       <Footer/>
    </div>
  );
}

export default App;
