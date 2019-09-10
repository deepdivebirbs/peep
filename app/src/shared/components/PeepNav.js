import React, {useEffect} from 'react';
import {Navbar, Nav, NavDropdown, Form, FormControl, Button} from 'react-bootstrap';
import LogInModal from "../../pages/sign-in/LogInModal";
import {httpConfig} from "../utils/http-config";


export const PeepNav = () => {
	useEffect( () => {
		 httpConfig.get("/apis/earl-grey/")
	});

	return (
		<>
			<Navbar bg="dark" expand="lg">
				<Navbar.Brand href="/">Peep</Navbar.Brand>
				<Navbar.Toggle aria-controls="basic-navbar-nav"/>
				<Navbar.Collapse id="basic-navbar-nav">
					<Nav className="mr-auto">
						<Nav.Link href="/">Home</Nav.Link>
						<Nav.Link href="/my-profile">My Profile</Nav.Link>
						<Nav.Link href="#">My Sightings</Nav.Link>
						<Nav.Link href="/add-sighting">Add Sighting</Nav.Link>
						<LogInModal state={"false"}/>

					</Nav>
					<Form inline>
						<div>
							<p>Profile Pic</p>
						</div>
					</Form>
				</Navbar.Collapse>
			</Navbar>
		</>
	);
};

export default PeepNav;