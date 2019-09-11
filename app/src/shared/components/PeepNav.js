import React, {useEffect} from 'react';
import {Row, Col, Navbar, Nav, Form} from 'react-bootstrap';
import LogInModal from "../../pages/sign-in/LogInModal";
import {httpConfig} from "../utils/http-config";



export const PeepNav = () => {
	useEffect( () => {
		httpConfig.get("/apis/earl-grey/")
	});

	return (
		<>
			<Navbar sticky="top" bg="dark" expand="lg">
				<Navbar.Brand href="/">Peep</Navbar.Brand>
				<Navbar.Toggle aria-controls="basic-navbar-nav"/>
				<Navbar.Collapse id="basic-navbar-nav">
					<Nav className="mr-auto">
						<Nav.Link href="/">Home</Nav.Link>
						<Nav.Link href="/my-profile">My Profile</Nav.Link>
						<Nav.Link href="/MySightings">My Sightings</Nav.Link>
						<Nav.Link href="/SightingForm">Add Sighting</Nav.Link>
						<Nav.Link href="/view-species">View Species</Nav.Link>
					</Nav>
					<Form inline>
						<div>
							<LogInModal />
						</div>
					</Form>
				</Navbar.Collapse>
			</Navbar>
		</>
	);
}; 

export default PeepNav;
