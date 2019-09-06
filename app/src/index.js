import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import {Switch, BrowserRouter, Route, Link} from "react-router-dom";
import PeepNav from './shared/components/PeepNav';
import Footer from './shared/components/Footer';
import Home from './pages/Home';
import MyProfile from './pages/MyProfile';
import SignUpForm from './pages/sign-up/SignUpForm';
import FourOhFour from './pages/FourOhFour';


function App() {
	return (
		<>
			<PeepNav/>
			<BrowserRouter>
				<Switch>
					<Route exact path="/" component={Home}/>
					<Route exact path="/my-profile" component={MyProfile} />
					<Route exact path="/sign-up" component={SignUpForm}/>
					<Route exact path="/FourOhFour" component={FourOhFour}/>
				</Switch>
			</BrowserRouter>
			<Footer/>
		</>
	);
}

ReactDOM.render(<App/>, document.getElementById('root'));

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://bit.ly/CRA-PWA
