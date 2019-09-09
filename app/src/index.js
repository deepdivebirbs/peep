import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import {Switch, BrowserRouter, Route, Link} from "react-router-dom";
import PeepNav from './shared/components/PeepNav';
import Footer from './shared/components/Footer';
import Home from './pages/Home';
import MyProfileForm from './pages/user-profile/MyProfileForm';
import SignUpForm from './pages/sign-up/SignUpForm';
import FourOhFour from './pages/FourOhFour';
import sightingcontent from './pages/sighting/sightingcontent';
import MyProfile from './pages/user-profile/MyProfile';


function App() {
	return (
		<>
			<PeepNav/>
			<a href="/sighting">Sighting</a>
			<BrowserRouter>
				<Switch>
					<Route exact path="/" component={Home}/>
					<Route exact path="/my-profile" component={MyProfile}/>
					<Route exact path="/sign-up" component={SignUpForm}/>
					<Route exact path="/FourOhFour" component={FourOhFour}/>
					<Route exact path="/sighting" component={sightingcontent}/>
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
