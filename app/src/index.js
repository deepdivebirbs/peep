import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import { Switch, BrowserRouter, Route, Link } from "react-router-dom";
import PeepNav from './components/PeepNav';
import Footer from './components/Footer';
import Home from './components/Home';
import MyProfile from './components/MyProfile';
import SignUpForm from './components/SignUpForm';

function App() {
	return (
		<div className="App">
			<PeepNav/>
			<BrowserRouter>
				<Switch>
					<Route exact path="/" component={Home}/>
					<Route exact path="/my-profile" component={MyProfile} />
					<Route exact path="/sign-up" component={SignUpForm}/>
				</Switch>
			</BrowserRouter>
			<Footer/>
		</div>
	);
}

ReactDOM.render(<App />, document.getElementById('root'));

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://bit.ly/CRA-PWA
